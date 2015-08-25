<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户图书馆分类管理
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Book_Category extends Controller_Base {

    /**
     * 图书分类obj
     */
    public $cate = '';

     /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->_add_css('styles/album/public.css');
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
        if(!$this->auth){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login',
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
        }

        $this->cate = new Bookcategory();
    }

    /**
     * 首页
     *
     */
    public function action_index()
    {

    }

    /**
     * 管理图书分类
     */
    public function action_list()
    {
        $this->_add_css('styles/album/book_manage.css');
        $this->_add_script('scripts/dtree.js');
        $this->_add_script('scripts/jquery/jquery.form.min.js');
        $this->template->pageTitle = '管理图书分类';


        $this->template->categories = $categories = $this->cate->getCates($this->auth['uid']);
        if (empty($categories)) {
            $post['cate_name'] = '我的图书馆';
            $post['description'] = '我的图书馆';
            $post['parent_id'] = '0';
            $post['sort_order'] = '0';
            $post['is_show'] = '1';
            $post['uid'] = $this->auth['uid'];
            $this->cate->add($post);
            $this->request->redirect('/book/category/list');
        }
        $cateId = (integer) $this->getQuery('cate_id');
        $this->template->cateInfo = $this->cate->cateInfo($cateId);

    }

     /**
     * 添加分类
     */
    public function action_cateadd()
    {

        if ($this->isPost()) {
            $post = $this->getPost();
            $post['uid'] = $this->auth['uid'];
            try {
                $this->cate->add($post);
                echo 'succeed';
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
       $this->auto_render = false;
    }

    /**
     * 编辑分类
     */
    public function action_cateedit()
    {

        if ($this->isPost()) {
            $cateId = (integer) $this->getPost('cate_id');
            $post = $this->getPost();
            try {
                $this->cate->edit($cateId, $post);
                echo 'succeed';
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        $this->auto_render = false;
    }

    /**
     * 删除分类
     */
    public function action_catedel()
    {
       $cateId = (integer) $this->getQuery('cate_id');

        try {
            $this->cate->del($cateId);
            echo 'succeed';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $this->auto_render = false;
    }




}
