<?php
/**
 * acl权限管理
 *
 * @package    controller       news manage
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_PrivilegeController extends YUN_Controller_Action_Admin
{
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
        $this->privilege = new PrivilegeModel();
        $this->view->layout = array(
            'title' => '权限管理',
            'action' => array(
                'module' => array(
                    'url' => array('module' => 'admin', 'controller' => 'module', 'action' => 'list'),
                    'text' => '模块管理',
                ),
                'privilege' => array(
                    'url' => array('module' => 'admin', 'controller' => 'privilege', 'action' => 'list'),
                    'text' => '权限管理',
                ),
            ),
            'current' => 'privilege'
        );
    }

    /**
     * 权限列表
     */
    public function listAction()
    {
        $this->view->layout['description'] = array('<ul>
<li>权限名称必须为 2~20 英文字母+数字组成的字符</li>
<li>权限说明长度为 2~80 个字符</li>
</ul>');
        $this->view->privileges = $this->privilege->getAll();
         if ($this->_request->isPost()) {
             echo 'dd';
         }
    }

    /**
     * 添加权限
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->privilege->add($this->_request->getPost());
                $this->_redirect($this->view->url(array('action' => 'list')));
            } catch (Exception $e) {
                $this->view->Feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
    }

    /**
     * 编辑权限
     */
    public function editAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->privilege->edit(
                    $this->_request->getPost('priv_name'),
                    $this->_request->getPost()
                );
                $this->_redirect($this->view->url(array('module'=>'admin', 'controller' => 'privilege', 'action' => 'list'), '', true));
            } catch (Exception $e) {
                $this->view->Feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
    }

    /**
     * 删除权限
     */
    public function delAction()
    {
        $this->privilege->del($this->_request->getParam('priv_name'));
        $this->_redirect($this->view->url(array('module'=>'admin', 'controller' => 'privilege', 'action' => 'list'), '', true));
        $this->isload = false;
    }
}