<?php
/**
 * 用户认证
 *
 * @package    classes
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_Auth
{
    /**
     * single instance
     *
     * @var YUN_Auth
     */
    protected static $_instance = null;

    /**
     * zend_auth  object
     *
     * @var zend_auth
     */
    protected $auth = null;

    /**
     * session
     *
     * @var Zend_Session_Namespace
     */
    protected $_storage = null;

    /**
     * acl
     *
     * @var Zend_Acl
     */
    protected $_acl = null;

    /**
     * db
     *
     * @var Zend_Db
     */
    protected $_db = null;

    /**
     * cache
     * @var Zend_cache
     */
    protected $_cache = null;

    /**
     * 用户拥有的所有角色
     *
     * @var array
     */
    protected static $_allRoles = null;

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
     * 单件模式调用
     *
     * @return YUN_Auth
     */
    public static function getInstance() {

        if(null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * constructor
     *
     */
    protected  function __construct()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->_storage = new Zend_Session_Namespace('Auth');
        $this->_acl = Zend_Registry::get('acl');
        $this->_db = Zend_Registry::get('db');
        $this->_cache = Zend_Registry::get('cache');
    }

    /**
     * 会员登录
     *
     * @param  string   $username   用户名
     * @param  string   $password   密码
     */
    public function login($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        if (empty($username)) {
            throw new Zend_Exception('用户名或邮箱不能为空');
        }

        if (empty($password)) {
            throw new Zend_Exception('密码不能为空');
        }
        $password = md5(md5($password));
        $where = $this->_db->quoteInto('username=? ', strtolower($username));
        $select = $this->_db->select()
            ->from('user')
            ->where($where);
        $info = $this->_db->fetchRow($select);
        if (empty($info)) {
            throw new Zend_Exception('用户名不存在,请查证');
        }
        if ($password != $info['password']) {
            throw new Zend_Exception('用户名密码错误请查证');
        }
        $lifeTime = empty($data['lifetime']) ? '3600' : $data['lifetime'];
        $userInfo = new YUN_ArrayObject($info);
        session_cache_limiter('private');
        $this->_login($userInfo);
        Zend_Session::rememberMe($lifeTime);

        $this->updateLogin($userInfo->uid);
        return $info;

    }

    /**
     * 更新登录时间
     *
     * @param  integer  $uid
     */
    public function updateLogin($uid)
    {
        $where = $this->_db->quoteInto('uid=?', $uid);
        $set = array(
            'last_ip' => get_client_ip(),
            'last_time' => time(),
        );
        $this->_db->update('user', $set, $where);
    }

    /**
     * 设置登录成功 session 数据
     *
     * @param  stdClass  $result
     */
    protected function _login(YUN_ArrayObject $result)
    {
        if (isset($result->uid) && $result->uid > 0) {
              $data = array(
                'logined'   => true,
                'uid'       => $result->uid,
                'username'  => $result->username,
                'email'     => $result->email,
                'avatar'    => $result->avatar,
                'last_ip'   => get_client_ip(),
                'last_time' => time(),
            );
            $this->_storage->auth = new YUN_ArrayObject($data);
        }
    }

    /**
     * 检查是否登录
     *
     */
    public function isLogined(){
        if ($this->_storage->auth) {
            return ($this->_storage->auth->logined === true);
        }else {
            return false;
        }
    }

    /**
     * 获取信息
     *
     * @return unknown
     */
    public function getIdentity()
    {
        if ($this->isLogined()) {
          return $this->_storage->auth;
        }
    }

    /**
     * 退出
     *
     */
    public function logout()
    {
        $this->auth->clearIdentity();
        $this->_storage->unsetAll();
    }

    /**
     * 判断集合中是否有一个拥有权限
     *
     * @param  string  $formatArgs
     * @param  string  $role
     * @return boolean
     */
    public function hasAllow($formatArgs) {
        if (is_array($formatArgs)) {
            foreach ($formatArgs as $args) {
                if ($this->hasAllow($args)) {
                    return true;
                }
            }
            return false;
        } else {
            return $this->isAllow($formatArgs);
        }
    }

    /**
     * 权限判断
     *
     * @param string $str
     * @return boolean
     */
     public function isAllow($str)
    {
        $rules = array();

        if(is_array($str)) {
             return $this->hasAllow($str);
        }

        preg_match('/(\w+)(\.\w+)?(@\w+)?/', $str, $args);
        if (!isset($args[1]) || !isset($args[2])) {
           throw new Zend_Exception ("无效的 ACL 权限判断字串：$str");
        }

        $rules = explode('.', $str);
        $controller = Zend_Registry::get('controller');
        $module = $controller->getRequest()->getParams();
        $allRoles = $this->getRoles(); // 所有角色
        $roles = $allRoles[$module['module']];

        $resource  =  $module['module'] . '.' . $rules[0] ;  // 资源
        $privilege = $rules[1]; // 权限
        return  $this->_acl->isAllowed($roles, $resource,$privilege ) ? true :  false;
    }

    /**
     * 获取当前用户的所有角色
     *
     * @return array
     */
    public function getRoles()
    {
        if ($this->isLogined()) {
            return $this->getAllRoles($this->_storage->auth['uid']);
        } else { //取出所有的游客角色
            return $this->getAllGuestRoles();
        }
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
            $sql = $this->_db->select()
                ->from(
                    array('urole' => 'user_role'),
                    array()
                )
                ->join(
                    array('role' => 'acl_role'),
                    'role.role_id=urole.role_id',
                    array('role_name', 'mod_name')
                )
                ->join(
                    'acl_module',
                    'acl_module.mod_name=role.mod_name',
                    array()
                )
                ->where('role.is_guest=0')
                ->where('urole.uid=?', $uid);
            $rows = $this->_db->fetchAll($sql);
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
     * 获取所有游客角色
     *
     * @return array
     */
    public function getAllGuestRoles()
    {
        if (null == self::$_allGuestRoles) {
            self::$_allGuestRoles = $this->_cache->load('acl_all_guest_roles');
            if (self::$_allGuestRoles == false) {
                $rows = $this->_db->select()
                    ->from(
                        array('role' => 'acl_role'),
                        array('role_name', 'mod_name')
                    )
                    ->join(
                        'acl_module',
                        'acl_module.mod_name=role.mod_name',
                        array()
                    )
                    ->where('role.is_guest=1');
                $rows = $this->_db->fetchAll($rows);
                $roles = array();
                foreach ($rows as $row) {
                    $roles[$row['mod_name']] = "{$row['mod_name']}.{$row['role_name']}";
                }
                self::$_allGuestRoles = $roles;
                $this->_cache->save($roles, 'acl_all_guest_roles');
            }
        }
        return self::$_allGuestRoles;
    }

    /**
     * 获取所有默认角色
     *
     * @return array
     */
    public function getAllDefaultRoles()
    {
        if (null == self::$_allDefaultRoles) {
            self::$_allDefaultRoles = $this->_cache->load('acl_all_default_roles');
            if (self::$_allDefaultRoles == false) {
                $rows = $this->_db->select()
                    ->from(
                        array('role' => 'acl_role'),
                        array('role_name', 'mod_name')
                    )
                    ->join(
                        'acl_module',
                        'acl_module.mod_name=role.mod_name',
                        array()
                    )
                    ->where('role.is_guest=0')
                    ->where('role.is_default=1');
                $rows = $this->_db->fetchAll($rows);
                $roles = array();
                foreach ($rows as $row) {
                    $roles[$row['mod_name']] = "{$row['mod_name']}.{$row['role_name']}";
                }
                self::$_allDefaultRoles = $roles;
                $this->_cache->save($roles, 'acl_all_default_roles');
            }
        }

        return self::$_allDefaultRoles;
    }

}
