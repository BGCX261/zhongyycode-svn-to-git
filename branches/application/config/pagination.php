<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 分页配置文件
 * @package    config
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-15
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
return array(

    // Application defaults
    'default' => array(
        'current_page'   => array('source' => 'query_string', 'key' => 'page'), // source: "query_string" or "route"
        'total_items'    => 0,
        'items_per_page' => 30,
        'view'           => 'pagination/digg',
        'auto_hide'      => TRUE,
    ),

);
