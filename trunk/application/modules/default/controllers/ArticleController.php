<?php
/**
 * 文章
 * @package    Controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('APP_DIR') && die('Access Deny!');

class ArticleController extends YUN_Controller_Action
{
    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
    }

    /**
     * 分类下文章
     *
     */
    public function cateAction()
    {
        $cateId = $this->_getParam('cate_id');
        $select = $this->db->select()
            ->from('article',
                array('art_id', 'title', 'brief', 'clicks', 'comments', 'save_time', 'content')
            )
            ->joinLeft('category',
                'category.cate_id = article.cate_id',
                array('cate_name', 'cate_id')
            )
            ->where('article.cate_id =?', $cateId);
        $article = $this->db->fetchAll($select);
        $numPerPage = 1;  // 每页显示的条数
        $paginator = Zend_Paginator::factory($article);

        $paginator->setItemCountPerPage($numPerPage);

        $this->view->paginator = $paginator;

        if($this->_getParam('page') > 0) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
        }

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
        $this->view->article = $this->db->fetchRow($select);

        $this->db->update('article', array('clicks' => $this->view->article['clicks'] + 1 ), 'art_id = ' . $artId);
        $this->view->comment = $this->db->fetchAll(
            $this->db->select()
                ->from('article_comment')
                ->where('art_id =?', $artId)
        );

    }

}