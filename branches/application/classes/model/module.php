<?php
/**
 * 模块 Model
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-31
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Module extends ORM{

    /**
     * 当前模块名称
     *
     * @var string
     */
    protected $_modName = null;

    /**
     * 设置主健
     *
     */
    public $_primary_key = 'mod_name';
    /**
     * 所有模块
     *
     * @var array
     */
    protected static $_modules = null;

    /**
     * 获取所有模块
     *
     * @return array
     */
    public function getAll()
    {

        self::$_modules = Cache::instance()->get('acl_modules');
        if (null == self::$_modules) {
            $rows = $this->find_all();

            self::$_modules = array();
            foreach ($rows as $row) {
                self::$_modules[$row->mod_name] = $row->mod_desc;
            }
            Cache::instance()->set('acl_modules', self::$_modules, 2592000);
        }
        return self::$_modules;
    }

    /**
     * 查询模块是否存在
     *
     * @param  string  $modName
     * @return boolean
     */
    public function exists($modName)
    {
        $modules = $this->getAll();
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

        $modules = $this->getAll();
        return isset($modules[$modName]) ? $modules[$modName] : null;
    }
    /**
     * 添加模块
     *
     * @param  array  $data
     * @throws EGP_Exception
     */
    public function addmModule(array $data)
    {
        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('new_mod_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('new_mod_name', 'min_length', array('2'))
            ->rule('new_mod_name', 'max_length', array('20'))
            ->rule('new_mod_name', 'not_empty')
            ->rule('mod_desc', 'not_empty');
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/module')));
        }

        if ($this->exists($data['new_mod_name'])) {
            throw new Exception("模块名称 '{$data['new_mod_name']}' 已经存在");
        }

        $data = array(
            'mod_name' => $data['new_mod_name'],
            'mod_desc' => $data['mod_desc']
        );
        $this->values($data)->save(); //插入模块

        DB::insert('acl_roles', array('mod_name', 'role_name', 'role_desc', 'role_level','is_guest'))->values(array($data['mod_name'],'guest', '游客', '0', '1'))->execute();//插入一个游客角色
        DB::insert('acl_roles', array('mod_name', 'role_name', 'role_desc', 'role_level','is_guest'))->values(array($data['mod_name'],'user', '注册用户', '1', '1'))->execute(); // 插入一个注册用户角色

        // 删除缓存
        Cache::instance()->delete('acl_modules');
        Cache::instance()->delete('acl_resources');
        Cache::instance()->delete('acl_privileges');
        Cache::instance()->delete('acl_roles');
        Cache::instance()->delete('acl_all_default_roles');
        Cache::instance()->delete('acl_all_guest_roles');

    }

    /**
     * 编辑模块
     *
     * @param  string  $modName
     * @param  array   $data
     * @throws Exception
     */
    public function editModule($modName, array $data)
    {
        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('new_mod_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('new_mod_name', 'min_length', array('2'))
            ->rule('new_mod_name', 'max_length', array('20'))
            ->rule('new_mod_name', 'not_empty')
            ->rule('mod_name', 'min_length', array('2'))
            ->rule('mod_name', 'max_length', array('20'))
            ->rule('mod_name', 'not_empty')
            ->rule('mod_desc', 'not_empty')
;
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/module')));
        }

        if ($data['new_mod_name'] != $modName && $this->exists($data['new_mod_name'])) {
            throw new Exception("模块名称 '{$data['new_mod_name']}' 已经存在");
        }

        DB::update('acl_roles')->set(array('mod_name' => $data['new_mod_name']))->where('mod_name', '=', $modName)->execute(); //更新角色表
        DB::update('acl_resources')->set(array('mod_name' => $data['new_mod_name']))->where('mod_name', '=', $modName)->execute(); //更新资源表
        $set['mod_desc'] = $data['mod_desc'];
        $set['mod_name'] = $data['new_mod_name'];
        DB::update('user_roles')->set(array('mod_name' => $data['new_mod_name']))->where('mod_name', '=', $modName)->execute(); //用户角色表
        DB::update('modules')->set($set)->where('mod_name', '=', $modName)->execute(); //更新模块表

        // 删除缓存
        Cache::instance()->delete('acl_modules');
        Cache::instance()->delete('acl_resources');
        Cache::instance()->delete('acl_privileges');
        Cache::instance()->delete('acl_roles');
        Cache::instance()->delete('acl_all_default_roles');
        Cache::instance()->delete('acl_all_guest_roles');
    }

    /**
     * 删除模块
     *
     * @param  string  $modName
     */
    public function delModule($modName)
    {
        if (empty($modName)) {
            return ;
        }


        //获取所有的角色
       $rows = DB::select('role_id')
            ->from('acl_roles')
            ->where('mod_name', '=', $modName)
            ->execute()->as_array();
        $roles = array();
        foreach ($rows as $row) {
            $roles[] = $row['role_id'];
        }
        if (!empty($roles)) {

            DB::delete('acls')->where('role_id', 'IN', $roles)->execute(); //删除 ACL
        }

        //获取所有的资源
        $rows = DB::select('res_name')
            ->from('acl_resources')
            ->where('mod_name', '=', $modName)
            ->execute()->as_array();
        $resources = array();
        foreach ($rows as $row) {
            $resources[] = $row['res_name'];
        }
        if (!empty($resources)) {
           DB::delete('acl_rules')->where('res_name', 'IN', $resources); //删除规则
        }

        DB::delete('acl_resources')->where('mod_name', '=', $modName)->execute(); //删除资源表
        DB::delete('modules')->where('mod_name', '=', $modName)->execute(); //删除模块表
        DB::delete('acl_roles')->where('mod_name', '=', $modName)->execute(); //删除角色表
        DB::delete('user_roles')->where('mod_name', '=', $modName)->execute(); //删除角色表
        // 删除缓存
        Cache::instance()->delete('acl_modules');
        Cache::instance()->delete('acl_resources');
        Cache::instance()->delete('acl_privileges');
        Cache::instance()->delete('acl_roles');
        Cache::instance()->delete('acl_all_default_roles');
        Cache::instance()->delete('acl_all_guest_roles');
    }
    /**
     * 获取模块名称
     *
     * @return string
     */
    public function getModName()
    {
        return $this->_modName;
    }

    /**
     * 获取模块说明
     *
     * @return string
     */
    public function getModDesc()
    {
        return $this->_modDesc;
    }

}