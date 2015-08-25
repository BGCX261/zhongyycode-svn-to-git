<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台用户组
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-21
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Group extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if(!Auth::getInstance()->isAllow(array('group.list'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $this->template->layout = array(
            'title' => '用户管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/user/list',
                    'text' => '用户列表',
                ),
                'group' => array(
                    'url' => '/admin/group/group',
                    'text' => '会员组管理',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /**
     * 会员组管理
     */
    public function action_group()
    {

        $select = DB::select('g.*')->from(array('imgup_group', 'g'));
        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));

        $id = (int) $this->getQuery('id');
        if ($id > 0) {
            $this->template->info = DB::select()->from('imgup_group')->where('id', '=', $id)->execute()->current();
        }
    }

    /**
     * 会员组添加
     */
    public function action_add()
    {
        if(!Auth::getInstance()->isAllow(array('group.add'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }

        if($this->isPost()){
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('group_name', 'not_empty')
                ->rule('max_space', 'not_empty')
                ->rule('fee_year', 'not_empty')
                ->rule('fee_month', 'not_empty')
                ->rule('dir_limit', 'not_empty')
                ->rule('max_limit', 'not_empty');
            if ($post->check()) {
                $data = array($post['group_name'], $post['max_space'], $post['fee_year'], $post['fee_month'], $post['dir_limit'], $post['max_limit']);
                DB::insert('imgup_group', array('group_name', 'max_space', 'fee_year', 'fee_month', 'dir_limit', 'max_limit'))->values($data)->execute();;
                $this->request->redirect('/admin/group/group');
            }

           $errors = $post->errors('/admin/group');
           $this->show_message($errors);
        }
        $this->auto_render = false;
    }

    /*
     * 编辑
     */
    public function action_edit()
    {
        if(!Auth::getInstance()->isAllow(array('group.edit'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }

        if($this->isPost()){
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('group_name', 'not_empty')
                ->rule('max_space', 'not_empty')
                ->rule('fee_year', 'not_empty')
                ->rule('fee_month', 'not_empty')
                ->rule('dir_limit', 'not_empty')
                ->rule('max_limit', 'not_empty');
            // 验证
            if ($post->check()) {
                $set = array (
                    'group_name' => trim($this->getPost('group_name')),
                    'max_space'  => trim($this->getPost('max_space')),
                    'fee_year'   => trim($this->getPost('fee_year')),
                    'fee_month'  => trim($this->getPost('fee_month')),
                    'dir_limit'  => trim($this->getPost('dir_limit')),
                    'max_limit'  => trim($this->getPost('max_limit')),
                );
                DB::update('imgup_group')->set($set)->where('id', '=', (int)$this->getPost('id'))->execute();
                $this->request->redirect('/admin/group/group');
            }
            $errors = $post->errors('/admin/group');
            $this->show_message($errors);
        }
        $this->auto_render = false;
    }

    /**
     * 删除
     */
    public function action_del()
    {
        if(!Auth::getInstance()->hasAllow(array('group.delete'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $id = (int) $this->getQuery('id');
        if ($id > 0) {
            DB::delete('imgup_group')->where('id', '=', $id)->execute();
            DB::update('users')->set(array('rank' => 1))->where('rank', '=', $id)->execute();
        }
        $this->request->redirect('/admin/group/group');

        $this->auto_render = false;
    }

}
