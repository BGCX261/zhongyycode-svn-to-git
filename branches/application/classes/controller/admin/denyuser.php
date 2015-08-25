<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 屏蔽用户信息管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Denyuser extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();

    }

    /*
     * 列表
     */
    public function action_list()
    {

        $select = DB::select(
                'd.*',
                'u.rank', array('u.status', 'user_status'), 'u.username', 'u.count_img', 'u.use_space', 'u.expire_time','u.save_dir'
            )->from(array('imgup_deny_user', 'd'))
            ->join(array('users', 'u'),'LEFT')
            ->on('u.uid', '=', 'd.uid')
            ->order_by('d.id','DESC');
        $this->template->username = $username = trim($this->getQuery('username'));

        if (!empty($username)) {
            $select->where('d.uname', '=', $username);
        }

        //用户等级
        $this->template->rank = $rank = (int)$this->getQuery('rank', '-1');
        if ($rank > 0) {
            $select->where('u.rank', '=', $rank);
        }

        //用户状态
        $this->template->status = $status = trim($this->getQuery('status', '-1'));
        if (!empty($status) && $status != '-1') {
            $select->where('u.status', '=', $status);
        }

        //屏蔽状态
        $this->template->d_status = $d_status = $this->getQuery('d_status', '-1');
        if ($d_status >= 0 && $d_status != '-1') {
            $select->where('d.status', '=', $d_status);
        }

        $startDate = $this->template->start_date = $this->getQuery('start_date', '');
        $end_date = $this->template->end_date = $this->getQuery('end_date', '');
        if (!empty($startDate)) {
            $select->where("d.deny_date", '>=', date('Y-m-d H:i:s', strtotime($startDate) + 86400));
        }
        if (!empty($end_date)) {
            $select->where("d.deny_date", '<=', date('Y-m-d H:i:s', strtotime($end_date) + 86400));
        }


        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE), array('items_per_page' => 40));
        $this->template->group = $group =  DB::select('g.*')->from(array('imgup_group', 'g'))->execute()->as_array();
        $group_list = array();
        foreach($group as $item) {
            $group_list[$item['id']] = $item['group_name'];
        }
        $this->template->group_list = $group_list;
    }


    /**
     * 删除屏蔽信息
     */
    public function action_delete()
    {
        $id = $this->getQuery('id');

        if(empty($id)) {
            $this->show_message('请选择数据');
        }
        if(!is_array($id)) $id = array($id);

        foreach ($id as $v) {
            DB::delete('imgup_deny_user')->where('id', '=', $v)->execute();
        }
        $this->request->redirect('/admin/denyuser/list');
        $this->auto_render = false;
    }
}
