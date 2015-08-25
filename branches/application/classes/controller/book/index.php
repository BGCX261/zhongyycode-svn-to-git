<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 图书馆首页
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Book_Index extends Controller_Book_Base {


    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->_add_css('styles/album/public.css');
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
    }

    /*
     * 首页
     */
    public function action_index()
    {
        $this->_add_css('styles/album/knowledge.css');
        $this->template->pageTitle = '图书馆';

        // 最新文章
        $this->template->new_list = DB::select('a.article_id', 'a.title', 'a.content', 'a.thumb', 'users.username')
                ->from(array('articles', 'a'))
                ->join('users')
                ->on('users.uid', '=', 'a.uid')
                ->where('a.is_show', '=', 1)
                ->where('a.index_top', '=', 1)
                ->where('a.is_new', '=', 1)
                ->limit(13)
                ->order_by('a.article_id', 'DESC')
                ->execute()->as_array();
        // 热门文章
        $this->template->hot_list = DB::select('a.article_id', 'a.title', 'a.content', 'a.thumb', 'users.username')
                ->from(array('articles', 'a'))
                ->join('users')
                ->on('users.uid', '=', 'a.uid')
                ->where('a.is_show', '=', 1)
                ->where('a.is_hot', '=', 1)
                ->where('a.index_top', '=', 1)
                ->limit(13)
                ->order_by('a.article_id', 'DESC')
                ->execute()->as_array();
        // 美文推荐
        $this->template->recommends = DB::select('a.article_id', 'a.title', 'a.content','a.thumb', 'users.username')
                ->from(array('articles', 'a'))
                ->join('users')
                ->on('users.uid', '=', 'a.uid')
                ->where('a.is_show', '=', 1)
                ->where('a.index_top', '=', 1)
                ->where('a.is_recommend', '=', '1')
                ->limit(13)
                ->order_by('a.article_id', 'DESC')
                ->execute()->as_array();
        $this->template->comments = $comments = DB::select('content', 'username','item_id')
                ->from('comments')
                 ->join('users', 'LEFT')
                ->on('users.uid', '=', 'comments.author')
                ->where('comments.is_top', '=', 1)
                ->where('comments.is_show', '=', 1)
                ->where('comments.app', '=', 'article')
                ->limit(13)
                ->order_by('cid', 'DESC')
                ->execute()->as_array();

        $tag = new Tags();
        $this->template->tags =  $tags = $tag->getHotTags('article');

        // 站内公告
        $this->template->notice = DB::select('id', 'cname','cid')->from('imgup_docs')->where('is_notice', '=', '1')->order_by('id','desc')->limit(7)->execute()->as_array();
        // 常见问题
        $this->template->question = DB::select('id', 'cname','cid')->from('imgup_docs')->where('is_question', '=', '1')->order_by('id','desc')->limit(7)->execute()->as_array();

    }

    /**
     * 列表页
     */
    public function action_list()
    {
        $this->_add_css('styles/album/my_library.css');
        $this->_add_script('scripts/dtree.js');
        $tag = new Tags();
        $cate = new Bookcategory();
        $position = trim($this->getQuery('position'));
        switch($position) {
            case 'is_hot': $pageTitle = '热门文章';break;
            case 'is_recommend': $pageTitle = '美文推荐';break;
            default: $pageTitle = '最新文章';break;
        }
        $this->template->position =  $pageTitle;
        $select = DB::select('a.*', 'cate.cate_name','u.username')->from(array('articles', 'a'))
            ->join(array('article_categories', 'cate'))->on('cate.cate_id', '=', 'a.cate_id')
            ->join(array('users', 'u'))->on('u.uid', '=', 'a.uid')
            ->where('a.recycle', '=', 0)
            ->where('a.is_show', '=', 1)
            ->order_by('a.article_id','DESC');

        if (!empty($position) && $position != 'is_new') {
            $select->where('a.'. $position, '=', 1);
        }

        $this->template->cate_id = $cate_id = trim($this->getQuery('cate_id'));
        if ($cate_id > 0) {
            $select->where('a.cate_id', '=', $cate_id);
        }

        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();


        $this->template->tags =  $tags = $tag->getHotTags('article');
        if ($this->auth) {
            $this->template->categories = $categories = $cate->getCates($this->auth['uid']);
        }
    }
}
