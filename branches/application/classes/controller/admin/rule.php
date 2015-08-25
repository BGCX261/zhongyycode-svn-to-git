<?php
/**
 * 规则管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Rule extends Controller_Admin_Base
{

    /**
     * RuleModel
     *
     * @var RuleModel
     */
    public $rule = null;

    /**
     * PrivilegeModel
     *
     * @var PrivilegeModel
     */
    public $privilege = null;

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('rule.list')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        try {
            $this->template->modName = $modName = trim($this->getQuery('mod_name'));
            $this->rule = ORM::factory('acl_rule')->setModule($modName);
            $this->resource = ORM::factory('acl_resource')->setModule($modName);
        } catch (Exception $e) {
            $this->show_message('操作失败：' . $e->getMessage());
        }

        $action['list'] = array(
            'url' => '/admin/rule/list?mod_name=' . $this->getQuery('mod_name'),
            'text' => '规则管理',
        );
        $action['add'] = array(
            'url' => '/admin/rule/add?mod_name=' . $this->getQuery('mod_name'),
            'text' => '添加规则',
        );

        $this->template->layout= array(
            'title' => '模块管理',
            'action' => $action,
            'current' => $this->request->action
        );
    }

    /**
     * 规则列表
     */
    public function action_list()
    {
        $this->template->layout['title'] = $this->rule->modDesc . ' - 规则管理';
        $this->template->ruleGroup = $ruleGroup = $this->rule->getRuleGroup();

        $this->template->resources =$this->resource->getAll();
        $this->template->privileges = ORM::factory('acl_privilege')->getAll();

    }

    /**
     * 添加规则
     */
    public function action_add()
    {
        if (!Auth::getInstance()->isAllow('rule.add')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        if ($this->isPost()) {
            try {
                $this->rule->addRule($this->getPost());
                $this->request->redirect('/admin/rule/list?mod_name='. trim($this->getQuery('mod_name')));
            } catch (Exception $e) {
                $this->show_message('操作失败：' . $e->getMessage());
            }
        }

        $this->template->layout['title'] = $this->rule->modDesc . ' - 添加规则';
        $this->template->privileges = ORM::factory('acl_privilege')->getAll();
    }

    /**
     * 追加权限
     */
    public function action_append()
    {
        if (!Auth::getInstance()->isAllow('rule.append')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        if ($this->isPost()) {
            try {
                $this->rule->append(
                    $this->getPost('res_name'),
                    $this->getPost('priv_name')
                );
                $this->request->redirect('/admin/rule/list?mod_name='. trim($this->getQuery('mod_name')));
            } catch (Exception $e) {
                $this->show_message('操作失败：' . $e->getMessage());
            }
        }
        $this->auto_render = false;
    }

    /**
     * 删除规则
     */
    public function action_del()
    {
        if (!Auth::getInstance()->isAllow('rule.delete')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        if ($this->isPost()) {
            $this->rule->delRule($this->getPost('rule_id'));
            $this->request->redirect('/admin/rule/list?mod_name='. trim($this->getQuery('mod_name')));
        }
        $this->auto_render = false;
    }

}