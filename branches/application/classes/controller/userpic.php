<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户中心图片列表管理
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-14
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Userpic extends Controller_Base {


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
    }

    /**
     * 首页
     */
    public function action_index()
    {
    }

    /**
     * 移动图片
     */
    public function action_movepic()
    {
        if ($this->isPost()) {
            $id = $this->getPost('id');

            $cate_id = (int) $this->getPost('to_cate_id');
            $from_id = (int) $this->getPost('cate_id', 0);
            $u = urldecode($this->getQuery('u'));
            if (empty($id) ||  $cate_id < 0) {
                $this->show_message('请选择要移动的相片和要移动的相册');
            }
            if (!is_array($id)) {
                $id = array($id);
            }

            if ($cate_id >= 0 ) {
                foreach ($id as $value) {
                    $info = ORM::factory('img')->where('id', '=', (int) $value)->find();
                    DB::update('imgs')->set(array('cate_id' => $cate_id))->where('id', '=', $value)->execute();
                    DB::update('img_categories')->set(array('img_num' => DB::expr('img_num + 1')))->where('cate_id', '=', $cate_id)->execute();
                    DB::update('img_categories')->set(array('img_num' => DB::expr('img_num - 1')))->where('cate_id', '=', $info->cate_id)->execute();
                }
            }
            if (!empty($u)) {
                $this->request->redirect($u);
            } else {
                $this->request->redirect('/category/list');
            }

        }
        $this->auto_render = false;
    }

    /**
     * 设置图片共享
     */
    public function action_setshare()
    {
        if ($this->isPost()) {
            $id = $this->getPost('id');

            $app = trim($this->getQuery('app'));
            $u = urldecode($this->getQuery('u'));
            if (empty($id)) {
                $this->show_message('请选择要共享的相片', 1, $links, false);
            }
            if (!is_array($id)) {
                $id = array($id);
            }
            foreach ($id as $value) {
                if ($app == 'del') {
                    DB::update('imgs')->set(array('is_share' => 0))->where('id', '=', $value)->execute();
                } else {
                    DB::update('imgs')->set(array('is_share' => 1))->where('id', '=', $value)->execute();
                }
            }
            if (!empty($u)) {
                $links[] = array(
                    'text' => '返回',
                    'href' => $u,
                );
                $this->show_message('设置共享操作成功', 1, $links, true);
            } else {
                $this->request->redirect('/userpic/list');
            }
        }
        $this->auto_render = false;
    }

    /**
     * 回收站
     */
    public function action_recycle()
    {
        $id = $this->getQuery('id');
        if (empty($id)) {
            $this->show_message('请选择要删除的文件', 1, $links);
        }
        if (!is_array($id)) {
            $id = array($id);
        }

        $recycle = (int) $this->getQuery('recycle', 1);
        $u = urldecode($this->getQuery('u'));

        foreach($id as $value) {
            $info = ORM::factory('img')->where('id', '=', $value)->find();
            if ($this->auth['uid'] != $info->userid) {
                $this->show_message('你不能操作不是你的图片', 0, array(), true);
            }
            if ($recycle && $info->cate_id != 0) {
                DB::update('img_categories')->set(array('img_num'=> DB::expr('img_num - 1')))->where('cate_id', '=', $info->cate_id)->execute();
            }
            DB::update('imgs')->set(array('recycle'=> $recycle))->where('id', '=', $value)->execute();
        }
        if (!empty($u)) {
            $this->request->redirect($u);
        } else {
            $this->request->redirect('/category/list' );
        }
        $this->auto_render = false;

    }

    /**
     * 删除原操作图片
     */
    public function action_delpic()
    {

        $id = $this->getQuery('id');
        $u = urldecode($this->getQuery('u'));
        if (empty($id)) {
            $this->show_message('请选择要删除的文件', 1, $links);
        }
        if (!is_array($id)) {
            $id = array($id);
        }

        $rows = DB::select()
            ->from('imgs')
            ->where('userid', '=', (int) $this->auth['uid'])
            ->where('id', 'in', $id)
            ->fetch_all();
        if (!empty($rows)) {
            $rows = new Arrayobj($rows);
            foreach ($rows as $row) {
                if ($row->userid == (int)$this->auth['uid']){

                    // 添加图片到删除缓存表中
                    $url = 'http://'.$row->disk_id . '.wal8.com/';
                    $img_path = $row->disk_name . '/' . $row->picname;
                    $thumb_130 = $this->thumb->create2($img_path, 130, 130);
                    $data = array(
                        'img_url' => $url . $thumb_130,
                        'add_time' => time(),
                        'uid' => $this->auth['uid']
                    );
                    @unlink(Io::strip(DOCROOT.  $thumb_130));
                    $this->squid_img($data);

                    /*$thumb_120 = $thumb->create2($img_path, 120, 120);
                    $data['img_url'] = $url . $thumb_120;
                    $this->squid_img($data);
                    @unlink(Io::strip(DOCROOT. $thumb_120));*/

                    $thumb_65 = $this->thumb->create2($img_path, 65, 65);
                    $data['img_url'] = $url . $thumb_65;
                    $this->squid_img($data);
                    @unlink(Io::strip(DOCROOT. $thumb_65));

                    $thumb_640 = $this->thumb->create2($img_path, 640, 640, 's');
                    $data['img_url'] = $url . $thumb_640;
                    $this->squid_img($data);
                    @unlink(Io::strip(DOCROOT.  $thumb_640));

                    $data['img_url'] = $url . $img_path;
                    $this->squid_img($data);

                    // 删除评论
                    DB::delete('comments')->where('item_id', '=', $row->id)->where('app', '=', 'img')->execute();
                    // 删除图片记录
                    DB::delete('imgs')->where('id', '=', $row->id)->execute();

                    $picPath = pathinfo($row->disk_name .'/'. $row->picname);

                    @unlink(Io::strip(DOCROOT.  $row->disk_name .'/'. $row->picname));
                    // 删除标签
                    $tag = new tags();
                    $tag->del($row->id, 'app');
                }
            }
        }
        $type = $this->getQuery('type');
        if ($type == 'ajax') {
            echo 'success';
            die();
        }
        if (!empty($u)) {
            $this->request->redirect($u);
        } else {
            $this->request->redirect('/category/list');
        }
        $this->auto_render = false;
    }
    /**
     * 清空回收站
     */
    public function action_clear()
    {
        $rows = DB::select()
            ->from('imgs')
            ->where('userid', '=', (int) $this->auth['uid'])
            ->where('recycle', '=', 1)
            ->fetch_all();
        if (!empty($rows)) {
            $rows = new Arrayobj($rows);
            foreach ($rows as $row) {
                if ($row->userid == (int)$this->auth['uid']){
                    // 添加图片到删除缓存表中
                    $url = 'http://'.$row->disk_id . '.wal8.com/';
                    $img_path = $row->disk_name . '/' . $row->picname;
                    $thumb_130 = $this->thumb->create2($img_path, 130, 130);
                    $data = array(
                        'img_url' => $url . $thumb_130,
                        'add_time' => time(),
                        'uid' => $this->auth['uid']
                    );
                    @unlink(Io::strip(DOCROOT.  $thumb_130));
                    $this->squid_img($data);

                    /*$thumb_120 = $thumb->create2($img_path, 120, 120);
                    $data['img_url'] = $url . $thumb_120;
                    $this->squid_img($data);
                    @unlink(Io::strip(DOCROOT.  $thumb_120));*/

                    $thumb_65 = $this->thumb->create2($img_path, 65, 65);
                    $data['img_url'] = $url . $thumb_65;
                    $this->squid_img($data);
                    @unlink(Io::strip(DOCROOT.  $thumb_65));

                    $thumb_640 = $this->thumb->create2($img_path, 640, 640, 's');
                    $data['img_url'] = $url . $thumb_640;
                    $this->squid_img($data);
                    @unlink(Io::strip(DOCROOT.  $thumb_640));

                    $data['img_url'] = $url . $img_path;
                    $this->squid_img($data);

                    // 删除评论
                    DB::delete('comments')->where('item_id', '=', $row->id)->where('app', '=', 'img')->execute();
                    // 删除图片记录
                    DB::delete('imgs')->where('id', '=', $row->id)->execute();



                    @unlink(Io::strip(DOCROOT.  $row->disk_name .'/'. $row->picname));
                    // 删除标签
                    $tag = new tags();
                    $tag->del($row->id, 'app');
                }
            }
        }
        echo 'success';
        //$this->request->redirect('/category/list?recycle=1');
        $this->auto_render = false;
    }

    /**
     * 设置分类封面图片
     */
    public function action_catetop()
    {

        $pid = (int) $this->getQuery('id');
        $cate_id = (int) $this->getQuery('cate_id');
        $info = DB::select('i.id','i.cate_id', 'i.picname', 'i.custom_name', 'i.disk_id', 'i.userid', 'i.click', 'i.is_share', 'd.disk_domain', 'cate.cate_name',array('i.disk_name', 'img_dir'))
            ->from(array('imgs', 'i'))
            ->join(array('img_disks', 'd'), 'LEFT')
            ->on('d.disk_domain', '=', 'i.disk_id')
            ->join(array('img_categories', 'cate'), 'LEFT')
            ->on('cate.cate_id', '=', 'i.cate_id')
            ->where('i.id', '=', $pid)->execute()->current();
        if (!empty($info)) {
            $img = URL::domain() .$this->thumb->create($info['img_dir'] .'/' . $info['picname'], 130,130);
            DB::update('img_categories')->set(array('index_img' => $img, 'index_img_id' => $pid))->where('cate_id', '=', $cate_id)->execute();
            $this->request->redirect('/category/list?cate_id='. $cate_id);
        }
        $this->auto_render = false;
    }

    public function squid_img($data)
    {
        if (!empty($data)) {
            DB::insert('squid.reset_img_cache',array_keys($data))->values(array_values($data))->execute();
        }
    }
}
