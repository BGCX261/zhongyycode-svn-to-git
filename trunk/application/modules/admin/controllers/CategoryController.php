<?php
/**
 * 文章分类管理
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_CategoryController extends YUN_Controller_Action_Admin
{
    public $cate = null;

    /**
     * 初始化操作
     */
    public function init()  {
        parent::init();
        $this->view->layout= array(
            'title' => '分类管理',
            'action' => array(
                'list' => array(
                    'url' =>array('module' => 'admin','controller' => 'category','action' => 'list'),
                    'text' => '新增分类',
                ),
            ),
            'current' => $this->module['action'],
        );

        $mcate = new CategoryModule();
        $this->cate = new YUN_Cate($this->db);
    }


    /**
     * 分类列表
     */
    public function listAction()
    {
        $this->view->cateList = $this->cate->cateList();
        $cate_id = $this->view->cate_id = $this->_getParam('cate_id');
        $this->view->info = array(
            'cate_id' => 0,
            'cate_name' => '',
            'parent_id' => 0,
            'sort_order' => 0,
            'is_show' => 0,
        );
        if ($cate_id > 0) {
             $select = $this->cate->infoSql($cate_id);
             $this->view->info = $this->db->fetchRow($select);
        }
         $this->isload = false;
         $this->render('category');
    }

    /**
     * 删除分类
     */
    public function delAction()
    {
        try {
            $cateId = (int) $this->_getParam('cate_id');
            $this->cate->delCate($cateId);
            $this->_redirect('admin/category/list');//转到首页
        } catch (Exception $e) {
            $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
            ));
        }
    }

    /**
     * 添加分类
     */
    public function addAction()
    {
        if ($this->_request->getPost()) {
            $data = array(
                'cate_id'   => $this->_getParam('cate_id'),
                'cate_name' => $this->_getParam('cate_name'),
                'is_show'   => $this->_getParam('is_show'),
                'parent_id' => $this->_getParam('parent_id'),
                'sort_order'=> $this->_getParam('sort_order'),
            );
            $validator = $this->_validate($data);
            if (!$validator->isValid()) {
                 $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $validator->getMessage(),
                ));
            }
            try {
                $this->cate->add($data);
                $this->_redirect('admin/category/list');//转到首页
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
    }

    /**
     * 编辑分类
     */
    public function updateAction()
    {
        if ($this->_request->getPost()) {
            $data = array(
                'cate_id'   => (int) $this->_getParam('cate_id'),
                'cate_name' => $this->_getParam('cate_name'),
                'is_show'   => $this->_getParam('is_show'),
                'parent_id' => $this->_getParam('parent_id'),
                'sort_order'=> (int) $this->_getParam('sort_order'),
            );

            $validator = $this->_validate($data);
            if (!$validator->isValid()) {
                 $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $validator->getMessage(),
                ));
            }

            try {
                if ($data['cate_id'] == $data['parent_id']) throw new Exception('不能添加自己为父类');
                $this->cate->update($data);
                $this->_redirect('admin/category/list');//转到首页
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
    }

    /**
     * 对数据进行校验
     *
     * @param  array  $data
     * @return YUN_Validator
     */
    protected function _validate(array $data)
    {
        $validator = new YUN_Validator();
        $validator->check(
                $data['cate_name'],
                array(
                    array('NotEmpty', '分类名称不允许为空'),
                    array('StringLength' => array(2, 20), '分类名称必须介于 2~20 个字符之间'),
                )
            )
            ->check(
                $data['sort_order'],
                array(
                    array('Numeric' , '排序必须是数字'),
                )
            )
            ->check(
                $data['cate_id'],
                array(
                    array('Numeric' , '分类ID必须是数字'),
                )
            );
        return $validator;
    }
}