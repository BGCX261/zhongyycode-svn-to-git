<?php
/**
 * 文章管理
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_ArticleController extends YUN_Controller_Action_Admin
{
    /**
     * 初始化
     */
    public function init(){
        parent::init();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->article = new ArticleModel();
        $this->view->layout =array(
            'title' => '文章管理',
            'action' => array(
                'list' => array(
                    'url' => array('module' => 'admin', 'controller' => 'article', 'action' => 'list'),
                    'text' => '文章列表',
                ),
                'add' => array(
                    'url' => array('module' => 'admin', 'controller' => 'article', 'action' => 'add'),
                    'text' => '添加文章',
                ),
            ),
            'current' => $this->module['action'],

        );

        $mcate = new CategoryModule();
        $this->view->db = $mcate->getDb();
        $this->view->cate = new YUN_Cate($this->view->db);
        $this->view->treeRow = $this->view->cate->jqCateList();
    }

    /**
     * 首页
     */
    public function indexAction()
    {}

    /**
     * 添加文章
     */
    public function addAction() {

        if($this->_request->isPost()){
            $d = $this->_request->getPost();
            try {
                $this->view->article->addArticle($d);
                $this->view->feedback(array(
                    'message'  => '添加信息成功',
                    'redirect'  => $this->view->url(array('action'=> 'list')),
                ));
            } catch (Exception $e) {
                 $this->view->feedback(array(
                    'message'  => '发生错误：' . $e->getMessage()
                ));
            }

        }
    }

    /**
     *  删除文章
     */
    public function delAction(){
        $artId = $this->_getParam("art_id");
        $this->view->article->deleArticle($artId);
        $this->_redirect($this->view->url(
            array('module' => 'admin', 'controller' => 'article', 'action' => 'list')
        ));
    }

    /**
     * 文章列表
     */
    public function listAction()
    {
        $sql = $this->db->select()->from('article')->ORDER('art_id DESC');
        $article = $this->db->fetchAll($sql);
        $paginator = YUN_Paginator::factory($article,$this->_request, 1);
        $this->view->paginator = $paginator;
    }

    /**
     * 编辑文章
     */
    public function editAction(){
        if (strtolower($_SERVER['REQUEST_METHOD']) =='post'){
            $edit = $this->_request->getPost();
            try {
                $this->view->article->editArticle($edit);
                $this->view->feedback(array(
                    'message'  => '添加信息成功',
                    'redirect'  => $this->view->url(array('action'=> 'list')),
                ));
            } catch (Exception $e) {
                 $this->view->feedback(array(
                    'message'  => '发生错误：' . $e->getMessage()
                ));
            }
        } else {
            $art_id = $this->_getParam("art_id");
            $this->view->layout = array(
                'title' => '文章管理',
                'action' => array(
                    'list' => array(
                        'url' => array('controller' => 'article', 'action' => 'list'),
                        'text' => '文章列表',
                    ),
                    'edit' => array(
                        'url' => array('controller' => 'article', 'action' => 'edit', 'art_id' => $art_id),
                        'text' => '编辑文章',
                    ),
                ),
                'current' => $this->module['action'],
            );
           $sql = $this->view->article
                ->select()
                ->from('article')
                ->where('art_id = ?', $art_id);
           $this->view->editRow = $editRow = $this->view->article->fetchRow($sql)->toArray();
           $this->view->Fck()->Value  = $editRow['content'];
           $this->isload = false;
           $this->render('add');
        }
    }

    /**
     * xh编辑器上图片
     */
    public function xhuploadAction()
    {
        $this->config = Zend_Registry::get('config');
        $this->config->upload->savePath = $this->config->upload->savePath . '/art_img';
        $this->upload = new YUN_File_Upload($this->config->upload);
        try {
            $fileData = $_FILES['upload'];
            $this->upload->save($fileData);
            $result   = $this->upload->getResult();
            $savename = str_replace(array(strip(WWW_DIR), '\\'), array('', '/'), $result['savename']);
            $data = array(
                'cate_id'       => 2,
                'uid'           => $this->auths->uid,
                'upload_time'   => time(),
                'download'      => 0,
                'filename'      => $result['filename'],
                'filesize'      => $result['filesize'],
                'filetype'      => $result['filetype'],
                'extension'     => $result['extension'],
                'savename'      => str_replace(array(strip(WWW_DIR), '\\'), array('', '/'), $result['savename']),
                'is_image'      => (int) $this->upload->isImage($result['filename']),
            );

            $this->db->insert('file', $data);
            $fileId = $this->db->lastInsertId();
            echo json_encode(array('err' => '', 'msg' => 'http://www.yunphp.cn/public/' . $savename));
            die();
        } catch (Exception $e) {
            echo json_encode(array('err' => '上传失败：' . $e->getMessage(), 'msg' => ''));
            die();
        }
        $this->isload = false;
    }
}
