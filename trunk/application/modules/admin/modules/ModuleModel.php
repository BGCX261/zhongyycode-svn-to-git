<?php
/**
 * 模块 Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('APP_DIR') && die('Access Deny!');

class ModuleModel extends YUN_Abstract
{
    /**
     * 所有模块
     * @var array
     */
    protected static $_modules = null;

    /**
     * 查询模块是否存在
     * @param  string  $modName
     * @return boolean
     */
    public function exists($modName)
    {
        $modules = $this->info();
        return isset($modules[$modName]);
    }

    /**
     * 获取模块说明
     *
     * @param  string  $modName
     * @return string
     */
    public function getDesc($modName)
    {
        $modules = $this->info();
        return isset($modules[$modName]) ? $modules[$modName] : null;
    }

    /**
     * 获取所有模块
     * @return array
     */
    public function info()
    {
        if (null == self::$_modules) {
            $rows = $this->db->select()
                ->from('acl_module');
            $rows = $this->db->fetchAll($rows);
            self::$_modules = array();
            foreach ($rows as $row) {
                self::$_modules[$row['mod_name']] = $row['mod_desc'];
            }
        }
        return self::$_modules;
    }

    /**
     * 添加模块
     * @param  array  $data
     * @throws YUN_Exception
     */
    public function add(array $data)
    {
        $validator = $this->_validate($data);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }

        if ($this->exists($data['new_mod_name'])) {
            throw new Exception("模块名称 '{$data['new_mod_name']}' 已经存在");
        }

        $data = array(
            'mod_name' => $data['new_mod_name'],
            'mod_desc' => $data['mod_desc']
        );
        $this->db->insert('acl_module', $data); //插入模块

        $set = array(
            'mod_name'   => $data['mod_name'],
            'role_name'  => 'guest',
            'role_desc'  => '游客',
            'role_level' => 0,
            'is_guest'   => 1,
        );
        $this->db->insert('acl_role', $set); //插入一个游客角色

        $set = array(
            'mod_name'   => $data['mod_name'],
            'role_name'  => 'user',
            'role_desc'  => '注册用户',
            'role_level' => 1,
            'is_default' => 1,
        );
        $this->db->insert('acl_role', $set); //插入一个注册用户角色
    }

    /**
     * 编辑模块
     * @param  string  $modName
     * @param  array   $data
     * @throws EGP_Exception
     */
    public function edit($modName, array $data)
    {
        $validator = $this->_validate($data);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }

        if ($data['new_mod_name'] != $modName && $this->exists($data['new_mod_name'])) {
            throw new Exception("模块名称 '{$data['new_mod_name']}' 已经存在");
        }

        $where = $this->db->quoteInto('mod_name=?', $modName);

        $set['mod_name'] = $data['new_mod_name'];
        $this->db->update('acl_role', $set, $where); //更新角色表
        $this->db->update('acl_resource', $set, $where); //更新资源表

        $set['mod_desc'] = $data['mod_desc'];
        $this->db->update('acl_module', $set, $where); //更新模块表

    }

    /**
     * 删除模块
     * @param  string  $modName
     */
    public function del($modName)
    {
        if (empty($modName)) {
            return ;
        }
        $where = $this->db->quoteInto('mod_name = ?', $modName);
        $this->db->delete('acl_module', $where); //删除模块表
    }

    /**
     * 对数据进行校验
     * @param  array  $data
     * @return EGP_Validator
     */
    protected function _validate(array $data)
    {
        $validator = new YUN_Validator();
        $validator->check(
                $data['new_mod_name'],
                array(
                    array('NotEmpty', '模块名称不允许为空'),
                    array('English', '模块名称包含除 [a-zA-Z0-9_] 之外的非法字符'),
                    array('StringLength' => array(2, 20), '模块名称必须介于 2~20 个字符之间'),
                )
            )
            ->check(
                $data['mod_desc'],
                array(
                    array('NotEmpty', '模块说明不允许为空'),
                    array('StringLength' => array(2, 80), '模块说明必须介于 2~80 个字符之间'),
                )
            );
        return $validator;
    }
}