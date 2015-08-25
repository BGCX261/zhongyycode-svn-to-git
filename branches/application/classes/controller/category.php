<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户相册分类管理
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-13
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Category extends Controller_Base {

     /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        if(!$this->auth){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login',
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
        }
        $this->cate = new Category();

    }

    /**
     * 查看相册
     */
    public function action_list()
    {
        if (ORM::factory('user')->check_space($this->auth['uid'])) {
        } else {
            $this->checkSpace(); //空间验证
        }
        $this->_add_script('scripts/copy.js');
        $this->_add_script('scripts/wal8/menu.js');
        $this->template->pageTitle = '查看相册';
        ORM::factory('user')->upcache($this->auth['uid']);
        $this->template->num = $num = $this->getQuery('num', 20);
        $select = DB::select('cate.cate_id', 'cate.cate_name', 'cate.index_img', 'cate.img_num', 'cate.is_share', 'cate.type', 'cate.index_img_id')
            ->from(array('img_categories', 'cate'))
            ->where('uid', '=',(int) $this->auth['uid']);

       $select2 = DB::select('i.id','i.cate_id', 'i.picname', 'i.custom_name', 'i.disk_id', 'i.userid', 'i.click', 'i.is_share',  'i.disk_name', array('i.disk_id', 'disk_domain'))
            ->from(array('imgs', 'i'))
            ->where('i.userid', '=', (int) $this->auth['uid']);
        $this->template->order_by = $order_by = trim($this->getQuery('order_by'));
        if (!empty($order_by)) {
            $select2->order_by('i.id', $order_by);
        }



        $this->template->cate_id = $cate_id = (int)$this->getQuery('cate_id');
        $this->template->recycle = $recycle = (int)($this->getQuery('recycle'));
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        $this->template->type = $type = trim($this->getQuery('search_type'));
        if ($cate_id > 0) {
            $select->where('cate.parent_id', '=', $cate_id);
            $select2->where('i.cate_id', '=',(int) $cate_id)->where('i.recycle', '=', 0);
        } else {
            if ($recycle) {
                $select2->where('i.recycle', '=', '1');
                $select->where('cate.cate_name', '=', null);
            } else {
                $select2->where('i.recycle', '=', 0);
                 if (empty($keyword)) {
                     $select2->where('i.cate_id', '=', 0);
                 }
                $select->where('cate.parent_id', '=', 0);
            }
        }

        if (!empty($keyword)) {
            if ($type == 1) {
                $select->where('cate.cate_name', 'like', "%$keyword%");
                if($cate_id <= 0) {
                $select2->where('i.cate_id', '=', (int)$keyword);
                }
            } else {
                $select->where('cate.cate_name', '=', null);
                $select2->where('i.custom_name', 'like', "%$keyword%");
            }
        }
        $this->template->order_by = $order_by = trim($this->getQuery('order_by', 'DESC'));
        if (!empty($order_by)) {
            $select->order_by('cate.cate_id', $order_by);
            $select2->order_by('i.id', $order_by);
        }

        $this->template->pic_num = $pic_num = $select2->count_all();
        $this->template->cate_num = $cate_num = $select->count_all();

        $pageNum = $pic_num + $cate_num;
        // 显示分页链接（图片+分类的）
        $this->template->pagination = $pagination = Pagination::factory(array(
            'total_items' => $pageNum,
            'items_per_page' => $num
            )
        );

        // 分类结果
        $this->template->results = $results = $select->limit($pagination->items_per_page)
            ->offset($pagination->offset)->execute();

        //需要显示多少张图片, 每页显示数－当前显示目录数
        $piclimit = $pagination->items_per_page - count($results->as_array());

        if ($piclimit > 0) {
            //图片从几条数据取起
            $offset = $pagination->offset - $cate_num;
            if ($offset < 0) $offset = 0;
            $select2 = $select2->limit($piclimit)->offset($offset);

            $this->template->rootresults = $select2->execute();
        }

        
        // 图片分类列表
        $this->template->cate_list = $cate_list =  DB::select('cate_name','cate_id', 'path')->from('img_categories')
            ->where('uid', '=', $this->auth['uid'])
            ->fetch_all();
        $arr = array();

        if ($cate_id > 0) {
            $cate = new Category();
            $path = $cate->getPath($cate_id);
            $path = explode(';', $path);

            foreach($path as $value){
                if (!empty($value)) {
                    $info = $cate->infoSql($value)->execute()->current();
                    $arr[$value] = $info['cate_name'];
                }
            }
            $this->template->cateInfo = $cateInfo = $cate->infoSql($cate_id)->execute()->current();

        }

        $this->template->arr = $arr;
    }


    /**
     * 增加相册
     *
     */
    public function action_addcate()
    {
        $this->checkSpace(); //空间验证
        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('cate_name', 'not_empty');
            if ($post->check()) {
                 $cate = new Category();
                $arr = array(
                    'cate_name' => trim($this->getPost('cate_name')),
                    'uid' => $this->auth['uid'],
                    'parent_id' => (int) $this->getPost('parent_id')
                );

                try {
                    $lastId = $cate->add($arr);
                    $this->request->redirect('/category/list?cate_id=' . $lastId);
                } catch (Exception $e) {
                    $this->show_message('操作失败：' . $e->getMessage());
                }

            } else {
                $e = $post->errors('');
                $this->show_message($e);
            }
        }
        $this->auto_render = false;
    }

    /**
     * 编辑相册名
     */
    public function action_edit()
    {
        $cate_id = (int) $this->getQuery('cate_id');
        $cate_name = trim($this->getQuery('cate_name'));
        $info = ORM::factory('img_category')
            ->where('cate_name', '=', $cate_name)
            ->where('uid', '=', $this->auth['uid'])
            ->find();
        if ($info->cate_name) {
            echo $info->cate_name .'该相册名已经存在，不允许修改';
            die();
        }
        if ( !empty($cate_name) && $cate_id > 0) {
            DB::update('img_categories')->set(array('cate_name' => $cate_name))->where('cate_id', '=', $cate_id)->where('uid', '=', $this->auth['uid'])->execute();
            echo '修改相册名成功';
        } else {
            echo '修改相册名成功';
        }
        $this->auto_render = false;
    }

    /**
     * 删除分类
     */
    public function action_del()
    {
        $cate_id = (int) $this->getQuery('cate_id');

        if ( $cate_id > 0) {

            // 先检查该分类是否有子分类
            $child = DB::select('cate_id')->from('img_categories')
                        ->where('uid', '=', $this->auth['uid'])
                        ->where('parent_id', '=', $cate_id)
                        ->limit(1)
                        ->fetch_row();

            if (!empty($child)) {
               // throw new Exception('该分类下有子分类，必须先删除或者转移所有子分类才能删除父分类');
                $this->show_message(array('该分类下有子分类，必须先删除或者转移所有子分类才能删除父分类'));
            }

            $parent_id = DB::select('parent_id')->from('img_categories')
                        ->where('uid', '=', (int) $this->auth['uid'])
                        ->where('cate_id', '=', $cate_id)
                        ->limit(1)
                        ->fetch_one();
            $url = '';
            if ($parent_id > 0){
                $url = '?cate_id=' . $parent_id;
            }
            DB::update('imgs')->set(array('recycle' => 1, 'cate_id' => 0))->where('cate_id', '=', (int) $cate_id)->where('userid', '=', (int) $this->auth['uid'])->execute();
            DB::delete('img_categories')->where('cate_id', '=', $cate_id)->where('uid', '=', (int) $this->auth['uid'])->execute();

            $links[] = array(
                    'text' => '返回',
                    'href' => '/category/list' . $url,
            );
            $this->show_message(array('删除相册成功', '该相册的图片已转移到回收'), 1, $links, true);
        } else {
            $links[] = array(
                    'text' => '返回',
                    'href' => '/category/list',
            );
            $this->show_message(array('删除相册失败'), 1, $links, true);
        }
        $this->auto_render = false;
    }

    /**
     * 设置图片共享
     */
    public function action_setShare()
    {
        $cate_id = $this->getQuery('cate_id');
        $app = trim($this->getQuery('app'));
        $from = urldecode($this->getQuery('from'));
        if (empty($cate_id)) {
            $this->show_message('请选择要设置共享的相册');
        }

        if ($app == 'del') {
            DB::update('img_categories')->set(array('is_share' => 0))->where('cate_id', '=', (int) $cate_id)->execute();
            DB::update('imgs')->set(array('is_share' => 0))->where('cate_id', '=', $cate_id)->execute();
        } else {
            DB::update('img_categories')->set(array('is_share' => 1))->where('cate_id', '=', (int) $cate_id)->execute();
            DB::update('imgs')->set(array('is_share' => 1))->where('cate_id', '=', (int) $cate_id)->execute();
        }
        $url = '/category/list';
        if(!empty($from)) {
            $url = $from;
        }
        $this->request->redirect($url);

        $this->auto_render = false;
    }

    /**
     * 图片目录管理
     */
    public function action_manage()
    {
        $this->_add_css('styles/album/book_manage.css');
        $this->_add_script('scripts/dtree.js');
        $this->_add_script('scripts/jquery/jquery.form.min.js');
        $this->template->pageTitle = '管理图片目录';
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
        $this->template->cateInfo = $this->cate->infoSql($cateId)->fetch_row();
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
