<?php
/**
 * Category Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class CategoryModule extends  Zend_Db_Table {
    protected $_name = 'category';
    protected $_primary = 'cate_id';
    protected $_db          = null;

    /**
     * 初始化
     *
     */
    public function init() {
        $this->db = $this->getAdapter();
    }
    /**
     * 分类列表
     *
     * @return array
     */
    public function listCate(){
//        var_dump($this->db);
//          $arr = array(
//                'news_title'  =>  $data['news_title'],
//                'news_desc'  =>  $data['news_desc'],
//                'news_content'  =>  nl2br($data['FCKcontent']),
//                'posttime'  =>  $data['posttime'],
//                'author'  =>  $data['author'],
//           );
//
//
//          $this->insert($arr);
     return $this->db->fetchAll("SELECT * FROM `category` ");

    }

    public function getDb() {
        return $this->db;
    }
}