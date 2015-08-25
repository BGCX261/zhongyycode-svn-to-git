<?php
/**
 * YUN_Controller_Action_Admin
 *
 * @package    class       繼承Zend_Controller_Action 適應設置不同的 module
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.hi.hi.baidu.com/121981379)
 */
!defined('LIB_DIR') && die('Access Deny!');

abstract class YUN_Controller_Action_Admin extends YUN_Controller_Action
{
    public $config = array();

    /**
     * 重載 繼承的 YUN_Controller_Action init 方法
     *
     */
    public function init() {
        parent::init();
        $http = new  Zend_Controller_Request_Http();
        if(!$this->auth->isAllow('index.access')) {
            if($this->auth->isLogined()){
                $this->view->feedback(array(
                    'message' => '对不起，您没有权限执行该操作！',
                    'redirect' => $this->view->url(array(
                        'module' => 'default',
                        'controller' => 'user',
                        'action' => 'login',
                    )) ,
                    'linktext' => '点击继续',
                ));

            } else {
                $this->view->Feedback(array(
                    'title' => '发生错误',
                    'message' => '对不起，您尚未登录' ,
                    'linktext' => '点击前往登录页面' ,
                    'redirect' => $this->view->url(
                        array('module' => 'default', 'controller' => 'user','action' => 'login'))
                        . '?u=' . urlencode('http://' . $http->getHttpHost() . $http->getRequestUri()) ,
                ));
            }
        }
        $this->config = Zend_Registry::get('config');
    }

    public function    __call($method, $args){
        if ('Action' == substr($method,    -6)) {
            $controller    = $this->getRequest()->getControllerName();
            $url = '/' . $controller . '/index';
            //return $this->_redirect($url);
        }
        throw new Exception('不存在该 ' .$method);
    }
}
