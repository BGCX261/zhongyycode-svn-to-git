<?php defined('SYSPATH') or die('No direct script access.');
/**
 * acl 权限指派
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Acl extends Controller_Admin_Base {

    /**
     * orm::factory('acl')
     *
     * @var acl
     */
    public $acl = null;

    /**
     * orm::factory('acl_role')
     *
     * @var acl_role
     */
    public $role = null;

    /**
     * orm::factory('acl_rule')
     *
     * @var acl_rule
     */
    public $rule = null;

    /**
     * 控制器方法执行前
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('privilege.assign')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        $this->template->layout = array('title' => '权限指派' );

        try {
            $this->template->modName = $modName = trim($this->getQuery('mod_name'));
            $this->acl = ORM::factory('acl')->setModule($modName);
            $this->role = ORM::factory('acl_role')->setModule($modName);
            $this->rule = ORM::factory('acl_rule')->setModule($modName);
        } catch (Exception $e) {
           $this->show_message('操作失败：' . $e->getMessage());
        }
    }

    /**
     * 权限列表
     */
    public function action_assign()
    {
        $this->template->roles = $roles = $this->role->getAll();
        $this->template->roleId = $roleId = (integer) $this->getQuery('role_id');
        if ($roleId == 0) {
            $this->template->roleId = $roles[0]['role_id']; //获取第一个角色
        } elseif (!$this->role->idExists($roleId)) {
            $this->show_message('发生错误：指定的角色 ID 不存在或者已经被删除' );
        }

        $this->template->layout['title'] = $this->acl->modDesc . ' - 权限指派';
        $this->template->ruleGroup = $this->rule->getRuleGroup();
        $this->template->allowRules = $allowRules = $this->acl->getRoleAllowRule($roleId);

    }

    /**
     * 保存设定
     */
    public function action_save()
    {
        if ($this->isPost()) {
            $roleId = (integer) $this->getQuery('role_id');

            $this->acl->assign(
                $roleId,
                $this->getPost('rule_id')
            );
            $this->request->redirect('/admin/acl/assign?role_id=' . $roleId . '&mod_name='. $this->getQuery('mod_name'));
        }
        $this->auto_render = false;
    }
}
