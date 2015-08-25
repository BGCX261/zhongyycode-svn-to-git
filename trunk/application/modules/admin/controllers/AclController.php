<?php
/**
 * ACL 权限控制
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_AclController extends YUN_Controller_Action_Admin
{

    /**
     * AclModel
     *
     * @var AclModel
     */
    public $acl = null;

    /**
     * RoleModel
     *
     * @var RoleModel
     */
    public $role = null;

    /**
     * RuleModel
     *
     * @var RuleModel
     */
    public $rule = null;

    /**
     * 初始化操作
     *
     */
    public function init()
    {
        parent::init();
        try {
            $modName = $this->_request->getParam('mod_name');
            $this->acl = new AclModel($modName);
            $this->role = new RoleModel($modName);
            $this->rule = new RuleModel($modName);
        } catch (Exception $e) {
            $this->view->feedback(array(
                'title' => '发生错误',
                'message' => $e->getMessage(),
            ));
        }
    }

    /**
     * 权限列表
     */
    public function assignAction()
    {
        $this->view->roles = $this->role->getAll();
        $this->view->roleId = (integer) $this->_request->getParam('role_id');
        if ($this->view->roleId == 0) {
            $this->view->roleId = $this->view->roles[0]['role_id']; //获取第一个角色
        } elseif (!$this->role->idExists($this->view->roleId)) {
            $this->view->feedback(array(
                'title' => '发生错误',
                'message' => '指定的角色 ID 不存在或者已经被删除',
            ));
        }

        $this->view->layout = array('title' => '管理后台 - 添加规则');
        $this->view->ruleGroup = $this->rule->getRuleGroup();
        $this->view->allowRules = $this->acl->getRoleAllowRule($this->view->roleId);

    }

    /**
     * 保存设定
     */
    public function saveAction()
    {
        if ($this->_request->isPost()) {
            $roleId = (integer) $this->_request->getParam('role_id');
            $this->acl->assign(
                $roleId,
                $this->_request->getPost('rule_id')
            );
            $this->_redirect($this->view->url(array('action' => 'assign', 'role_id' => $roleId)));
        }
        $this->view = null;
    }

}