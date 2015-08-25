<?php
/**
 * 文件上传
 *
 * @package    controller       system manage
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_FileController extends YUN_Controller_Action_Admin
{
    /**
     * FileModel
     * @var FileModel
     */
    public $file = null;

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        $this->view->layout =array(
            'title' => '上传文件管理',
            'action' => array(
                'list' => array(
                    'url' => array('module' => 'admin', 'controller' => 'file', 'action' => 'list'),
                    'text' => '文件列表',
                ),
                'add' => array(
                    'url' => array('module' => 'admin', 'controller' => 'file', 'action' => 'add'),
                    'text' => '上传',
                ),
                'cateList' => array(
                    'url' => array('module' => 'admin', 'controller' => 'file', 'action' => 'catelist'),
                    'text' => '分类',
                ),

            ),
            'current' => $this->module['action'],
        );
        $this->file = new FileModel();
        $this->config = Zend_Registry::get('config');
        $this->fileBasePath = $this->config->upload->savePath;

    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $cache = Zend_Registry::get('cache');
        $result = $cache->load('time_id');
        if(!$result) {
            echo $time = date('Y-m-d H:i:s');
            $cache->save($time, 'time_id');
        }
        print_r($result);

        $this->isload = false;
    }

    /**
     * 上传
     */
    public function addAction()
    {
        if ($this->_request->isPost()){
            $post = $this->_request->getPost();
            $post['uid'] = $this->auths->uid;
            $fileData = $_FILES['file'];
            $data = $this->file->add($post, $fileData, false);
            $this->_redirect($this->view->url(array('action' => 'list')));
        }
        $this->view->cateId     = $this->_getParam('id');
        $select = $this->file->cateListSql()->where('cate.allow_upload=1');
        $this->view->categories = $this->db->fetchAll($select);
    }

    /**
     * 文件列表
     */
    public function listAction()
    {
        $keyword = $this->view->keyword = $this->_getParam('keyword');
        $cateId  = $this->view->cateId  = (int) $this->_getParam('cate_id', 0);

        $select = $this->file->listSql();

        if ($cateId > 0) {
            $select->where('file.cate_id=?', $cateId);
        }
        if (!empty($keyword)) {
            $select->where('file.filename like ? OR file.description like ?', "%$keyword%", "%$keyword%");
        }
        $select = $select->order('file.file_id DESC');
        $rows = $this->db->fetchAll($select);
        $this->view->paginator = YUN_Paginator::factory($rows, $this->_request, 10);
    }

    /**
     * 分类列表
     */
    public function catelistAction()
    {
        $select = $this->db->select()
            ->from(array('cate' => 'file_category'));
        $this->view->categories = $this->db->fetchAll($select);
    }

    /**
     * 添加分类
     */
    public function cateaddAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->file->cateAdd($this->_request->getPost());
                $this->_redirect($this->view->url(array('action'=> 'catelist')));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'message'  => '发生错误：' . $e->getMessage()
                ));
            }
        }
    }

     /**
     * 编辑分类
     *
     */
    public function cateeditAction()
    {
        if ($this->_request->isPost()) {
            try {
                $this->file->cateEdit($this->_request->getPost());
                $this->_redirect($this->view->url(array('action' => 'cateList')));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'message'  => '发生错误：' . $e->getMessage()
                ));
            }
        }
        $this->isload = null;
    }


    /**
     * 删除分类
     *
     */
    public function catedelAction()
    {
        try {
            $this->file->cateDel((int) $this->_getParam('id'));
            $this->_redirect($this->view->url(array('action' => 'cateList')));
        } catch (Exception $e) {
            $this->view->feedback(array(
                'message'  => '发生错误：' . $e->getMessage()
            ));
        }
        $this->isload = null;
    }

    /**
     * 删除文件
     *
     */
    public function deleteAction()
    {
        try {
            $this->file->delete((int)$this->_getParam('id'));
            $this->_redirect($this->view->url(array('action' => 'list')));
        } catch (Exception $e) {
            $this->view->feedback(array(
                'message'  => '发生错误：' . $e->getMessage()
            ));
        }
        $this->isload = false;
    }
}