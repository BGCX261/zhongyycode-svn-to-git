<?php
/**
 * 模块 Model acl_role
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-31
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Acl_Role extends ORM{


    /**
     * 设置主健
     *
     */
    public $_primary_key = 'role_id';

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
     * 所有游客角色
     *
     * @var array
     */
    protected static $_allGuestRoles = null;

    /**
     * 所有默认角色
     *
     * @var array
     */
    protected static $_allDefaultRoles = null;

    /**
     * 用户拥有的所有角色
     *
     * @var array
     */
    protected static $_allRoles = null;
    /**
     * 获取到角色列表
     *
     * @return EGP_Db_Select
     */
    public function getAll()
    {
        $acl_roles = Cache::instance()->get('acl_roles');
        if (null == $acl_roles) {
            $acl_roles = DB::select()
                ->from(array('acl_roles', 'role'))
                ->join('modules')
                ->on('modules.mod_name', '=', 'role.mod_name')
                ->where('role.mod_name', '=', $this->_modName)
                ->order_by('role.role_level', 'ASC')
                ->fetch_all();
            Cache::instance()->set('acl_roles', $acl_roles, 2592000);
        }

        return $acl_roles;

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
     * 查询角色 ID 是否存在
     *
     * @param  string  $roleName
     * @param  integer $roleId
     */
    public function idExists($roleId)
    {
        $row = DB::select()
            ->from(array('acl_roles', 'role'))
            ->join('modules')
            ->on('modules.mod_name', '=', 'role.mod_name')
            ->where('role.mod_name', '=', $this->_modName)
            ->where('role.role_id', '=', (integer) $roleId)
            ->execute()->current();
        return empty($row) ? false : true;
    }

    /**
     * 查询角色名称是否存在
     *
     * @param  string  $roleName
     * @param  integer $roleId
     */
    public function nameExists($roleName, $roleId = 0)
    {
        $select = DB::select()
            ->from(array('acl_roles', 'role'))
            ->join('modules')
            ->on('modules.mod_name', '=', 'role.mod_name')
            ->where('role.role_name', '=', (string) $roleName)
            ->where('role.mod_name', '=', $this->_modName);
        if ($roleId > 0) {
            $select->where('role.role_id','<>', (integer) $roleId);
        }
        $row = $select->execute()->current();
        return empty($row) ? false : true;
    }

    /**
     * 添加角色
     *
     * @param  array   $data
     * @return integer
     * @throws EGP_Exception
     */
    public function addRole(array $data)
    {
        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('role_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('role_name', 'min_length', array('2'))
            ->rule('role_name', 'max_length', array('20'))
            ->rule('role_name', 'not_empty')
            ->rule('role_level', 'numeric')
            ->rule('role_desc', 'not_empty');
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/role')));
        }

        if ($this->nameExists($data['role_name'])) {
            throw new Exception("角色名称 '{$data['role_name']}' 已经存在");
        }

        $data = array(
            'mod_name'    => $this->_modName,
            'role_name'   => $data['role_name'],
            'role_desc'   => $data['role_desc'],
            'role_level'  => $data['role_level'],
            'is_guest'    => $data['is_guest'],
            'is_default'  => $data['is_default'],
        );
        empty($data['is_guest']) && $data['is_guest'] = 0;
        empty($data['is_default']) && $data['is_default'] = 0;
        $this->mod_name = $this->_modName;
        $this->values($data)->save();
        $roleId = $this->role_id;
        if ($data['is_guest']) {
            DB::update('acl_roles')->set(array('is_guest' => 0))->where('mod_name', '=', $this->_modName)->execute();
            DB::update('acl_roles')->set(array('is_guest' => 1))->where('role_id', '=', $roleId)->execute();
        }
        if ($data['is_default']) {
            DB::update('acl_roles')->set(array('is_default' => 0))->where('mod_name', '=', $this->_modName)->execute();
            DB::update('acl_roles')->set(array('is_default' => 1))->where('role_id', '=', $roleId)->execute();
        }
        $acl = ORM::factory('acl')->setModule($this->_modName);
        $acl->initRole($roleId); //对角色执行 ACL 初始化
        return $roleId;
        Cache::instance()->delete('acl_roles');
    }

    /**
     * 编辑角色
     *
     * @param  integer  $roleId
     * @param  array    $data
     * @throws EGP_Exception
     */
    public function editRole(array $data)
    {
        $data['role_id'] = (integer) @$data['role_id'];
        if (!$this->idExists($data['role_id'])) {
            throw new Exception('指定的角色不存在');
        }

        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('role_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('role_name', 'min_length', array('2'))
            ->rule('role_name', 'max_length', array('20'))
            ->rule('role_name', 'not_empty')
            ->rule('role_level', 'numeric')
            ->rule('role_desc', 'not_empty');
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/role')));
        }

        if ($this->nameExists($data['role_name'], $data['role_id'])) {
            throw new Exception("角色名称 '{$data['role_name']}' 已经存在");
        }

       // $where = $this->db->quoteInto;
        $set = array(
            'role_name'   => $data['role_name'],
            'role_desc'   => $data['role_desc'],
            'role_level'  => $data['role_level'],
            'is_guest'    => $data['is_guest'],
            'is_default'  => $data['is_default'],
        );
        DB::update('acl_roles')->set($set)->where('role_id', '=', $data['role_id'])->execute();
        if ($data['is_guest']) {

            DB::update('acl_roles')->set(array('is_guest' => 0))->where('mod_name', '=', $this->_modName)->execute();
            DB::update('acl_roles')->set(array('is_guest' => 1))->where('role_id', '=', $data['role_id'])->execute();
        }
        if ($data['is_default']) {
            DB::update('acl_roles')->set(array('is_default' => 0))->where('mod_name', '=', $this->_modName)->execute();
            DB::update('acl_roles')->set(array('is_default' => 1))->where('role_id', '=', $data['role_id'])->execute();
        }
        Cache::instance()->delete('acl_roles');
    }

    /**
     * 删除角色
     *
     * @param  integer  $roleId
     */
    public function delRole($roleId)
    {

        $info = DB::select()
            ->from(array('acl_roles', 'role'))
            ->join('modules')
            ->on('modules.mod_name', '=', 'role.mod_name')
            ->where('role.mod_name', '=', $this->_modName)
            ->where('role.role_id', '=', (integer) $roleId)
            ->execute()->current();

        if ($info['is_guest']) {
            throw new Exception('游客角色无法删除');
        }

        if ($info['is_default']) {
            throw new Exception('默认角色无法删除');
        }
        DB::delete('acls')->where('role_id', '=', (integer) $roleId)->execute(); //删除 ACL
        DB::delete('acl_roles')->where('role_id', '=', (integer) $roleId)->where('mod_name', '=', $this->_modName)->execute(); //删除角色表
        Cache::instance()->delete('acl_roles');
    }

    /**
     * 获取用户拥有的所有角色
     *
     * @param  integer  $uid
     * @return array
     */
    public function getAllRoles($uid)
    {
        if (!isset(self::$_allRoles[$uid])) {
            $rows = DB::select('role.role_name', 'role.mod_name')
                ->from(array('user_roles', 'urole'))
                ->join(array('acl_roles', 'role'))
                ->on('urole.role_id' , '=', 'role.role_id')
                ->join('modules')
                ->on('role.mod_name', '=', 'modules.mod_name')
                ->where('role.is_guest', '=', 0)
                ->where('urole.uid', '=', $uid)
                ->execute()->as_array();
            foreach ($rows as $row) {
                self::$_allRoles[$uid][$row['mod_name']] = "{$row['mod_name']}.{$row['role_name']}";
            }
            $allDefaultRoles = $this->getAllDefaultRoles();
            foreach ($allDefaultRoles as $modName => $roleName) {
                if (!isset(self::$_allRoles[$uid][$modName])) {
                    self::$_allRoles[$uid][$modName] = $roleName;
                }
            }
        }
        return self::$_allRoles[$uid];
    }

    /**
     * 获取所有默认角色
     *
     * @return array
     */
    public function getAllDefaultRoles()
    {
        if (null == self::$_allDefaultRoles) {
            self::$_allDefaultRoles = Cache::instance()->get('acl_all_default_roles'); //读取缓存

            if (self::$_allDefaultRoles == false) {
                $rows = DB::select('role.role_name', 'role.mod_name')
                    ->from(array('acl_roles','role'))
                    ->join('modules')
                    ->on('modules.mod_name', '=', 'role.mod_name')
                    ->where('role.is_guest', '=', 0)
                    ->where('role.is_default', '=', 1)
                    ->execute()->as_array();
                $roles = array();
                foreach ($rows as $row) {
                    $roles[$row['mod_name']] = "{$row['mod_name']}.{$row['role_name']}";
                }
                self::$_allDefaultRoles = $roles;

                Cache::instance()->set('acl_all_default_roles', $roles);
            }
        }
        return self::$_allDefaultRoles;
    }

    /**
     * 获取所有游客角色
     *
     * @return array
     */
    public function getAllGuestRoles()
    {
        if (null == self::$_allGuestRoles) {
            self::$_allGuestRoles = Cache::instance()->get('acl_all_guest_roles');
            if (self::$_allGuestRoles == false) {
                $rows = DB::select('role.role_name', 'role.mod_name')
                    ->from(array('acl_roles', 'role'))
                    ->join('modules')
                    ->on('modules.mod_name', '=', 'role.mod_name')
                    ->where('role.is_guest', '=', '1')
                    ->execute()->as_array();
                $roles = array();
                foreach ($rows as $row) {
                    $roles[$row['mod_name']] = "{$row['mod_name']}.{$row['role_name']}";
                }
                self::$_allGuestRoles = $roles;
                Cache::instance()->set('acl_all_guest_roles', $roles);
            }
        }
        return self::$_allGuestRoles;
    }
}