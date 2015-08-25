<?php
/**
 * Regulus_Controller_Action
 *
 * @package    class       繼承Zend_Controller_Action 適應設置不同的 module
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.hi.hi.baidu.com/121981379)
 */
!defined('LIB_DIR') && die('Access Deny!');

abstract class YUN_Controller_Action extends Zend_Controller_Action
{
    /**
     * Zend_Db
     */
    public $db = null;

    /**
     * 视图
     */
    public $view = '';

    /**
     * YUN_Auth object
     */
    public $auth = null;

    /**
     * 是否加载view
     */
    public $isload = true;

    /**
     * Zend_Acl
     */
    public $acl = null;

    public $module = null;

//    public function    __call($method, $args){
//        if ('Action' == substr($method,    -6)) {
//            $controller    = $this->getRequest()->getControllerName();
//            $url = '/' . $controller . '/index';
//            return $this->_redirect($url);
//        }
//        throw new Exception('不存在该 ' .$method);
//    }

    /**
     * 重載 繼承的 Zend_Controller_Action init 方法
     */
    public function init() {
        parent::init();
        $this->_viewSuffix = 'php';
        $this->viewSuffix = $this->_viewSuffix;
        $this->db = Zend_Registry::get('db');

        // 取得運行時的module
        $this->module = parent::getFrontController()->getRequest()->getParams();
        $this->registry = Zend_Registry::getInstance();

        $this->view = new Zend_View();
        //$this->view->setScriptPath(MODULES_DIR . $module['module'] .'/Views/'); // 设置默认的视图层
        $this->view->setHelperPath(APP_DIR . 'Helper', 'Helper'); //设置helper路径
        //设置每个controler的view路径
        $view = $this->view->setScriptPath(MODULES_DIR . $this->module['module']. '/Views' . '/' . $this->module['controller']);

        //增加公共view层路径 (如 header.php)
        $this->view->addScriptPath(MODULES_DIR . $this->module['module'] . '/Views/');

        //設置modules(同controller目录同级别)的查找路徑
        YUN_Core::setIncludePath(MODULES_DIR . $this->module['module']. '/modules');

        // 用户资料
        $this->auth = YUN_Auth::getInstance();
        $this->view->auths = $this->auths = $this->auth->getIdentity();
    }

    /**
     * 自动加载VIEW页面
     *
     * @param string $action Method name of action
     * @return void
     */
    public function dispatch($action)
    {
        parent::dispatch($action);
        $path  = MODULES_DIR . $this->module['module']. '/Views' . '/' . $this->module['controller'];
        $action =str_replace('Action', '', $action);
        $path = YUN_Io::strip($path . '/'. $action . '.php');
        if($this->isload){
            if (is_file($path) && is_readable($path)){
                $this->render($action);
            } else {
                throw new Zend_Exception("文件 $path 不存在或者无法加载");
            }
        }
    }
}
