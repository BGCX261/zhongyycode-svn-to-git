<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 标签model
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-7
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Tag extends ORM
{
    /**
     * 自动格式化时间
     */
    protected $_created_column = array('column' => 'uploadtime', 'format' => TRUE);

    /**
     * ORM一对一关系
     *
     */
    protected $_has_one = array(
        'category' => array('model' => 'img_category', 'foreign_key' => 'cate_id'),

    );
}
?>