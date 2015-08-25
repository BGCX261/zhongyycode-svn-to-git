<?php
/**
 * 模块 Acl_Rule
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-31
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Acl_Rule extends ORM{


    /**
     * 当前模块名称
     *
     * @var string
     */
    protected $_modName = null;

    /**
     * 当前模块名称 说明
     *
     * @var string
     */
    public $modDesc = null;

    /**
     * 设置主健
     *
     */
    public $_primary_key = 'rule_id';


    /**
     * 分组获取权限规则
     *
     * @return array
     */
    public function getRuleGroup()
    {
        $rows = DB::select('rule.rule_id', 'res.mod_name', 'res.res_name', 'res.res_desc',  'priv.priv_name', 'priv.priv_desc')
            ->from(array('acl_rules' ,'rule'))
            ->join(array('acl_resources', 'res'))
            ->on('res.res_name', '=', 'rule.res_name')
            ->join(array('acl_privileges','priv'))
            ->on('priv.priv_name', '=', 'rule.priv_name')
            ->where('res.mod_name', '=', $this->_modName)
            ->order_by('res.res_name', 'ASC')
            ->order_by('priv.priv_name', 'ASC')
            ->execute()
            ->as_array();
        $group = array();
        foreach ($rows as $row) {
            $group['resource'][$row['res_name']] = $row['res_desc'];
            $group['rule'][$row['res_name']][$row['priv_name']] = $row['rule_id'];
            $group['privilege'][$row['priv_name']] = $row['priv_desc'];
        }
        return $group;
    }

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
     * 添加新的规则 (批量)
     *
     * @param  array  $data
     * @throws EGP_Exception
     */
    public function addRule(array $data)
    {
        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('res_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('res_name', 'min_length', array('2'))
            ->rule('res_name', 'max_length', array('20'))
            ->rule('res_name', 'not_empty')
            ->rule('res_desc', 'not_empty');
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/rule')));
        }
        $aclResource = ORM::factory('acl_resource');
        if ($aclResource->setModule($this->_modName)->resExists($data['res_name'])) {
            throw new Exception("资源名称已经存在 '{$data['res_name']}'");
        }
       $aclResource->mod_name = $this->_modName;
       $aclResource->values($data)->save();
       foreach ($data['privileges'] as $privName) {
           $this->_addRule($data['res_name'], $privName);
       }
       Cache::instance()->delete('acl_resources');
    }

    /**
     * 查询规则是否已经存在
     *
     * @param  string  $resName
     * @param  string  $privName
     */
    public function resHasPriv($resName, $privName)
    {
        $count = DB::select(DB::expr('COUNT(*) as count'))
            ->from(array('acl_rules', 'rule'))
            ->join(array('acl_resources', 'res'))
            ->on('res.res_name', '=', 'rule.res_name')
            ->where('res.mod_name', '=', $this->_modName)
            ->where('rule.res_name', '=', $resName)
            ->where('rule.priv_name', '=', $privName)
            ->execute()->get('count');
        return $count > 0;
    }

    /**
     * 追加权限
     *
     * @param  string  $resName
     * @param  string  $privName
     * @throws EGP_Exception
     */
    public function append($resName, $privName)
    {
        $aclResource = ORM::factory('acl_resource');

        if (!$aclResource->setModule($this->_modName)->resExists($resName)) {
            throw new Exception("资源 '$resName' 不存在或者已经被删除");
        }

        $privilege = ORM::factory('acl_Privilege');
        if (!$privilege->exists($privName)) {
            throw new Exception("权限 '$privName' 不存在或者已经被删除");
        }

        if ($this->resHasPriv($resName, $privName)) {
            throw new Exception("资源 '$resName' 下已经存在 '$privName' 这个权限了");
        }

        $this->_addRule($resName, $privName);

        Cache::instance()->delete('acl_resources');
    }

    /**
     * 添加规则
     *
     * @param  string  $resName
     * @param  string  $privName
     */
    protected function _addRule($resName, $privName)
    {

        $result = DB::insert('acl_rules',array('res_name', 'priv_name'))->values(array($resName, $privName))->execute();

        $ruleId = $result[0];

        $roleModel = ORM::factory('acl_role')->setModule($this->_modName);
        $roleList = $roleModel->getAll();

        $data = array();
        if (!empty($roleList)) {
            foreach ($roleList as $role) {
                DB::insert('acls', array('rule_id', 'role_id', 'permit'))->values(array($ruleId, $role['role_id'], 0))->execute();
            }
        }

    }


    /**
     * 删除规则
     *
     * @param  array  $rules
     */
    public function delRule($rules)
    {
        if (!is_array($rules)) {
            $rules = array($rules);
        }


        $checkRes = $this->where('rule_id', 'IN', $rules)->distinct('rule_id')->find_all();

        DB::delete('acl_rules')->where('rule_id', 'IN', $rules)->execute(); //删除规则
        DB::delete('acls')->where('rule_id', 'IN', $rules)->execute(); //删除访问控制表

        foreach ($checkRes as $resName) {
            $this->resClean($resName->res_name);
        }
    }

    /**
     * 清除没有被规则使用的资源
     *
     * @param  string  $resName
     */
    public function resClean($resName)
    {
        $count = DB::select(DB::expr('COUNT(*) as counts'))
            ->from(array('acl_rules','rule'))
            ->join(array('acl_resources', 'res'))
            ->on('res.res_name', '=', 'rule.res_name')
            ->where('res.res_name', '=', $resName)
            ->where('res.mod_name', '=', $this->_modName)
            ->execute()->get('counts');
        if ($count == 0) {
            DB::delete('acl_resources')->where('res_name', '=', $resName)->where('mod_name', '=', $this->_modName)->execute(); //删除资源
        }
        Cache::instance()->delete('acl_resources');
    }

}