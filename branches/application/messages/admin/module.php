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
     'new_mod_name' => array(
        'not_empty' => '模块名称不允许为空',
        'min_length' => '模块名称必须介于 2~20 个字符之间',
        'max_length' => '模块名称必须介于 2~20 个字符之间',
        'regex' => '模块名称必须为 2~20 英文字母+数字组成的字符'
    ),
    'mod_name' => array(
        'not_empty' => '模块名称不允许为空',
        'min_length' => '模块名称必须介于 2~20 个字符之间',
        'max_length' => '模块名称必须介于 2~20 个字符之间',
    ),
    'mod_desc' => array(
        'not_empty' => '模块说明不允许为空',
        'min_length' => '模块说明必须介于 2~20 个字符之间',
        'max_length' => '模块说明必须介于 2~20 个字符之间',
    ),
	'allowed_ext' => array(
        'not_empty' => '文件类型不允许为空',
        'min_length' => '模块说明必须介于 2~20 个字符之间',
        'max_length' => '模块说明必须介于 2~20 个字符之间',
    ),
	'admin_email' => array(
        'not_empty' => '网站邮箱不允许为空',
        'min_length' => '模块说明必须介于 2~20 个字符之间',
        'max_length' => '模块说明必须介于 2~20 个字符之间',
    ),	
	'max_upload' => array(
        'not_empty' => '单文件大小上限不允许为空',
        'min_length' => '模块说明必须介于 2~20 个字符之间',
        'max_length' => '模块说明必须介于 2~20 个字符之间',
        'numeric' => '仅允许输入数字',		
		
    ),	
	'unit' => array(
        'not_empty' => '请选择单位！',
        'min_length' => '模块说明必须介于 2~20 个字符之间',
        'max_length' => '模块说明必须介于 2~20 个字符之间',
    ),		
);

?>