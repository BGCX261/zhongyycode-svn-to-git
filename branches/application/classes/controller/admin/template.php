<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台邮件模板列表
 *
 * @package    controller
 * @author     fang(fred) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-05
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Template extends Controller_Admin_Base {

    /**
     * 控制器方法执行前
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '邮件模版管理',
            'action' => array(
                'email' => array(
                    'url' => '/admin/template/email',
                    'text' => '显示列表',
                ),
                'edit' => array(
                    'url' => '/admin/template/edit',
                    'text' => '添加信息',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /*
     * 列表
     */
    public function action_email()
    {
        $select = DB::select()->from('imgup_email')
            ->order_by('id','DESC');
        $this->template->keyname = $name = trim($this->getQuery('name'));

        if (!empty($name)){
            $select->where('name','like',"%$name%");
        }

        $this->template->pagination = $pagination = new Pager($select);
    }

    /*
    * 编辑
    */

    public function action_edit()
    {
        $id = (int) $this->getQuery('id');
        if ($id>0){
            $select = DB::select()->from('imgup_email')
                ->where('id','=',$id)->execute()->current();
            $this->template->info = $select;
        }

        //处理编辑提交过来的数据
        if ($this->isPost()){
            $post_id = (int) $this->getPost('id');
            $set = array(
                'name'=> trim($this->getPost('name')),
                'subject'=> trim($this->getPost('subject')),
                'sender'=> trim($this->getPost('sender')),
                'sender_email'=> trim($this->getPost('sender_email')),
                'template'=> trim($this->getPost('template'))
            );
            //print_r($set);die();

            if ($post_id>0){
            //更新操作
            DB::update('imgup_email')->set($set)->where('id','=',$post_id)->execute();
            $links[] = array(
                    'text' => '返回列表',
                    'href' => '/admin/template/email',
                    );
            $this->show_message('修改成功！', 1, $links, true);
            }else{
            ///添加操作
                $set_field = array('name','subject','sender','sender_email','template');
                DB::insert('imgup_email',$set_field)->values($set)->execute();
                $this->request->redirect('/admin/template/email');
            }
        }
    }

    /**
    *查看详细信息
    **/

    public function action_view()
    {
        $get_id = $this->getQuery('id');
        if ($get_id>0){
            $select = DB::select()->from('imgup_email')->where('id','=',$get_id)->execute()->current();
            $this->template->row = $select;
        }
    }

    /**
     * 删除
     *
     */
    public function action_del()
    {
        if ($this->isPost()) {
            $id = $this->getPost('id');
            if (!is_array($id)) {
                $id = array($id);
            }
            foreach ($id as $value) {
                DB::delete('imgup_email')->where('id', '=', $value)->execute();
            }

            $links[] = array(
                    'text' => '返回列表',
                    'href' => '/admin/template/email',
                    );
                $this->show_message('删除成功！', 1, $links, true);
        }
    }

    /**
     * 邮件调度管理
     */
    public function action_sheme()
    {
        $select = DB::select(
                's.*'
            )->from(array('imgup_email_sheme', 's'))
            //->join(array('users', 'u'),'LEFT')
           // ->on('u.uid', '=', 'd.uid')
            ->order_by('s.id','DESC');
        $this->template->username = $username = trim($this->getQuery('username'));

        if (!empty($username)) {
            $select->where('s.uname', '=', $username);
        }


        //用户状态
        $this->template->status = $status = trim($this->getQuery('status'), '-1');
        if (!empty($status) && $status != '-1') {
            $select->where('s.status', '=', $status);
        }

        $startDate = $this->template->start_date = $this->getQuery('start_date', '');
        $end_date = $this->template->end_date = $this->getQuery('end_date', '');
        if (!empty($startDate)) {
            $select->where("s.input_date", '>=', date('Y-m-d H:i:s', strtotime($startDate) + 86400));
        }
        if (!empty($end_date)) {
            $select->where("s.input_date", '<=', date('Y-m-d H:i:s', strtotime($end_date) + 86400));
        }

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE), array('items_per_page' => 40));


    }

    /**
     * 删除邮件调度
     */
    public function action_shemedel()
    {
        $id = $this->getQuery('id');

        if(empty($id)) {
            $this->show_message('请选择数据');
        }
        if(!is_array($id)) $id = array($id);

        foreach ($id as $v) {
            DB::delete('imgup_email_sheme')->where('id', '=', $v)->execute();
        }
        $this->request->redirect('/admin/template/sheme');
        $this->auto_render = false;
    }
}
