<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 默认页
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-15
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Index extends Controller_Base {

    /**
     * 首页
     */
    public function action_index()
    {
        $this->template->pageTitle = '免费淘宝相册';

        // 明星用户
        $this->template->topUser = DB::select()->from('users')
            ->where('index_top', '=', 1)
            ->order_by('uid', 'DESC')
            ->limit(12)
            ->execute()
            ->as_array();


    }

    /**
     * 图形验证码
     */
    public function action_imgcode()
    {
        echo $captcha = Captcha::instance();
        $this->auto_render = false;
    }
}