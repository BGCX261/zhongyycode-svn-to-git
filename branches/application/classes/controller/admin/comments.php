<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台 评论管理
 *
 * @package    controller
 * @author     fred(小方) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-21
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Comments extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('module.list')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        $this->template->layout = array(
            'title' => '评论管理',
            'action' => array(
                'article' => array(
                    'url' => '/admin/comments/booklist?app=article',
                    'text' => '图书评论',
                ),
                'img' => array(
                    'url' => '/admin/comments/booklist?app=img',
                    'text' => '相册评论',
                ),
                'img_subject' => array(
                    'url' => '/admin/comments/booklist?app=img_subject',
                    'text' => '专题评论',
                ),
            ),
            'current' => $this->getQuery('app')
        );
    }

    /**
     * 图书评论管理
     */
    public function action_booklist()
    {

        $select = DB::select('c.*', 'u.username', 'u.uid')->from(array('comments', 'c'))
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'c.author');
        $this->template->app = $app = trim($this->getQuery('app'));
        if (!empty($app)) {
            $select->where('app', '=', $app);
        }
        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();

        $this->template->arr_app = array('img_subject'=>'专题评论','img'=>'图片评论','article'=>'图书评论');
    }

    /**
     * 删除图书评论
     */
    public function action_delbook()
    {
        if ($this->isPost()) {
            $id = $this->getPost('cid');
            if (!is_array($id)) {
                $id = array($id);
            }
            foreach ($id as $value) {

                $row = DB::select('item_id')->from('comments')->where('cid', '=', $value)->execute()->current();
                DB::update('articles')->set(array('comments' => DB::expr('comments - 1')))->where('article_id', '=', $row['item_id'])->execute();
                DB::delete('comments')->where('cid', '=', $value)->execute();
            }

            $links[]=array('text'=>'返回列表','href'=>'/admin/comments/booklist');
            $this->show_message('删除成功',1,$links,true);
        }
       $this->auto_render = false;
    }

    /**
    * 修改
    */
    public function action_edit()
    {
        $cid = (int) $this->getQuery('cid');
        $select = DB::select('c.*','u.username')->from(array('comments','c'))
                ->join(array('users','u'),'left')
                ->on('c.author','=','u.uid')
                ->where('cid','=',$cid)->execute()->current();
        $this->template->row = $row = $select;
        $this->template->arr_app = array('img_subject'=>'专题评论','img'=>'图片评论','article'=>'图书评论');
        if ($this->isPost())
        {
            $set = array( 'app' => $this->getPost('app'),
                        'is_show' => $this->getPost('is_show'),
                        'is_top' => $this->getPost('is_top'),
                        'quote' => $this->getPost('quote'),
                        'content' => $this->getPost('content')
                        );
            if ($cid>0)
            {
                DB::update('comments')->set($set)->where('cid','=',$cid)->execute();
                $links[]=array('text'=>'返回列表','href'=>'/admin/comments/booklist');
                $this->show_message('修改成功',1,$links,true);
            }

        }
    }

    /**
    *查看详细
    */
    public function action_view()
    {
        $cid = (int) $this->getQuery('cid');
        if ($cid>0){
        $select = DB::select('c.*','u.username')->from(array('comments','c'))
                ->join(array('users','u'),'left')
                ->on('c.author','=','u.uid')
                ->where('cid','=',$cid)->execute()->current();
        $this->template->row = $select;
        }
    }

    /**
     * 设置状态
     */
    public function action_setstat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $id = (int) $this->getQuery('cid');
        if ($id > 0) {
            DB::update('comments')->set(array($type => $val))->where('cid', '=', $id)->execute();
        }
        $this->auto_render = false;
    }

}
