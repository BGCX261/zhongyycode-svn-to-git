<?php
/**
 * 路由配置文件
 *
 * @package    config
 * @author     轩辕云 <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.imeelee.com)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

return array(
    array(
        'key' => 'category',
        'route' => 'category/(\d+).html',
        'hosts' => array(
            'controller' => 'index',
            'action'     => 'cate',
            'cate_id'   =>  '1',
            'page'   =>  '2',
            'module'    =>'default'
        ),
        'reqs' => array(
            1 => 'cate_id',
            2 => 'page'
        )
    ),
    array(
        'key' => 'article',
        'route' => 'article/(\d+).html',
        'hosts' => array(
            'controller' => 'index',
            'action'     => 'detail',
            'art_id'   =>  '1',
            'module'    =>'default'
        ),
        'reqs' =>array(
            1 => 'art_id',
        )
    ),
);