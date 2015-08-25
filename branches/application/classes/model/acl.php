<?php
/**
 * 模块 Model
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-31
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Acl extends ORM{


    /**
     * 设置主健
     *
     */
    public $_primary_key = 'acl_id';

    /**
     * 模块名称
     */
    protected $_modName = null;

    /**
     * 模块名称说明
     */
    public $modDesc = null;

    /**
     * 设置所属模块
     *
     * @param  string  $modName
     * @throws EGP_Exception
     */
    public function setModule($modName)
    {
        $module = ORM::factory('module');
        if (!$module->exists($modName)) {
            throw new Exception("指定的模块名称 '$modName' 不存在");
        }
        $this->_modName = $modName;
        $this->modDesc = $module->getDesc($this->_modName);
        return $this;
    }

    /**
     * 对指定的角色执行 ACL 初始化
     *
     * @param  integer  $roleId
     */
    public function initRole($roleId)
    {

        $rules = DB::select('rule.rule_id')
            ->from(array('acl_rules', 'rule'))
            ->join(array('acl_resources', 'res'))
            ->on('res.res_name', '=', 'rule.res_name')
            ->where('res.mod_name', '=', $this->_modName)
            ->execute()->as_array();
        if (!empty($rules)) {
            $data = array();
            foreach ($rules as $rule) {
                DB::insert('acls', array('rule_id', 'role_id'))->values(array($rule['rule_id'], (integer) $roleId))->execute();
            }
        }
    }

    /**
     * 获取当前角色被允许的 ACL 权限
     *
     * @param  integer  $roleId
     */
    public function getRoleAllowRule($roleId)
    {
        $rows = $this->where('role_id', '=', $roleId)->where('permit', '=', 1)->find_all();
        $result = array();
        foreach ($rows as $row) {
            $result[] = $row->rule_id;
        }
        return $result;
    }

    /**
     * 指派权限
     *
     * @param  integer  $roleId
     * @param  mixed    $rules
     * @param  boolean  $resetOther
     */
    public function assign($roleId, $rules, $resetOther = true)
    {
        if (!is_array($rules)) {
            $rules = array($rules);
        }

        if (empty($rules)) {
            return ;
        }

        if ($resetOther) {
            $set = array('permit' => '0');
            DB::update('acls')->set($set)->where('role_id', '=', (integer) $roleId)->execute();
        }

        $set = array('permit' => '1');
        DB::update('acls')->set($set)->where('role_id', '=', (integer) $roleId)->where('rule_id', 'in', $rules)->execute();
    }
}