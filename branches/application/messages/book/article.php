<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 用户图书中文错误提示
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(

    'title' => array(
        'not_empty' => '标题不能为空',

    ),
    'imgcode' => array(
        'not_empty' => '验证码不能为空',
        'Captcha::valid' => '验证码不正确'
    ),
    'cate_id'=> array(
        'not_empty' => '分类不能为空',
    ),
    'content' => array(
        'not_empty' => '内容不能为空',
    ),
    'phone' => array(
        'not_empty' => '手机号码不能为空'
    ),

    'email' => array(
        'email' => '必须是有效的邮箱地址'
    )


);

?>