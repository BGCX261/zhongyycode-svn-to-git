<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 控制器基础类
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-14
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class Controller_Base extends Controller {

    /**
     * 用户信息
     */
    public $auth = '';
    public $auth_field = '';
    public $thumb  = null;
    /**
     * 是否输出视图
     *
     * @var bool
     */
    public $auto_render = TRUE;

    /**
     * 预置模板对象
     *
     * @var object
     */
    public $template = null;

    /**
     * 默认模板目录
     *
     * @var string
     */
    public $template_dir = 'default';

    public $img_size = array(
        '_640_640.', '_130_130.', '_120_120.'
    );
    /**
     * 控制器方法执行前的操作
     *
     */
    public function before()
    {
        parent::before();

        if (!($this->dir = $this->request->directory)) {
            $this->dir = 'default';

        } else {
            $this->dir = $this->request->directory;
            $this->template_dir = $this->request->directory;
        }

        if (!($this->ctrl = $this->request->controller)) {
            $this->ctrl = 'index';
        }
        if (!($this->act = $this->request->action)) {
            $this->act = 'index';
        }

        /* 初始化模板对象 */
        $this->template = new View();
        $this->template->script = '';
        $this->template->css = '';
        $this->template->directory = $this->dir;
        $this->template->controller = $this->ctrl;
        $this->template->action = $this->act;
        //缩略图
        $this->template->thumb = $this->thumb = Thumb::getInstance();

        /* 判断是否已登录 */
        $this->template->auth = $this->auth = Session::instance()->get('user', false);
        $this->template->auth_field = $this->auth_field = isset($this->auth['field']) ? $this->auth['field'] : array();

        $sys_configs = Cache::instance()->get('sys_configs');
        if (null == $sys_configs) {
            $sys_configs = ORM::factory('user')->setConfig();
        }
        $this->template->configs = $this->configs = $sys_configs;


        /* xss过滤 */
        if(!empty($_POST))$_POST = Security::xss_clean($_POST);
        if(!empty($_GET))$_GET = Security::xss_clean($_GET);

    }


    /**
     * 控制器方法执行后的操作
     *
     */
    public function after()
    {
        if ($this->auto_render) {
             $tplfile = strtolower($this->template_dir.'/'.str_replace('_','/',$this->ctrl).'/'.str_replace('_','/',$this->act));
            try {
                $this->template->set_filename($tplfile);
            }
            catch(Exception $e) {

                die("Template file '$tplfile' is not exist!");
            }
             $this->request->response = $this->template;

            // 生成首页html
            if( $this->dir == 'default' and $this->ctrl=='index' and $this->act=='index')
                $this->make_html($this->request->response,'index.html', '86400', 'cache');
            // 生成公共社区html
            if( $this->dir == 'default' and $this->ctrl=='pic' and $this->act=='index')
                $this->make_html($this->request->response,'pic.html', '86400', 'cache');

            // 生成公共社区html
            if( $this->dir == 'book' and $this->ctrl=='index' and $this->act=='index')
                $this->make_html($this->request->response,'book.html', '86400', 'cache');
            /* 是否开启调试环境 */
            if(defined('IN_PRODUCTION') and IN_PRODUCTION === false)
            $this->request->response .= '<div id="kohana-profiler">'.View::factory('profiler/stats').'</div>';
        }

        parent::after();
    }

    /**
     * 生成静态文件
     *
     * @param  string  $content
     * @param  string  $file_name
     * @param  int     $life_time 默认24小时
     * @param  string  $path
     */
    public function make_html($content,$file_name,$life_time= 86400 ,$path = 'cache/html')
    {

        if(empty($content) or empty($file_name))return;
        $dir = DOCROOT . $path;
         $file_name = $dir. DIRECTORY_SEPARATOR.$file_name;

        if(file_exists($file_name) and (filemtime($file_name) + $life_time>time()))return;

        if(!is_dir($dir))
        {
            mkdir($dir,0777,true);
        }
        @file_put_contents($file_name,$content);
    }

    /**
     * 添加js脚本
     *
     */
    public function _add_script()
    {
        $args = func_get_args();
        foreach($args as $v)
        {
            //$v .= '?'.time();
            $this->template->script .= html::script($v)."\n";
        }
    }

    /**
     * 添加css样式表
     *
     */
    public function _add_css()
    {
        $args = func_get_args();
        foreach($args as $v)
        {
            $this->template->css .= html::style($v)."\n";
        }
    }

    /**
     * 获取 Query String 数据
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function getQuery($key = null, $default = null) {
        if (null == $key)
            return $_GET;
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    /**
     * 获取 Http Post 数据
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function getPost($key = null, $default = null) {
        if (null == $key)
            return $_POST;
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    /**
     * 获取 Http Request 数据
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function getRequest($key = null, $default = null) {
        if (null == $key)
            return $_REQUEST;
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    /**
     * 获取 Files Upload 数据
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function getFiles($key = null, $default = null) {
        if (null == $key)
            return $_FILES;
        return isset($_FILES[$key]) ? $_FILES[$key] : $default;
    }

    /**
     * 获取 Http Server 数据
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function getServer($key = null, $default = null) {
        if (null == $key)
            return $_SERVER;
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    /**
     * 获取 Http Request 使用的传递方法
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * 判断是否 Post 方式
     *
     * @return boolean
     */
    public function isPost()
    {
        return 'POST' == $this->getMethod();
    }
    /**
     * 公共报错页面
     *
     * @param  string  $msg_detail
     * @param  string  $msg_type 默认0，成功1，失败-1
     * @param  array   $links
     * @param  bool    $auto_redirect
     */
    public function show_message($msg_detail, $msg_type = 0, $links = array(), $auto_redirect = true, $time = 3000)
    {
        $str = '';
        if (!is_array($msg_detail)) {
            $msg_detail = array($msg_detail);
        }

        $msg_detail = implode(',&nbsp;', $msg_detail);
        if (count($links) == 0)
        {
            $links[0]['text'] = "上一页";
            $links[0]['href'] = 'javascript:history.go(-1)';
        }
        $links[] = array(
                'text' => '返回网站首页',
                'href' => '/',
        );
        $this->template->msg_detail = $msg_detail;
        $this->template->msg_type = $msg_type;
        $this->template->links = $links;
        $this->template->time = $time;
        $this->template->default_text = $links[0]['text'];
        $this->template->default_url = $links[0]['href'];
        $this->template->auto_redirect = $auto_redirect;
        $this->template->set_filename($this->template_dir.'/message');
        exit($this->template->render());
    }

    /*
    * 验证空间过期,容量
    */
   public function checkSpace()
   {
        $user = ORM::factory('user');
        $user->upcache($this->auth['uid']);
        if ($user->check_expire($this->auth['uid'])) {

            if($this->auth['rank'] == 1) {
                $links[] = array('text' => '去完成积分任务','href' => '/job');
            } else  {
               $links[] = array('text' => '去付费中心','href' => '/pay/upgrade');
            }
            $this->show_message('您的帐号已过期或空间不足，请续费或完成积分任务,再进行操作', 0, $links);
            die();
        }
        if ($user->check_space($this->auth['uid'])) {
            $links[] = array('text' => '去付费中心','href' => '/pay/upgrade');
            $this->show_message('您的帐号已过期或空间不足，请续费或完成积分任务,再进行操作', 0, $links);
            die();
        }
   }

    /**
     *  检查登录
     */
    public function checklogin()
    {
        if(!$this->auth){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
        }
    }



}