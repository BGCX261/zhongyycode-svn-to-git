<?php
/**
 * 用户管理
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */

!defined('APP_DIR') && die('Access Deny!');

class Admin_UserController extends YUN_Controller_Action_Admin
{
    /**
     * 用户
     * @var UserModel
     */
    public $user = null;

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        $action['list'] = array(
            'url' => array('module' => 'admin','controller' => 'user', 'action' => 'list'),
            'text' => ' 用户列表',
        );
        $this->view->layout = array(
            'title' => '管理后台 - 用户管理',
            'action' => $action,
            'current' => $this->module['action']
        );
        $this->user = new  UserModel();
    }

    /**
     * 用户列表
     */
    public function listAction()
    {
        // 角色列表
        $select = $this->db->select()
                    ->from(array('role' => 'acl_role'))
                    ->join('acl_module', 'role.mod_name=acl_module.mod_name')
                    ->order('role.mod_name ASC')
                    ->order('role.role_level ASC');
        $this->view->roles = $this->db->fetchAll($select);

        $select = $this->db->select()
            ->from(array('u' => 'user'));
        $this->view->paginator = $this->db->fetchAll($select);

        // 按角色搜索
        $roleId = $this->view->roleId = $this->_request->getParam('role');
    }

    /**
     * 角色指派
     */
    public function roleAction() {
        $uid = (integer) $this->_request->getParam('uid');
        if ($this->_request->isPost()) {
            $roles = $this->_request->getPost('roles');

            $this->db->delete('user_role', $this->db->quoteInto('uid=?', $uid));

            foreach ($roles as $module => $roleId) {
                $data = array(
                    'uid' => $uid,
                    'role_id' => $roleId,
                    'mod_name' => $module,
                );
                $this->db->insert('user_role', $data);
            }

            $this->_redirect($this->view->url(array('action' => 'list')));
        }

        $module = new ModuleModel();
        $this->view->modules = $module->info();
        $this->view->rolesGroup = $this->user->getRolesGroup();
        $this->view->userRoles = $this->user->getUserRoles($uid);
    }

    /**
     * 修改密码
     */
    public function passAction()
    {
        if ($this->_request->isPost()) {
            $data = array(
                'uid'        => $this->_request->getPost('uid'),
                'password'   => $this->_request->getPost('password'),
                'confirmPwd' => $this->_request->getPost('confirmPwd'),
            );
            try {
                $this->user->updateInfo($data['uid'], $data);
                $this->view->feedback(array(
                    'title'     => '设置成功',
                    'message'   => '密码修改成功',
                ));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '密码修改失败：' . $e->getMessage(),
                ));
            }
        }
        $uid = $this->_getParam('uid');
        $this->view->info = null;
        if ($uid > 0) {
            $this->view->info = $this->user->getInfo($uid);

        }
    }
}
