<?php
/**
 * acl模块管理控制器
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_ModuleController extends YUN_Controller_Action_Admin
{
    /**
     * ModuleModel
     * @var ModuleModel
     */
    protected $_module = null;

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        if(!$this->auth->isAllow('system.access')) {
            $this->view->feedback(array(
                    'message' => '对不起，您没有权限执行该操作！',
                    'linktext' => '点击继续',
                ));
        }

        $this->_module = new ModuleModel();

        $this->view->layout = array(
            'title' => '模块管理',
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
            'current' => $this->module['controller'],
        );
    }

    /**
     * 模块管理
     */
    public function listAction()
    {
        $this->view->layout['description'] = array( '<ul>
            <li>模块名称必须为 2~20 英文字母+数字组成的字符</li>
            <li>模块说明长度为 2~80 个字符</li>
            </ul>'
        );
        $this->view->modules = $this->_module->info();
    }

    /**
     * 添加模块
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->_module->add($this->_request->getPost());
                $this->_redirect($this->view->url(array('module'=>'admin', 'controller' => 'module', 'action' => 'list'), '', true));
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
     * 编辑模块
     */
    public function editAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->_module->edit(
                    $this->_request->getPost('mod_name'),
                    $this->_request->getPost()
                );
                $this->_redirect($this->view->url(array('module'=>'admin', 'controller' => 'module', 'action' => 'list'), '', true));
            } catch (Exception $e) {
                $this->view->Feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
        $this->isload = false;
    }

    /**
     * 删除模块
     */
    public function delAction()
    {
        $this->_module->del($this->_request->getParam('mod_name'));
        $this->_redirect($this->view->url(array('module'=>'admin', 'controller' => 'module', 'action' => 'list'), '', true));
        $this->isload = false;
    }

}