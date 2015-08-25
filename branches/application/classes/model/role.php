<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 权限控制
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-5
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Role extends ORM
{
	protected $_has_many = array('adminusers'=>array());

	/**
	 * 数据验证过滤器定义
	 *
	 * @var array
	 */

	protected $_filters = array
	(
	    TRUE => array('trim' => array()),
	);

	/**
	 * 数据验证规则定义
	 *
	 * @var array
	 */

	protected $_rules = array
	(
	    'role_name' => array('not_empty' => array(),'max_length' => array('20')),
		'role_describe' => array('not_empty' => array()),
	);
}
?>