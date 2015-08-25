<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台积分设置
 *
 * @package    controller
 * @author     fred
 * @copyright  Copyright (c) 2010-10-28
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Point extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('role.list')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }

       $this->template->layout = array(
            'title' => '积分管理',
            'action' => array(
                'index' => array(
                    'url' => '/admin/point',
                    'text' => '积分管理',
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
        $select = DB::select()->from('imgup_job');

        $this->template->status = $status = trim($this->getQuery('status', 0));
        if ($status >= 0) {
            $select->where('status', '=', $status);

        }

        $this->template->uname = $uname = $this->getQuery('uname');
        if (!empty($uname)) {
            $select->where('uname','=', $uname);;
        }
        $this->template->title = $title = trim($this->getQuery('title'));
        if (!empty($title)) {
            $select->where('title','=',$title);
        }


        $time_type = $this->template->time_type = $this->getQuery('time_type', '-1');
        $startDate = $this->template->start_date = $this->getQuery('start_date', '');
        $end_date = $this->template->end_date = $this->getQuery('end_date', '');
        if ($time_type != '-1') {
            if (!empty($startDate)) {
                $select->where($time_type, '>=', $startDate);
            }
            if (!empty($end_date)) {
                $select->where($time_type, '<=', $end_date);
            }
        }
        $this->template->order_by = $order_by = $this->getQuery('order_by','DESC');
        if (!empty($order_by)) {
            $order_filed = 'id';
            if ($status == 0) {
                $order_by = 'ASC';
                $order_filed = 'submit_date';
            }
            if($status == 1){
              $order_by = 'DESC';
              $order_filed = 'audite_date';
            }

            $select->order_by($order_filed, $order_by);
        }

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
    }


    /**
     * 编辑
     */
    public function action_edit()
    {
        $id = (int) $this->getQuery('id');
        $this->template->rows = $this->rows = DB::select()->from('imgup_job')->where('id','=',$id)->execute()->current();

        if ($this->isPost()) {
            $set = array(
                'title' => trim($this->getPost('title')),
                'url' => $this->getPost('url'),
                'status' => $this->getPost('status'),
                'points' => (int) $this->getPost('points'),
                'status' => $this->getPost('status'),
                'audite_memo' => trim($this->getPost('audite_memo')),
                'audite_date' => date('Y-m-d H:i:s')
            );

            $id = (int) $this->getPost('id');

            if ($id > 0) {
                $info = DB::select('uid', 'status')->from('imgup_job')->where('id', '=', $id)->execute()->current();
                if ($info['status'] == 0 && $set['status'] > 0) {
                    DB::update('users')->set(array('points' => DB::expr('points + ' . $set['points'])))->where('uid', '=', $info['uid'])->execute();
                    $user = ORM::factory('user', $info['uid']);

                    if($user->points >= 0 && $user->status == 'disapproval') {
                        $set1 = array(
                            'status' => 'approved',
                            'expire_time' => strtotime(date('Y-m-d H:i:s', strtotime('+1 month')))
                        );
                       DB::update('users')->set($set1)->where('uid', '=', $info['uid'])->execute();
                       $this->open_dir($info['uid']);
                    }
                }
                DB::update('imgup_job')->set($set)->where('id', '=', $id)->execute();
                $links[] = array(
                    'text' => '返回列表',
                    'href' => '/admin/point',
                );
                $this->show_message('审核资料成功', 1, $links, true);
            }
        }
    }

    /**
     * 查看
     */
    public function action_view()
    {
        $id = (int) $this->getQuery('id');
        $this->template->row = $this->row = DB::select()->from('imgup_job')->where('id','=',$id)->execute()->current();
    }

    /**
     * 删除
     *
     */
    public function action_del()
    {
        if ($this->isPost()) {
            $id =  $this->getPost('id');
            if(!is_array($id)) {
                $id = array($id);
            }
            if (empty($id)) {
                $this->show_message('请选择要删除的ID', 0, array(), true);
            }
            foreach ($id as $value) {
                DB::delete('imgup_job')->where('id', '=', $value)->execute();
            }
            $this->request->redirect('/admin/point');
        }
        $this->auto_render = false;
    }

    /**
     * 批量审核
     */
    public function action_verify()
    {
        $id =  $this->getPost('id');
        if(!is_array($id)) {
            $id = array($id);
        }
        if (empty($id[0])) {
            $this->show_message('请选择要审核的ID', 0, array(), true);
        }

        $points =  $this->getPost('points');
        $audite =  $this->getPost('audite_memo');
        $verifyMsg = array(
          0 =>  '请勿重复提交',
          1 =>  '帖子已失效',
          2 =>  '找不到您的回答',
          3 =>  '发贴地址错误',
          4 =>  '发帖ID错误',
          5 =>  '评论或贴吧不得分',
          6 => '帖子不符合发帖规则',
          7 => '请采纳答案后提交',
          8 => '感谢您完成积分任务',
          '-1' => ''
        );
        foreach ($id as $value) {
            $info = DB::select('uid', 'status')->from('imgup_job')->where('id', '=', $value)->execute()->current();

            if (!empty($info) && $info['status'] == 0) {
                DB::update('users')->set(array('points' => DB::expr('points + ' . $points[$value])))->where('uid', '=', $info['uid'])->execute();
                // 更改任务状态
                $set = array(
                    'audite_date' => date('Y-m-d H:i:s'),
                    'points' => $points[$value],
                    'status' => 1,
                    'audite_memo' => $verifyMsg[$audite[$value]]
                );
                DB::update('imgup_job')->set($set)->where('id', '=', $value)->execute();

                $user = ORM::factory('user', $info['uid']);

                if($user->points >= 0 && $user->status == 'disapproval') {
                    $set1 = array(
                        'status' => 'approved',
                        'expire_time' => strtotime(date('Y-m-d H:i:s', strtotime('+1 month')))
                    );
                   DB::update('users')->set($set1)->where('uid', '=', $info['uid'])->execute();
                   $this->open_dir($info['uid']);
                }
            }
        }
        $this->request->redirect('/admin/point');
        $this->auto_render = false;

    }

    public function open_dir($uid)
    {
        # 开放屏蔽帐号
        $disks = ORM::factory('img_disk')->find_all();
        foreach ($disks as $disk) {
          $path = ORM::factory('user',(int) $uid)->save_dir;
          if(!empty($path)) {
            $dir = '/server/wal8/www/'. $disk->disk_name . '/' . $path;
            if(substr(sprintf('%o', fileperms($dir)), -4) == '0000') {
                chmod($dir, 0777);
            }
          }
        }
    }

}