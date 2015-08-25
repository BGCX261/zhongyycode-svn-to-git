<?php
/**
 * acl规则管理
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_RuleController extends YUN_Controller_Action_Admin
{

    /**
     * RuleModel
     * @var RuleModel
     */
    public $rule = null;

    /**
     * module name
     * @var string
     */
    public $mod_name = null;
    /**
     * PrivilegeModel
     * @var PrivilegeModel
     */
    public $privilege = null;

    /**
     * 初始化方法
     */
    public function init()
    {
        parent::init();
        $this->mod_name = $mod_name = $this->_request->getParam('mod_name');
        $this->rule = new RuleModel($mod_name);
        $this->privilege = new PrivilegeModel();

        $action['list'] = array(
            'url' => array('module' => 'admin','controller' => 'rule', 'action' => 'list', 'mod_name' => $mod_name),
            'text' => ' 规则管理',
        );

        $action['add'] = array(
            'url' => array('module' => 'admin','controller' => 'rule', 'action' => 'add', 'mod_name' => $mod_name),
            'text' => '添加规则',
        );


        $this->view->layout = array(
            'title' => '管理后台 - 规则管理',
            'action' => $action,
            'current' => $this->module['action']
        );
    }

    /**
     * 规则列表
     */
    public function listAction()
    {
        $this->view->ruleGroup = $this->rule->getRuleGroup();
        $this->view->resources = $this->rule->getResourceAll();
        $this->view->privileges = $this->privilege->getAll();
    }

    /**
     * 添加规则
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->rule->add($this->_request->getPost());
                $cache = Zend_Registry::get('cache');
                $cache->remove('acl_resource');  // 删除缓存

                $this->_redirect($this->view->url(array('action' => 'list')));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }

        $this->view->layout = array('title' => '管理后台 - 添加规则');
        $this->view->privileges = $this->privilege->getAll();
    }

    /**
     * 追加权限
     */
    public function appendAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->rule->append(
                    $this->_request->getPost('res_name'),
                    $this->_request->getPost('priv_name')
                );
                $this->_redirect($this->view->url(array('action' => 'list')));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
        $this->isload = false;
    }

    /**
     * 删除规则
     */
    public function delAction()
    {
        if ($this->_request->isPost()) {
            $this->rule->del($this->_request->getPost('rule_id'));
            $cache = Zend_Registry::get('cache');
            $cache->remove('acl_resource');  // 删除缓存
            $this->_redirect($this->view->url(array('action' => 'list')));
        }

        $this->isload = false;
    }

}