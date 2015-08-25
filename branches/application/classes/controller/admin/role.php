<?php
/**
 * ACL 权限角色表
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-1
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Role extends Controller_Admin_Base
{
    /**
     * ORM::factory('acl_role')
     *
     * @var acl_role
     */
    public $role = null;

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('role.list')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        try {
            $this->template->modName = $modName = trim($this->getQuery('mod_name'));
            $this->role = ORM::factory('acl_role')->setModule($modName);

        } catch (Exception $e) {
            $this->show_message('操作失败：' . $e->getMessage());
        }
        $this->template->layout = array( 'title' => $this->role->modDesc . ' - 角色管理');

    }

    /**
     * 规则列表
     */
    public function action_list()
    {

        $this->template->description = '<ul>
<li>角色名称必须为 2~20 英文字母+数字组成的字符</li>
<li>角色定义长度为 2~80 个字符</li>
<li>角色等级为扩展信息，用于区分等级的高低 ( 低->高 )</li>
<li>“游客” - 网站未登录用户的角色，该角色是唯一的</li>
<li>“默认” - 新用户注册后的默认角色，该角色是唯一的</li>
</ul>';
       $this->template->roles = $this->role->getAll();
    }

    /**
     * 添加角色
     */
    public function action_add()
    {
        if (!Auth::getInstance()->isAllow('role.add')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        if ($this->isPost()) {
            try {
                $this->role->addRole($this->getPost());
                $this->request->redirect('/admin/role/list?mod_name='. trim($this->getQuery('mod_name')));
            } catch (Exception $e) {
                $this->show_message('操作失败：' . $e->getMessage());
            }
        }
    }

    /**
     * 编辑角色
     */
    public function action_edit()
    {
        if (!Auth::getInstance()->isAllow('role.edit')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }

        if ($this->isPost()) {
            try {
                $this->role->editRole($this->getPost());
                $this->request->redirect('/admin/role/list?mod_name='. trim($this->getQuery('mod_name')));
            } catch (Exception $e) {
                $this->show_message('操作失败：' . $e->getMessage());
            }
        }
        $this->auto_render = false;
    }


    /**
     * 删除角色
     */
    public function action_del()
    {

        if (!Auth::getInstance()->isAllow('role.delete')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        try {
            $this->role->delRole($this->getQuery('role_id'));
            $this->request->redirect('/admin/role/list?mod_name='. trim($this->getQuery('mod_name')));
        } catch (Exception $e) {
            $this->show_message('操作失败：' . $e->getMessage());
        }



        $this->auto_render = false;
    }

}