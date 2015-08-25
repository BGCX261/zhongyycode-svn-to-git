<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台专题列表
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-28
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Picsubject extends Controller_Admin_Base {

    /**
     * init
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '专题列表管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/picsubject/list',
                    'text' => '专题列表',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /*
     * 专题列表
     */
    public function action_list()
    {

        $select = DB::select('s.*', 'u.username')->from(array('specialpics', 's'))
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 's.uid')
            ->order_by('s.sid','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('s.title', 'like', "%$keyword%");
        }

        $this->template->username = $username = trim($this->getQuery('username'));
        if (!empty($username)) {
            $select->where('u.username', 'like', "%$username%")
                ->or_where('u.uid', '=', $username);
        }

        // 推荐
        $this->template->is_top = $is_top = (int) $this->getQuery('is_top', 0);
        if ($is_top) {
            $select->where('s.is_top', '=',$is_top);
        }
        // 分享
        $this->template->is_share = $is_share = (int) $this->getQuery('is_share', 0);
        if ($is_share) {
            $select->where('s.is_share', '=',1);
        }

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
    }

    /**
     * 删除专题
     *
     */
    public function action_del()
    {

        $id = $this->getRequest('sid');
        if (!is_array($id)) {
            $id = array($id);
        }
        if (empty($id)) {
            $this->show_message('请选择要删除的专题');
        }
        $tag = new Tags();
        foreach ($id as $value) {
            DB::delete('specialpics')->where('sid', '=', $value)->execute();
            DB::delete('comments')->where('item_id', '=', $value)->where('app', '=', 'img_subject')->execute();
            $tag->del($value, 'img_subject');
        }
        $this->request->redirect('/admin/picsubject/list');

        $this->auto_render = false;
    }

    /**
     * 设置专题状态ajax
     */
    public function action_setStat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $id = (int) $this->getQuery('sid');
        DB::update('specialpics')->set(array($type => $val))->where('sid', '=', $id)->execute();
        $this->auto_render = false;
    }


    /**
     * 编辑专题
     */
    public function action_edit()
    {
        $sid = (int) $this->getQuery('sid');
        $tag = new Tags();
        $select = DB::select('s.*', 'u.username')->from(array('specialpics', 's'))
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 's.uid')
            ->where('sid', '=', $sid);
       $this->template->info = $select->execute()->current();
       $this->template->tags = $tags = $tag->get($sid, 'img_subject', $info['uid']);

       if ($this->isPost()) {

          $is_share = $this->getPost('is_share', 0);
          $title = trim($this->getPost('title'));
          $content = trim($this->getPost('content'));
          $uid = (int) $this->getPost('uid');
          $sid = $this->getPost('sid', 0);
          $tags = $this->getPost('tags');
          if (empty($title) || empty($content)) {
            $this->show_message('专题标题和内容不能为空...');
          }

          if ($sid > 0) {
            $set = array(
                'title' => $title,
                'content' => $content,
                'is_share' => $is_share
            );
            DB::update('specialpics')->set($set)->where('sid', '=', $sid)->execute();

            $tags = explode(' ', $tags);

            $tag->set($sid, 'img_subject', $tags, $uid);
            $links[] = array(
                'text' => '返回专题列表',
                'href' => '/admin/picsubject/list',
            );
            $this->show_message('编辑专题操作成功。', 1, $links);
          }




       }
    }
}
