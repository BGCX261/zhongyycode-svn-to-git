<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 模块权限规则中文错误提示
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(
     'res_name' => array(
        'not_empty' => '资源名称不允许为空',
        'regex' => '资源名称包含除 [A-Za-z0-9_] 之外的非法字符',
        'min_length' => '资源名称必须介于 2~20 个字符之间',
        'max_length' => '资源名称必须介于 2~20 个字符之间',
    ),

    'res_desc' => array(
        'not_empty' => '资源说明不允许为空',
        'min_length' => '资源说明必须介于 2~20 个字符之间',
        'max_length' => '资源说明必须介于 2~20 个字符之间',
    ),

);

?>