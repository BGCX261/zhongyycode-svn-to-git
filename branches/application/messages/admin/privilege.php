<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 模块权限中文错误提示
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(
     'new_priv_name' => array(
        'not_empty' => '权限名称不允许为空',
        'min_length' => '权限名称必须介于 2~20 个字符之间',
        'max_length' => '权限名称必须介于 2~20 个字符之间',
        'regex' => '权限名称必须为 2~20 英文字母+数字组成的字符'
    ),
    'priv_name' => array(
        'not_empty' => '权限名称不允许为空',
        'min_length' => '权限名称必须介于 2~20 个字符之间',
        'max_length' => '权限名称必须介于 2~20 个字符之间',
    ),
    'priv_desc' => array(
        'not_empty' => '权限说明不允许为空',
        'min_length' => '权限说明必须介于 2~20 个字符之间',
        'max_length' => '权限说明必须介于 2~20 个字符之间',
    ),

);

?>