<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台订单管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Order extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if(!Auth::getInstance()->isAllow(array('order.list'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $this->template->layout = array(
            'title' => '订单管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/order/list',
                    'text' => '订单列表',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /**
     * 会员组管理
     */
    public function action_list()
    {

        $select = DB::select()
            ->from(array('imgup_upgrade', 'order'))

            ->order_by('order.id', 'DESC');



        // 用户名
        $this->template->username = $username = trim($this->getQuery('username'));
        if(!empty($username)) {
             $user = ORM::factory('user')->where('username', '=', $username)->find();
             if ($user->uid > 0 ) {
             $select->where('order.uid', '=', $user->uid);
             }
        }
        // 订单号
        $this->template->orderno = $orderno = trim($this->getQuery('orderno'));
        if(!empty($orderno)) {
             $select->where('order.orderno', '=', $orderno);
        }
        // 交易号
        $this->template->trade_no = $trade_no = trim($this->getQuery('trade_no'));
        if(!empty($trade_no)) {
             $select->where('order.trade_no', '=', $trade_no);
        }
        // 升级后
        $this->template->group_id = $group_id = trim($this->getQuery('group_id'));
        if($group_id > 0) {
             $select->where('order.dest_group', '=', $group_id);
        }

        $startDate = $this->template->start_date = $this->getQuery('start_date', '');
        if (!empty($startDate)) {
            $select->where("order.save_time", '>', $startDate);
        }
        $endDate = $this->template->end_date = $this->getQuery('end_date', '');
        if (!empty($endDate)) {
            $select->where("order.save_time", '<=', $endDate);
        }
        $select2 = clone $select;
        $select3 = clone $select;
        $this->template->calculate2 = $select3->select(DB::expr('sum(fee)'))->where('order.status', '=', 1)->fetch_one();

        $this->template->calculate = $select2->select(DB::expr('sum(fee)'))->fetch_one();

        $select->select('order.*','u.username', 'u.reg_time')->join(array('users', 'u'))->on('u.uid', '=', 'order.uid');
        $this->template->status = $status = (int) $this->getQuery('status', 1);
        $select->where('order.status', '=', $status);

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));

        $this->template->groups = $groups = DB::select('id', 'group_name')->from('imgup_group')->execute()->as_array();
        $group_list = array();
        foreach($groups as $item) {
            $group_list[$item['id']] = $item['group_name'];
        }
        $this->template->group_list = $group_list;
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
