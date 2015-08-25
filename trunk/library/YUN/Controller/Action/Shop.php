<?php
/**
 * YUN_Controller_Action_Admin
 *
 * @package    class       繼承Zend_Controller_Action 適應設置不同的 module
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.hi.hi.baidu.com/121981379)
 */
!defined('LIB_DIR') && die('Access Deny!');

abstract class YUN_Controller_Action_Shop extends YUN_Controller_Action
{
    public $config = array();

    /**
     * 重載 繼承的 YUN_Controller_Action init 方法
     */
    public function init() {

        parent::init();
        $this->config = Zend_Registry::get('config');
    }
}
