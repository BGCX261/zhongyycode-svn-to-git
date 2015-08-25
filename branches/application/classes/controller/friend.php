<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户中心
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-11
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Friend extends Controller_Base {

    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->checklogin();
    }

    /**
     * 好友列表
     */
    public function action_list()
    {
        $select = DB::select('fri.*', 'users.username', 'users.nickname')
            ->from(array('friends', 'fri'))
            ->join('users')
            ->on('fri.friend_uid', '=', 'users.uid')
            ->where('fri.uid', '=', $this->auth['uid'])
            ->order_by('fri.apply_time', 'DESC');
        $result = $select->execute()->as_array();
        print_r($result);
        foreach ($result as $item) {

        }
        //$this->view->waitAudit = (integer) $this->friend->countWaitAudit($this->auth->uid);
        $this->template->pageTitle = '我的好友列表';
        $this->auto_render = false;
    }

    /**
     * 待审核好友列表
     */
    public function action_wait()
    {
        $select = DB::select('fri.*', 'users.username', 'users.nickname')
            ->from(array('friends', 'fri'))
            ->join('users')
            ->on('fri.uid', '=', 'users.uid')
            ->where('is_audit', '=', 0)
            ->where('fri.friend_uid', '=', $this->auth['uid'])
            ->order_by('fri.apply_time', 'DESC');
        $result = $select->execute()->as_array();
        print_r($result);
        $this->template->pageTitle = '待审核的好友';
        $this->auto_render = false;
    }

    /**
     * 申请好友
     */
    public function action_apply()
    {
        $apply_uid = (int) $this->getQuery('uid');
        $remark = trim($this->getQuery('remark', ''));

        $user = ORM::factory('user');
        $userInfo = $user->where('uid','=',$apply_uid)->find();
        if (empty($userInfo->username)) {
            $this->show_message('指定的好友不存在');
        }
        if ($this->auth['uid'] ==  $userInfo->uid) {
            $this->show_message('不能将自己添加为好友');
        }

        $row = DB::select()
            ->from('friends')
            ->where('uid', '=', $this->auth['uid'])
            ->where('friend_uid', '=', $apply_uid)
            ->execute()
            ->current();
        if (!empty($row)) {
            if ($row['is_audit'] == 0) {
                $this->show_message("您已经向 {$userInfo->username} 发出过请求，不需要重复申请，请等待对方的审核。");
            } else {
                $this->show_message(" {$userInfo->username} 已经在您的好友列表中了，不需要再添加。");
            }
        }

        $data = array('uid', 'friend_uid', 'remark', 'apply_time','is_audit');
        DB::insert('friends', $data)->values(array($this->auth['uid'], $apply_uid, $remark, time(),0))->execute();
        $content = <<<EOF
<img src='/images/icon/group.gif'>
<a href="/user/view/?uid={$this->auth['uid']}">{$this->auth['username']}</a> 请求将您加为好友
点击 <a href="/friend/accept/?uid={$this->auth['uid']}">接受</a> 或者 <a href="/friend/refuse/?uid={$this->auth['uid']}">拒绝</a> 该请求。
EOF;
        try {
            $msg = new Msg($this->auth['uid']);
            $msg->sendMsg($userInfo->username, '添加好友信息', $content, 0);
            $this->show_message('成功添加对方为好友，请等待对方验证审核，谢谢！');
        } catch (Exception $e) {
            $this->show_message($e->getMessage());
        }


        $this->auto_render = false;
    }

    /**
     * 接收加为好友的请求
     *
     * @param  integer  $firendUid
     * @throws EGP_Exception
     */
    public function action_accept()
    {
        $accept_uid = (int)$this->getQuery('uid', 17);
        $user = ORM::factory('user');
        $userInfo = $user->where('uid','=',$accept_uid)->find();

        $info = DB::select('friends.*', 'users.username')
            ->from('friends')
            ->join('users')
            ->on('users.uid', '=', 'friends.friend_uid')
            ->where('friends.uid', '=', $accept_uid)
            ->where('friends.friend_uid', '=', $this->auth['uid'])
            ->execute()
            ->current();
        if (empty($info)) {
            $this->show_message('无效的好友请求！');
        }

        if ($info['is_audit'] == 1) {
            $this->show_message('您已经审核过该请求，请不要重复操作！');
        }

        //更新审核状态
        $set = array('is_audit' => 1);

        DB::update('friends')->set($set)->where('uid', '=', $accept_uid)->where('friend_uid', '=', $this->auth['uid'])->execute();

        //添加另一方列表
        $data = array('uid', 'friend_uid', 'apply_time','is_audit');
        DB::insert('friends', $data)->values(array($this->auth['uid'], $accept_uid, time(), 1))->execute();

        $content = "<img src='/images/icon/group.gif'> <a href='/user/view?uid={$this->auth['uid']}'>{$this->auth['username']}</a> 已经通过您的好友请求并将您加为好友。";
        try {
            $msg = new Msg($this->auth['uid']);
            $msg->sendMsg($userInfo->username, '审核好友信息', $content);
            $this->show_message('成功审核并添加对方为好友！');
        } catch (Exception $e) {
            $this->show_message($e->getMessage());
        }

    }

    /**
     * 拒绝请求
     */
    public function refuseAction()
    {
        $uid = $this->request->getQuery('uid');
        $user = new IML_User();
        $info = $user->getInfo($uid);

        try {
            $this->friend->refuse($uid);
            $this->view->feedback(array(
                'message'  => "操作成功，您拒绝了 {$info['username']} 加为好友的请求。",
                'redirect' => $this->request->getServer('HTTP_REFERER', '/friend/list'),
                'linktext' => '点击继续',
            ));
        } catch (Exception $e) {
            $this->view->feedback(array(
                'title'    => '发生错误',
                'message'  => $e->getMessage(),
            ));
        }
    }

    /**
     * 编辑好友列表
     */
    public function editAction()
    {
        if ($this->request->isPost()) {
            try {
                $post = $this->request->getPost();
                if (isset($post['delete'])) {
                    $this->friend->delete($post['delete']);
                }
                if (isset($post['remark'])) {
                    $this->friend->edit($post['remark']);
                }
                $this->view->feedback(array(
                    'message'  => "您的操作已成功执行，点击返回好友列表。",
                    'redirect' => $this->request->getServer('HTTP_REFERER', '/friend/list'),
                    'linktext' => '返回好友列表',
                ));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => $e->getMessage(),
                ));
            }
        }
        $this->view = null;
    }

}