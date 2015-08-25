<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 权限管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-3
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Privilege extends Controller_Admin_Base {


    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('privilege.list')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        $this->template->layout = array(
            'title' => '权限管理',
            'action' => array(
                'index' => array(
                    'url' => '/admin/module',
                    'text' => '模块管理',
                ),
                'list' => array(
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
    public function action_list()
    {
        $this->template->description = '<ul>
<li>权限名称必须为 2~20 英文字母+数字组成的字符</li>
<li>权限说明长度为 2~80 个字符</li>
</ul>';
        $this->template->privilege = ORM::factory('acl_privilege')->getAll();
    }

    /**
     * 模块添加
     */
    public function action_add()
    {
        if (!Auth::getInstance()->isAllow('privilege.add')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        if ($this->isPost()) {
            try {
                ORM::factory('acl_privilege')->addPrivilege($this->getPost());
                $this->request->redirect('/admin/privilege/list');
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
        if (!Auth::getInstance()->isAllow('privilege.edit')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        if ($this->isPost()) {
            try {
                ORM::factory('acl_privilege')->editPrivilege(
                    $this->getPost('priv_name'),
                    $this->getPost()
                );
                $this->request->redirect('/admin/privilege/list');
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
        if (!Auth::getInstance()->isAllow('privilege.delete')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        ORM::factory('acl_privilege')->delPrivilege($this->getQuery('priv_name'));
        $this->request->redirect('/admin/privilege/list');
        $this->auto_render = false;
    }


}
