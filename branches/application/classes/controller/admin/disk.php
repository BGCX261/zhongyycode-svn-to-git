<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台 磁盘管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Disk extends Controller_Admin_Base {


    /**
     * 控制器方法执行前
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '磁盘列表管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/disk/list',
                    'text' => '磁盘列表',
                ),
            ),
            'current' => $this->request->action
        );
        if(!Auth::getInstance()->hasAllow(array('disk.access'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
    }

    /*
     * 首页
     */
    public function action_list()
    {
        $this->template->results = DB::select()->from('img_disks')->execute()->as_array();
        $id = (int) $this->getQuery('id');
        if ($id > 0) {
        $this->template->info = DB::select()->from('img_disks')->where('id', '=', $id)->execute()->current();
        }

    }

    /*
     * 添加
     */
    public function action_add()
    {
        if(!Auth::getInstance()->hasAllow(array('disk.add'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $disk = ORM::factory('img_disk');
        if($this->isPost()){
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('disk_domain', 'not_empty')
                ->rule('disk_name', 'not_empty')
                ->rule('server_ip', 'not_empty')
                ->rule('disk_capa', 'not_empty');
            // 验证
            if ($post->check()) {
                $disk->values($post);
                $disk->memo = trim($this->getPost('memo'));
                $disk->save();
                $this->request->redirect('/admin/disk/list');
            }

            // 校验失败，获得错误提示
            $str = '';
            $this->template->registerErr = $errors = $post->errors('');
                foreach($errors as $item) {
                    $str .= $item  . '<br>';
                }
            $this->show_message($str);
        }
        $this->auto_render = false;
    }

    /*
     * 编辑
     */
    public function action_edit()
    {
        if(!Auth::getInstance()->hasAllow(array('disk.set'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $disk = ORM::factory('img_disk');
        if($this->isPost()){
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('disk_domain', 'not_empty')
                ->rule('disk_name', 'not_empty')
                ->rule('server_ip', 'not_empty')
                ->rule('disk_capa', 'not_empty');


            // 验证
            if ($post->check()) {
                $set = array (
                    'disk_domain' => trim($this->getPost('disk_domain')),
                    'disk_name' => trim($this->getPost('disk_name')),
                    'server_ip' => trim($this->getPost('server_ip')),
                    'disk_capa' => trim($this->getPost('disk_capa')),
                    'memo'      => trim($this->getPost('memo')),

                );
                DB::update('img_disks')->set($set)->where('id', '=', (int)$this->getPost('id'))->execute();
                $this->request->redirect('/admin/disk/list');
            }
            $errors = $post->errors('');

            $this->show_message($errors);
        }
        $this->auto_render = false;
    }

    /**
     * 删除
     */
    public function action_del()
    {
        if(!Auth::getInstance()->hasAllow(array('disk.delete'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $id = (int) $this->getQuery('id');
        DB::delete('img_disks')->where('id', '=', $id)->execute();
        $this->request->redirect('/admin/disk/list');

        $this->auto_render = false;
    }

    /**
     * 激活磁盘
     */
    public function action_active()
    {
        if(!Auth::getInstance()->hasAllow(array('disk.set'))){
          $this->show_message("对不起，您没有权限执行该操作");
        }
        $id =  (int) $this->getQuery('id');
        if ($id > 0) {
            DB::update('img_disks')->set(array('is_use' => '0'))->execute();
            DB::update('img_disks')->set(array('is_use' => '1'))->where('id', '=', $id)->execute();
        }
        $this->request->redirect('/admin/disk/list');
    }

}
