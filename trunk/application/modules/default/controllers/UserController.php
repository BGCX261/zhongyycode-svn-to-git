<?php
/**
 * 用户控制器
 *
 * @package    Controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('APP_DIR') && die('Access Deny!');

class UserController extends YUN_Controller_Action
{
    public $config = null;

    /**
     * 初始化
     */
    public function init(){
        parent::init();
        $this->view->pageTitle = '人生若只初见';
        $this->config = Zend_Registry::get('config');

    }

    /**
     * 首页
     */
    public function indexAction(){
        $this->_redirect('/index');
    }

    /**
     * 登录
     */
    public function loginAction()
    {
        $url = $this->view->url = $this->_getParam('u'); //登录成功后的跳转地址
        if ($this->_request->isPost()) {
            try {
                /*
                $storage = new Zend_Session_NameSpace('CAPTCHA');
                if($this->_request->getPost('captcha') != $storage->phrase){
                    throw new Zend_Exception('验证码不正确，请重新输入');
                }
                */
                $data = array(
                    'username' => $this->_request->getPost('username'),
                    'password' => $this->_request->getPost('password'),
                    'lifetime' => $this->_request->getPost('lifetime'),
                );

                if ($this->auth->login($data)){
                    empty($url) && $url = 'http://www.yunphp.cn/';

                    $this->_redirect($url);
                }
            } catch (Exception $e) {
                $this->view->Feedback(array(
                    'title' => '发生错误',
                    'message' => $e->getMessage() ,
                    'redirect' => $this->view->url(
                        array('module' => 'default', 'controller' => 'user','action' => 'login')) . '?u=' .$url ,
                ));
            }
        }
    }

    /**
     * 退出
     */
    function logoutAction()
    {
        $this->auth->logout();
        $this->view->feedback(array(
            'title'    => '注册用户退出登录',
            'message'  => '您已经退出登录，点击返回首页',
            'redirect' => 'http://www.yunphp.cn/',
            'linktext' => '返回首页',
        ));
    }

    /**
     * 上传
     */
    public function uploadAction()
    {
        echo '<form enctype="multipart/form-data" action="" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            Choose a file to upload: <input name="uploadedfile" type="file" />
            <br />
            <input type="submit" value="Upload File" />
            </form>';
        if ($this->_request->isPost()) {
            $adapter = new Zend_File_Transfer_Adapter_Http();

            $uploadfile = '1111'  . $this->_request->getPost('uploadedfile');

            // Returns the mimetype for the 'foo' form element

            if (!$adapter->receive($uploadfile)) {
                $messages = $adapter->getMessages();
                echo implode("\n", $messages);
            }
        }
    }

    /**
     * 图形验证码
     */
    public function captchaAction()
    {
        $captcha = YUN_Captcha::factory(
            $this->config->captcha->driver,
            $this->config->captcha->options
        )
        ->generate();
        $this->isload = false;

    }

}