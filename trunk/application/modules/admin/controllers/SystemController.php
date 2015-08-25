<?php
/**
 * 系统管理
 *
 * @package    controller       system manage
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class SystemController extends YUN_Controller_Action_Admin
{
    public function init(){
        $this->registry = Zend_Registry::getInstance();
        $this->view = $this->registry['view'];
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->setScriptPath(MODULES_DIR.'admin/Views/system/');  //放显示的文件的地方

    }
    public function indexAction(){

       echo $this->view->bodyTitle = '<h1>Hello World!</h1>';
      $this->isload = false;

    }
    public function  menulistAction() {
    }
    public function noRouteAction() {//这个在每个IndexController都要记得加上去。才不会出现错误！

        $this->_redirect('../');//转到首页
    }
    public function settingAction(){
    echo 'hello';
    }

}
?>