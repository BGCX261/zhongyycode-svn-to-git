<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 站 内 信
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-11
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Message extends Controller_Base {

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
     * 信息列表
     */
    public function action_list()
    {
        $select = $select = DB::select('m.*', 'u.username',array('u2.username', 'send_username'), 'mb.unread')
            ->from(array('msgs', 'm'))
            ->join(array('users', 'u'))->on('u.uid', '=', 'm.uid')
            ->join(array('msg_boxs', 'mb'))->on('mb.msg_id', '=', 'm.msg_id')
            ->join(array('users', 'u2'))->on('u2.uid', '=', 'mb.uid')
            ->where('m.status', '=', 0)
            ->where('mb.type', '=', 'inbox')

            ->where('mb.uid', '=', $this->auth['uid'])
            ->order_by('m.msg_id', 'DESC');

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
        $this->template->pageTitle = '我的消息列表';

    }

    /**
     * 写邮件
     */
    public function action_write()
    {
        $this->template->rece = $rece = trim($this->getQuery('rece'));
        if ($this->isPost()) {
            $receiver = trim($this->getPost('receiver'));
            $title = trim($this->getPost('title'));
            $content = trim($this->getPost('content'));
            $status = (int)$this->getPost('status');

            try {
                $msg = new Msg($this->auth['uid']);
                $msg->sendMsg($receiver, $title, $content, $status);

                $links[] = array(
                    'text' => '返回收件箱',
                    'href' => '/message/list',
                );
                if ($status) {
                    $this->show_message('邮件保存成功', 1, $links, true);
                } else {
                    $this->show_message('发送邮件成功', 1, $links, true);
                }
            } catch (Exception $e) {
                $this->show_message($e->getMessage(), 0, array(), true);

            }
        }
    }

    /**
     * 发件箱
     */
    public function action_send()
    {

         $msg = new Msg($this->auth['uid']);
         $select = $select = DB::select('mb.*', 'msgs.title', 'msgs.content', 'msgs.msg_time', 'u2.username', array('u.username', 'send_username'), 'msgs.msg_time', 'msgs.title')
            ->from(array('msg_boxs', 'mb'))
            ->join('msgs')
            ->on('msgs.msg_id', '=', 'mb.msg_id')
            ->join(array('users', 'u'))
            ->on('u.uid', '=', 'mb.uid')
            ->join(array('users', 'u2'))
            ->on('u2.uid', '=', 'msgs.uid')
            ->where('mb.type', '=', 'outbox')
            ->where('mb.is_del', '=', '0')
            ->where('mb.uid', '=', $this->auth['uid']);

        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();

        $msg_id = (int) $this->getQuery('msg_id');
        $info = array();
        if ($msg_id > 0 ) {
            $this->template->info = $info = $msg->infoSql($msg_id)->execute()->current();
        }
    }

    /**
     * 删除消息
     */
    public function action_del()
    {
        $msg = new Msg($this->auth['uid']);
        $msg_id = (int) $this->getQuery('msg_id');
        try {
            $msg->del($msg_id);
            $links[] = array(
                'text' => '返回收件箱',
                'href' => '/message/list',
            );
            $this->show_message('删除成功', 1, $links, true);
        } catch (Exception $e) {
            $this->show_message($e->getMessage(), 0, array(), true);
        }

    }

    /**
     * 查看站内信
     */
    public function action_view()
    {
        $this->template->msgId = $msgId = (int) $this->getQuery('msg_id');
        $select = DB::select('mb.*', 'msgs.title', 'msgs.content', 'msgs.msg_time', 'u2.username', array('u.username', 'send_username'), 'msgs.msg_time', 'msgs.title')
            ->from(array('msg_boxs', 'mb'))
            ->join('msgs')
            ->on('msgs.msg_id', '=', 'mb.msg_id')
            ->join(array('users', 'u'))
            ->on('u.uid', '=', 'mb.uid')
            ->join(array('users', 'u2'))
            ->on('u2.uid', '=', 'msgs.uid')
            ->where('mb.type', '=', 'inbox')
            ->where('mb.is_del', '=', '0')
            ->where('mb.uid', '=', $this->auth['uid'])
            ->where('mb.msg_id', '=', $msgId);
         $msg = new Msg($this->auth['uid']);
         $msg->setRead($msgId);
         $this->template->info = $info = $select->execute()->current();

         if ($this->isPost()) {
            $receiver = trim($this->getPost('receiver'));
            $title = trim($this->getPost('title'));
            $content = trim($this->getPost('content'));

            try {

                $msg->sendMsg($receiver, $title, $content, 0);
                $links[] = array(
                    'text' => '返回收件箱',
                    'href' => '/message/list',
                );
                $this->show_message('回复邮件成功', 1, array(), true);
            } catch (Exception $e) {
                $this->show_message($e->getMessage(), 0, array(), true);

            }
         }

    }

    /**
     * 草稿箱
     */
    public function action_save()
    {
        $select = DB::select('m.*', 'u.username',array('u2.username', 'send_username'))
            ->from(array('msgs', 'm'))
            ->join(array('users', 'u'))->on('u.uid', '=', 'm.uid')
            ->join(array('msg_boxs', 'mb'))->on('mb.msg_id', '=', 'm.msg_id')
            ->join(array('users', 'u2'))->on('u2.uid', '=', 'mb.uid')
            ->where('m.status', '=', 1)
            ->where('mb.type', '=', 'inbox')
            ->where('m.uid', '=', $this->auth['uid'])
            ->order_by('m.msg_id', 'DESC');

        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();
        $this->template->pageTitle = '我的草稿列表';
        $msg_id = (int) $this->getQuery('msg_id');
        if ($msg_id > 0) {
            DB::update('msgs')->set(array('status' => 0))->where('msg_id', '=', $msg_id)->execute();
            $this->request->redirect('/message/save');
        }
    }

    /**
     * 查看草稿
     */
    public function action_viewsave()
    {}




}