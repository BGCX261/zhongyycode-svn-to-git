<?php
/**
 * Article Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class ArticleModel extends  Zend_Db_Table {

    protected $_name = 'article';
    protected $_primary = 'art_id';
    protected $_db          = null;

    /**
     * 初始化
     *
     */
    public function init() {
        $this->db = $this->getAdapter();
    }

    /**
     * 增加文章
     * @param array $data
     */
    public function addArticle( array $data){
          $arr = array(
                'title'  =>  $data['title'],
                'brief'  =>  $data['brief'],
                'content'  => $data['FCKcontent'],
                'cate_id' =>  $data['cate_id'],
                'save_time'  =>  time(),
           );

        $validator = $this->_validate($arr);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }
        $this->insert($arr);

    }

    /**
     * 删除
     * @param int $id
     */
    public function deleArticle($id) {
        $this->delete('art_id = '. (int) $id);
    }

    /**
     * 编辑
     * @param array $data
     */
    public function editArticle(array $data){
        $arr = array(
                'title'  =>  $data['title'],
                'brief'  =>  $data['brief'],
                'content'  => $data['FCKcontent'],
                'cate_id' =>  $data['cate_id'],
                'save_time'  =>  time(),
           );
        $validator = $this->_validate($arr);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }
        $where = $this->db->quoteInto('art_id = ?', $data['art_id']);
        $this->update($arr, $where);
    }

    /**
     * 验证文件上传 POST 数据
     * @param  array  $data
     * @return EGP_Validator
     */
    protected function _validate(array $data)
    {
        $validator = new YUN_Validator();
        return $validator->check(
                @$data['title'],
                array(
                    array('NotEmpty', '标题不能为空'),
                )
            )
            ->check(
                @$data['content'],
                array(
                    array('NotEmpty' , '信息内容不能为空')
                )
            )
            ->check(
                @$data['cate_id'],
                array(
                    array('NotEmpty' , '信息分类不能为空'),
                    array('Integer', '信息分类 ID 必须是一个数字')
                )
            );
    }
}