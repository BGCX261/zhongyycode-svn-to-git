<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 图书馆首页
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Book_User extends Controller_Book_Base {

    /**
     * 图书分类obj
     */
    public $cate = '';

    /**
     * 标签obj
     */
    public $tag = '';

    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->_add_css('styles/album/public.css');
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
        $this->_add_script('scripts/dtree.js');
        $this->cate = new Bookcategory();
        $this->tag = new Tags();
    }

    /*
     * 首页
     */
    public function action_index()
    {
        $this->_add_css('styles/album/my_library.css');
        $username = $this->request->param('username');
        $user = ORM::factory('user');
        $art = ORM::factory('article');
        $this->template->userInfo = $userInfo = $user->where('username', '=', $username)->find();
        if(empty($userInfo->username)) {
            $this->show_message('非法访问', 0, array(), true);
        }
        $this->template->new_list = $art->getUserArticle($userInfo->uid,40);
        $this->template->hot_list = $art->getUserArticle($userInfo->uid,40, 'views');
        $this->template->categories = $categories = $this->cate->getCates($userInfo->uid);
        $this->template->tags = $tags = $this->tag->get(0,'article', $userInfo->uid);
        //print_r($tags);

        $this->template->pageTitle = $userInfo->username . '的图书馆';
    }

    /*
     * 图书列表
     */
    public function action_list()
    {
        $this->_add_css('styles/album/my_library.css');
        $this->_add_script('scripts/dtree.js');
        $username = urldecode($this->getQuery('username'));
        $user = ORM::factory('user');
        $art = ORM::factory('article');
        $this->template->userInfo = $userInfo = $user->where('username', '=', $username)->find();
        if(empty($userInfo->username)) {
            $this->show_message('非法访问', 0, array(), true);
        }
        $this->template->pageTitle = $this->auth['username'] . '的图书列表';
        $this->template->categories = $categories = $this->cate->getCates($userInfo->uid);

        $select = DB::select('a.*', 'cate.cate_name')->from(array('articles', 'a'))
            ->join(array('article_categories', 'cate'))
            ->on('cate.cate_id', '=', 'a.cate_id')
            ->where('a.uid', '=', $userInfo->uid)
            ->where('a.recycle', '=', 0)
            ->order_by('a.article_id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('a.title', 'like', "%$keyword%")
                ->or_where('a.uid', '=', $keyword);
        }

        $this->template->cate_id = $cate_id = trim($this->getQuery('cate_id'));
        if ($cate_id > 0) {
            $select->where('a.cate_id', '=', $cate_id);
        }

        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();


        $this->template->tags = $tags = $this->tag->get(0,'article', $userInfo->uid);
        $this->template->cateInfo = $this->cate->cateInfo($cate_id);
    }




}
