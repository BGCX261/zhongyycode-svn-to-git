<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 用户图片中文错误提示
 * @package    array
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(
    'pid' => array(
        'not_empty' => '应用id不能为空',
    ),
    'title' => array(
        'not_empty' => '标题不能为空',
    ),
    'content' => array(
        'not_empty' => '内容不能为空',
    ),
    'captcha' => array(
        'not_empty' => '验证码不能为空',
        'Captcha::valid'=>'您填写的验证码不正确'
    ),
);

?>