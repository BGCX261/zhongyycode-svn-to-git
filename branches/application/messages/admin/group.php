<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 会员管理组中文错误提示
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array
(
    'group_name' => array(
        'not_empty' => '组名称不允许为空',
    ),

    'max_space' => array(
        'not_empty' => '空间不允许为空',
    ),
    'fee_year' => array(
        'not_empty' => '年费用不允许为空',
    ),
    'fee_month' => array(
        'not_empty' => '月费用不允许为空',
    ),
    'dir_limit' => array(
        'not_empty' => '目录限制大小不允许为空',
    ),
    'max_limit' => array(
        'not_empty' => '单文件限制大小不允许为空',
    ),

);

?>