<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台 模块与权限
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Module extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('module.list')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        $this->template->layout = array(
            'title' => '模块管理',
            'action' => array(
                'index' => array(
                    'url' => '/admin/module',
                    'text' => '模块管理',
                ),
                'leaveSet' => array(
                    'url' => '/admin/privilege/list',
                    'text' => '权限管理',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /*
     * 首页
     */
    public function action_index()
    {
        $this->template->description = '<ul>
<li>模块名称必须为 2~20 英文字母+数字组成的字符</li>
<li>模块说明长度为 2~80 个字符</li>
</ul>';
        $this->template->modules = ORM::factory('module')->getAll();
    }

    /**
     * 模块添加
     */
    public function action_add()
    {
        if (!Auth::getInstance()->isAllow('module.add')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        if ($this->isPost()) {
            try {
                ORM::factory('module')->addmModule($this->getPost());
                $this->request->redirect('/admin/module');
            } catch (Exception $e) {
                $this->show_message('操作失败：' . $e->getMessage());
            }
        }
        $this->auto_render = false;
    }

    /**
     * 编辑模块
     */
    public function action_edit()
    {
        if (!Auth::getInstance()->isAllow('module.edit')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        if ($this->isPost()) {
            try {
                ORM::factory('module')->editModule(
                    $this->getPost('mod_name'),
                    $this->getPost()
                );
                $this->request->redirect('/admin/module');
            } catch (Exception $e) {
                $this->show_message('操作失败：' . $e->getMessage());
            }
        }
        $this->auto_render = false;
    }

    /**
     * 删除模块
     */
    public function action_del()
    {
        if (!Auth::getInstance()->isAllow('module.delete')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        ORM::factory('module')->delModule($this->getQuery('mod_name'));
        $this->request->redirect('/admin/module');
        $this->auto_render = false;
    }


}
