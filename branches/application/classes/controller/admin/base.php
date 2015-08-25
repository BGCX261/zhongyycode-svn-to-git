<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 管理后台框架
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-14
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class Controller_Admin_Base extends Controller_Base {


    /**
     * 控制器方法执行前的操作
     *
     */
    public function before()
    {
        parent::before();
        Session::instance()->delete('acl_all_default_roles');
        Session::instance()->delete('acl_all_guest_roles');
        if(!$this->auth || !Auth::getInstance()->isAllow('index.access@admin')){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
            );
            $this->show_message('你尚未登录或者你没权限登录后台管理。。。', 0, $links);
        }



    }
}