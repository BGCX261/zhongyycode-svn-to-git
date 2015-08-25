<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台 磁盘管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Help extends Controller_Admin_Base {

    /**
     * 控制器方法执行前
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '帮助文档列表管理',
            'action' => array(
                'index' => array(
                    'url' => '/admin/help',
                    'text' => '文档列表',
                ),
                'add' => array(
                    'url' => '/admin/help/add',
                    'text' => '文档添加',
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
        $this->template->description = '<ul>
<li>公告:在图书馆显示站内公告信息</li>
<li>问题:在图书馆显示常见问题信息</li>
</ul>';
        $select = DB::select()->from('imgup_docs')->order_by('id','desc');
        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
    }

    /*
     * 详细信息
     */
    public function action_view ()
    {
        $id = (int) $this->getQuery('id');
        $info = DB::select()->from('imgup_docs')->where('id','=',$id)->execute()->as_array();
        $this->template->info=$info[0];
    }

     /**
      * 添加
      */
    public function action_add()
    {

        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                    ->filter(TRUE, 'trim')
                    ->rule('cname', 'not_empty')
                    ->rule('title', 'not_empty')
                    ->rule('content', 'not_empty');

            if ($post->check()) {
                $help = ORM::factory('imgup_doc');
                $help->values($post);
                $help->addtime = date('Y-m-d H:i:s', time());

                $help->opt_id = $this->auth['uid'];
                $help->cid = (int) $this->getPost('cid');
                $help->save();
                $this->request->redirect('/admin/help/index');
            } else {
                $errors = $post->errors('');
                $this->show_message($errors);
            }
        }

    }

    /*
     * 编辑
     */
    public function action_edit()
    {
        $id = (int) $this->getQuery('id');
        if (!empty($id)){
        $this->template->info = DB::select()->from('imgup_docs')
            ->where('id', '=', $id)
            ->execute()->current();
        }
        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                    ->filter(TRUE, 'trim')
                    ->rule('cname', 'not_empty')
                    ->rule('title', 'not_empty')
                    ->rule('content', 'not_empty');

            if ($post->check()) {
                $set = array(
                    'cid' => (int) $this->getPost('cid'),
                    'cname' => $post['cname'],
                    'title' => $post['title'],
                    'content' => $post['content'],

                );
                DB::update('imgup_docs')->set($set)->where('id', '=', (int) $this->getPost('id'))->execute();
                $this->request->redirect('/admin/help/index');
            } else {
                $errors = $post->errors('');
                $this->show_message($errors);
            }
        }
    }


    /*
     * 删除
     */
    public function action_del()
    {
        $id = (int) $this->getQuery('id');
        if ($id > 0) {
            DB::delete('imgup_docs')->where('id', '=', $id)->execute();
        }
        $this->request->redirect('/admin/help/index');
    }

     /**
     * 设置状态
     */
    public function action_setstat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $id = (int) $this->getQuery('id');
        if ($id > 0) {
            DB::update('imgup_docs')->set(array($type => $val))->where('id', '=', $id)->execute();
        }
        $this->auto_render = false;
    }

}
