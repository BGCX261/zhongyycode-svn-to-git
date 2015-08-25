<?php
/**
 * /admin/link
 *
 * @package    controller       news manage
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_LinkController extends YUN_Controller_Action_Admin
{
    /**
     * 初始化
     */
    public function init(){
        parent::init();
        $this->view->layout =array(
            'title' => '链接管理',
            'action' => array(
                'list' => array(
                    'url' => array('module' => 'admin','controller' => 'link', 'action' => 'list'),
                    'text' => '链接列表',
                ),
                'set' => array(
                    'url' => array('module' => 'admin', 'controller' => 'link', 'action' => 'set'),
                    'text' => '链接添加',
                ),
            ),
            'current' => $this->module['action'],
        );

    }

    /**
     * 添加链接
     */
    public function setAction() {
        if ($this->_request->isPost()){
            $data = $this->_request->getPost();
            $arr = array(
                'link_name'  =>  trim($this->_request->getPost('link_name')),
                'link_url'   =>  trim($this->_request->getPost('link_url')),
                'save_time'  =>  time(),
            );
            $linkId = (int) $this->_request->getPost('link_id');
            if ($linkId > 0) {
                $where = $this->db->quoteInto('link_id = ?', $linkId);
                unset($arr['save_time']);
                $this->db->update('link', $arr, $where);
            } else {
                $this->db->insert('link', $arr);
            }
            $this->_redirect('/admin/link/list');
        }
        $link_id = (int) $this->_getParam("link_id");
        if ($link_id > 0) {
            $sql = $this->db->select()
                    ->from('link')
                    ->where('link_id = ?', $link_id);
           $this->view->editRow = $editRow = $this->db->fetchRow($sql);
        }
    }

    /**
     * 列表
     */
    public function listAction(){
        $sql = $this->db->select()->from('link', '*');
        $rows = $this->db->fetchAll($sql); // 取出数据集
        $this->view->rows = $rows;
    }

    /**
     *  删除链接
     */
    public function delAction(){
        $linkId = $this->_getParam("link_id");
        $where = $this->db->quoteInto('link_id = ?', $linkId);
        $this->db->delete('link', $where);
        $this->_redirect($this->view->url(array('controller' => 'link', 'action' => 'list')));   //转到首页
        $this->isload = false;
    }

}