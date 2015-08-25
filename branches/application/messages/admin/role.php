<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 模块权限角色中文错误提示
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-1
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(
     'role_name' => array(
        'not_empty'  => '角色名称不允许为空',
        'regex'      => '角色名称包含除 [A-Za-z0-9_] 之外的非法字符',
        'min_length' => '角色名称必须介于 2~20 个字符之间',
        'max_length' => '角色名称必须介于 2~20 个字符之间',
    ),
    'role_level' => array(
        'numeric'    => '角色等级的值必须是一个有效的整数',
    ),
    'role_desc' => array(
        'not_empty' => '角色说明不允许为空',
        'min_length' => '角色说明必须介于 2~80 个字符之间',
        'max_length' => '角色说明必须介于 2~80 个字符之间',
    ),

);

?>