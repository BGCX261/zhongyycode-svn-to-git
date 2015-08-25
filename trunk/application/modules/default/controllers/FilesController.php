<?php
/**
 * 文件管理
 *
 * @package    controller       system manage
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class FilesController extends YUN_Controller_Action
{
    /**
     * FileModel
     * @var FileModel
     */
    public $file = null;

    /**
     * 初始化
     *
     */
    public function init()
    {
        parent::init();
        $this->file = new FileModel();
    }

   /**
     * 文件下载
     */
    public function downloadAction()
    {
        try {
            $this->file->download($this->_getParam('id'));
        } catch (Exception $e) {
            $this->view->feedback(array(
                'title'    => '发生错误',
                'message'  => '指定的文件不存在或者已经被删除',

                'linktext' => '点击继续',
            ));
        }
        $this->isload = false;
    }

}