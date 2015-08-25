<?php
/**
 * 基础类
 *
 * @package    classes
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

abstract class YUN_Abstract
{
    /**
     * db object
     *
     */
    public  $db = null;
    public  $config = null;
    public  $cache ;
    /**
     * construct
     *
     */
    public function __construct()
    {
        $this->db = Zend_Registry::get('db');
        $this->config = Zend_Registry::get('config');

        $this->cache = Zend_Registry::get('cache');
    }

}