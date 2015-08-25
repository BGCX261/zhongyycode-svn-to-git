<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 用户注册中文错误提示
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(
    'username' => array(
        'not_empty' => '用户名不能为空',
        'login_wrong' => '用户名或密码错误',
        'min_length' => '用户名不能少于2个字符',
        'max_length' => '用户名不能大于15个字符',
        'regex' => '不允许特别符号作为用户名'
    ),
    'password' => array(
        'not_empty' => '密码不能为空',
        'min_length' => '用户密码不能少于6个字符',
        'max_length' => '用户密码不能大于20个字符',
    ),
    'imgcode' => array(
        'not_empty' => '验证码不能为空',
        'Captcha::valid' => '验证码不正确'
    ),
    'csrf'=> array(
        'not_empty' => '表单安全码不能为空',
        'Security::check' => '表单安全码不正确'
    ),
    'city_id' => array(
        'not_empty' => '所在城市不能为空',
    ),
    'phone' => array(
        'not_empty' => '手机号码不能为空'
    ),
    'captcha' => array(
        'not_empty' => '验证码不能为空',
        'Captcha::valid'=>'您填写的验证码不正确'
    ),
    'email' => array(
        'email' => '必须是有效的邮箱地址'
    )


);

?>