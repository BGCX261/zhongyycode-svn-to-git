<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 上传
 */
class Controller_Upload extends Controller_Base {


    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        ORM::factory('user')->upcache($this->auth['uid']);
        $this->template->auth = $this->auth = Session::instance()->get('user', false);
    }

    public function action_index()
    {
         $this->checkSpace();
         $this->request->redirect('/upload/add');
    }
    /**
     *上传
     */
    public function action_add()
    {
        //$this->checklogin();
        //$this->checkSpace();
        // 图片分类列表
        $uid = (int) $this->getQuery('uid', @$this->auth['uid']);
        $cate = new Category();
        $this->template->cate_list = $cate_list = $cate->getCates($uid);

        $user = ORM::factory('user')->where('uid', '=', $uid)->find();

        if ((int) $user->uid > 0 ) {
            if($user->check_expire($uid)){
                $this->show_message('您的帐号已过期或空间不足，请续费或完成积分任务,再进行操作');
                die();
            }
            if($user->check_space($uid)){
                $this->show_message('您的帐号已过期或空间不足，请续费或完成积分任务,再进行操作');
                die();
            }
            $cate_id = (int) $this->getQuery('cate_id');
            $img = ORM::factory('img');
            if (!empty($_FILES)) {
                // 取得硬盘目录
                $disks = ORM::factory('img_disk')->where('is_use', '=', 1)->find();

                //图片保存目录
                $save_dir = ORM::factory('user', $uid)->save_dir;
                $savePath = DOCROOT . '' . $disks->disk_name . '/' . $save_dir . '/';
                $upload = new Upload();
                $upload->set_path($savePath);
                $result = $upload->save($_FILES['Filedata']);

                $img->picname = $result['saveName'];
                $img->filename = $result['name'];
                $img->filesize = $result['size'];
                $img->userid =  $uid;
                $custom = pathinfo($result['name']);
                $img->custom_name = $custom['filename'];
                $img->disk_id = $disks->disk_domain;
                $img->cate_id = $cate_id;
                $img->disk_name = $disks->disk_name . '/' . $save_dir;
                $img->save();

                $picname = $savePath . $result['saveName'];
                $this->thumb->create($picname, 130, 130);
                // 统计数据


            }
        } else {
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
            die();
        }

    }

    /**
     * 普通图片上传
     */
    public function action_basic()
    {
        $this->checklogin();
        $this->checkSpace();

        // 图片分类列表
        $this->template->cate_list = $cate_list =  DB::select()->from('img_categories')
            ->where('uid', '=', (int) $this->auth['uid'])
            ->fetch_all();
        if ($this->isPost()) {
            $arr = $list = array();
            $cate_id = (int) $this->getPost('cate_id');
            foreach ($_FILES['pictures']['name'] as $key => $item) {
                if (!empty($item)) {
                    $arr['name'] = $item;
                    $arr['type'] = $_FILES['pictures']['type'][$key];
                    $arr['tmp_name'] = $_FILES['pictures']['tmp_name'][$key];
                    $arr['error'] = $_FILES['pictures']['error'][$key];
                    $arr['size'] = $_FILES['pictures']['size'][$key];
                    try {
                         // 取得硬盘目录
                        $disks = ORM::factory('img_disk')->where('is_use', '=', 1)->find();
                        //图片保存目录
                        $save_dir = ORM::factory('user', (int) $this->auth['uid'])->save_dir;
                        $savePath = DOCROOT . '' . $disks->disk_name . '/' . $save_dir . '/';
                        $upload = new Upload(array('size' =>  5120));
                        $upload->set_path($savePath);
                        $result = $upload->save($arr);

                        $img = ORM::factory('img');
                        $img->picname = $result['saveName'];
                        $img->filename = $result['name'];
                        $img->filesize = $result['size'];
                        $img->userid =  (int) $this->auth['uid'];
                        $custom = pathinfo($result['name']);
                        $img->custom_name = $custom['filename'];
                        $img->disk_id = $disks->disk_domain;
                        $img->cate_id = $cate_id;
                        $img->disk_name = $disks->disk_name . '/' . $save_dir;
                        $img->save();
                        $picname = $savePath . $result['saveName'];
                        @$this->thumb->create($picname, 130, 130);


                    } catch (Exception $e) {
                         $this->show_message($e->getMessage());
                    }

                }
            }
                $links[] = array(
                    'text' => '查看图片列表',
                    'href' => '/category/list'
                );
                $links[] = array(
                    'text' => '继续上传',
                    'href' => '/upload/basic'
                );
                $this->show_message('上传图片成功',1,$links,true, 10000);
                exit();

        }

    }






}