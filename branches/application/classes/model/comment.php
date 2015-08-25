<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 评论应用表
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-5
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_comment extends ORM{

    /**
     * 设置主健
     *
     */
    public $_primary_key = 'cid';

    /**
     * 自动格式化时间
     */
    protected $_created_column = array('column' => 'post_time', 'format' => TRUE);
}