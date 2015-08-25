<?php
/**
 * admin/index
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_IndexController extends YUN_Controller_Action_Admin
{

    /**
     * 初始化
     */
    public function init(){
        parent::init();
    }

    /**
     * 首页
     */
    public function indexAction()
    {}

    /**
     * header部分
     */
    public function navigationAction()
    {
        $this->view->navigation = array();

        if ($this->auth->hasAllow(array(
                'ask_question.list','ask_question.view',
            ))) {
            $this->view->navigation[] = array(
                'text' => '问答管理',
                'class' => 'ask',
            );
        }
        if ($this->auth->hasAllow(array(
                'article.view',
            ))) {
            $this->view->navigation[] = array(
                'text' => '资讯管理',
                'class' => 'article',
            );
        }
        if ($this->auth->hasAllow(array(
                'user.list','stat.view'
            ))) {
            $this->view->navigation[] = array(
                'text' => '用户管理',
                'class' => 'user',
            );
        }

        if ($this->auth->hasAllow(array(
                'module.list',
                'cache.update', 'database.optimize',
                'dict.set'
            ))) {
            $this->view->navigation[] = array(
                'text' => '系统管理',
                'class' => 'system',
            );
        }
    }

    /**
     * menu
     */
    public function menuAction()
    {
        $this->view->menu = array();

        //问答管理
        if ($this->auth->isAllow('ask_question.list')) {
            $this->view->menu[] = array(
                'text' => '问答分类列表',
                'url' => array('module' => 'admin', 'controller' => 'category', 'action' => 'askList'),
                'class' => 'ask',
            );
            $this->view->menu[] = array(
                'text' => '问答列表',
                'url' => array('module' => 'admin', 'controller' => 'question', 'action' => 'list'),
                'class' => 'ask',
            );
            $this->view->menu[] = array(
                'text' => '标签管理',
                'url' => array('module' => 'admin', 'controller' => 'tags', 'action' => 'list'),
                'class' => 'ask',
            );
        }
        //资讯管理
        if ($this->auth->isAllow(array('article.view', 'article.access'))) {
            $this->view->menu[] = array(
                'text' => '网站栏目管理',
                'url' => array('module' => 'admin', 'controller' => 'category', 'action' => 'list'),
                'class' => 'article',
            );
            $this->view->menu[] = array(
                'text' => '所有档案列表',
                'url' => array('module' => 'admin', 'controller' => 'article', 'action' => 'list'),
                'class' => 'article',
            );
            $this->view->menu[] = array(
                'text' => '我发布的文档',
                'url' => array('module' => 'admin', 'controller' => 'article', 'action' => 'list', 'uid' => $this->auths->uid),
                'class' => 'article',
            );
            $this->view->menu[] = array(
                'text' => '评论管理',
                'url' => array('module' => 'admin', 'controller' => 'article', 'action' => 'comment'),
                'class' => 'article',
            );
            $this->view->menu[] = array(
                'text' => '文档关键词',
                'url' => array('module' => 'admin', 'controller' => 'article', 'action' => 'keywords'),
                'class' => 'article',
            );
            $this->view->menu[] = array(
                'text' => '文章标签管理',
                'url' => array('module' => 'admin', 'controller' => 'tags', 'action' => 'artList'),
                'class' => 'article',
            );

        }
        if ($this->auth->isAllow('file.list')) {
            $this->view->menu[] = array(
                'text' => '上传文件管理',
                'url' => array('module' => 'admin', 'controller' => 'file', 'action' => 'browser'),
                'class' => 'article',
            );
        }


        if ($this->auth->isAllow('user.list')) {
            $this->view->menu[] = array(
                'text' => '用户列表',
                'url' => array('module' => 'admin', 'controller' => 'user', 'action' => 'list'),
                'class' => 'user',
            );
        }


        if ($this->auth->isAllow('stat.view')) {
            $this->view->menu[] = array(
                'text' => '统计信息',
                'url' => array('module' => 'admin', 'controller' => 'stats', 'action' => 'user'),
                'class' => 'user',
            );
        }



        //系统管理
        if ($this->auth->isAllow('module.list')) {
            $this->view->menu[] = array(
                'text' => '模块与权限',
                'url' => array('module' => 'admin', 'controller' => 'module', 'action' => 'list'),
                'class' => 'system',
            );
        }
        if ($this->auth->isAllow('module.list')) {
            $this->view->menu[] = array(
                'text' => '系统设置',
                'url' => array('module' => 'admin', 'controller' => 'system', 'action' => 'set'),
                'class' => 'system',
            );
        }

        if ($this->auth->isAllow('v_currency.list')) {
            $this->view->menu[] = array(
                'text' => '虚拟货币管理',
                'url' => array('module' => 'admin', 'controller' => 'vcurrency', 'action' => 'list'),
                'class' => 'system',
            );
        }

        if ($this->auth->isAllow('mail.send')) {
            $this->view->menu[] = array(
                'text' => '系统通知',
                'url' => array('module' => 'admin', 'controller' => 'notice', 'action' => 'agent'),
                'class' => 'system',
            );
        }
        if ($this->auth->isAllow('cache.update')) {
            $this->view->menu[] = array(
                'text' => '缓存状况',
                'url' => array('module' => 'admin', 'controller' => 'cache', 'action' => 'index'),
                'class' => 'ask',
            );
        }
        if ($this->auth->isAllow('database.optimize')) {
            $this->view->menu[] = array(
                'text' => '数据库优化',
                'url' => array('module' => 'admin', 'controller' => 'system', 'action' => 'dbOptimize'),
                'class' => 'system',
            );
        }


        $this->view->menu[] = array(
            'text' => '友情链接管理',
            'url' => array('module' => 'admin', 'controller' => 'link', 'action' => 'list'),
            'class' => 'system',
        );


        if ($this->auth->isAllow('dict.set')) {
            $this->view->menu[] = array(
                'text' => '词库管理',
                'url' => array('module' => 'admin', 'controller' => 'dict', 'action' => 'words'),
                'class' => 'system',
            );
        }
    }

    /**
     * 底部
     */
    public function footerAction()
    {

    }
}
