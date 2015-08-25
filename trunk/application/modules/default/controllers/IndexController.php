<?php
/**
 * 首页
 *
 * @package    Controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class IndexController extends YUN_Controller_Action
{
    /**
     * 初始化
     *
     */
    public function init(){
        parent::init();
        $this->view->pageTitle = '人生若只初见';
        $cate = new YUN_Cate($this->db);
        $this->view->cateList = $cateList = $cate->cateList(); // 导航分类
        $linkSql = $this->db->select()->from('link', '*');
        $this->view->linkList =  $this->db->fetchAll($linkSql);
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $select = $this->db->select()
            ->from('article',
                array('art_id', 'title', 'brief', 'clicks', 'comments', 'save_time', 'content'))
            ->joinLeft('category',
                'category.cate_id = article.cate_id',
                array('cate_name', 'cate_id'))
            ->ORDER('article.art_id DESC');
        $article = $this->db->fetchAll($select);

        $numPerPage = 10;  // 每页显示的条数

        $paginator = Zend_Paginator::factory($article);
        $paginator->setItemCountPerPage($numPerPage);
        $this->view->paginator = $paginator;
        if($this->_getParam('page') > 0) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
        }
    }

    /**
     * 分类下文章
     */
    public function cateAction()
    {
        $cateId = $this->_getParam('cate_id');
        $select = $this->db->select()
            ->from('article',
                array('art_id', 'title', 'brief', 'clicks', 'comments', 'save_time', 'content'))
            ->joinLeft('category',
                'category.cate_id = article.cate_id',
                array('cate_name', 'cate_id'))
            ->where('article.cate_id =?', $cateId)
            ->ORDER('article.art_id DESC');
        $article = $this->db->fetchAll($select);
        $numPerPage = 10;  // 每页显示的条数
        $paginator = Zend_Paginator::factory($article);
        $paginator->setItemCountPerPage($numPerPage);
        $this->view->paginator = $paginator;

        if($this->_getParam('page') > 0) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
        }
        $this->isload = false;
    }

    /**
     * 详细文章信息
     *
     */
    public function detailAction()
    {
        $artId = $this->_getParam('art_id');
        $select = $this->db->select()
            ->from('article',
                array('art_id', 'title', 'brief', 'clicks', 'comments', 'save_time', 'content')
            )
            ->joinLeft('category',
                'category.cate_id = article.cate_id',
                array('cate_name', 'cate_id')
            )
            ->where('article.art_id =?', $artId);
        $this->view->article = $data = $this->db->fetchRow($select);
        $this->view->pageTitle =$data['title'] . '-人生若只初见';
        $this->db->update('article', array('clicks' => $this->view->article['clicks'] + 1 ), 'art_id = ' . $artId);
        $this->view->comment = $this->db->fetchAll(
            $this->db->select()
                ->from('article_comment')
                ->where('art_id =?', $artId)
        );
    }


    /**
     * 评论
     */
    public function commentAction() {
        if($this->_request->isPost()){
            $arr = array(
                    'art_id'  =>  $this->_getParam('art_id'),
                    'comment_name'  =>  $this->_request->getPost('comment_name'),
                    'content'  =>  $this->_request->getPost('content'),
                    'add_time'  =>  time(),
               );

            !empty($arr['comment_name']) && $this->db->insert('article_comment', $arr);

        }
        $this->_redirect($this->view->url(array('module' => 'default', ), 'default', true) ."/article/" . $arr['art_id'] .".html");
    }
}

