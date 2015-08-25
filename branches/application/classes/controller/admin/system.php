<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台系统配置
 *
 * @package    controller
 * @author     fred
 * @copyright  Copyright (c) 2010-11-03
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_System extends Controller_Admin_Base {

    /*
     * 首页
     */
    public function action_index()
    {
        $select = DB::select()->from('imgup_config')->order_by('id','DESC')->limit('1')->execute()->current();
        $this->template->rows = $select;

        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('allowed_ext', 'not_empty')
                ->rule('admin_email', 'not_empty')
                ->rule('max_upload', 'not_empty')
                ->rule('max_upload','numeric')
                ->rule('unit', 'not_empty')
                ;

            if ($post->check())
            {
                    $id = (int) $this->getPost('id');
                    $max_B = $this->getPost('max_upload').':'.$this->getPost('unit');

                    $set = array(
                        'allowed_ext' => trim($this->getPost('allowed_ext')),
                        'admin_email' => $this->getPost('admin_email'),
                        'max_upload' => $max_B,
                        'tmp_message_top' => trim($this->getPost('tmp_message_top')),
                        'marquee_message' => trim($this->getPost('marquee_message')),
                        'show_top' => (int) $this->getPost('show_top'),
                    );

                    if ($id>0) {
                        DB::update('imgup_config')->set($set)->where('id','=',$id)->execute();
                        Cache::instance()->delete('sys_configs');
                        @unlink(DOCROOT . 'cache/index.html');
                        @shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/index.html');
                        $links[] = array(
                                    'text' => '返回列表',
                                    'href' => '/admin/system',
                                );
                        $this->show_message('修改资料成功', 1, $links, true);
                    }
            }else{
              // 校验失败，获得错误提示
                    $str = '';
                    $this->template->registerErr = $errors = $post->errors('admin/module');
                        foreach($errors as $item) {
                            $str .= $item  . '<br>';
                                }
                    $this->show_message($str);
                }
        }

    }


}