<?php
/**
 * 项目配置文件
 *
 * @package    config
 * @author     轩辕云 <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.imeelee.com)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

!defined('ETC_DIR') && die('Access Deny!');
return array(
    'db' => array(
        'adapter'  => 'PDO_MYSQL',      //数据库主机地址及端口
        'host'     => 'localhost',      //数据库主机地址及端口
        'dbname'   => 'yunphp',         //数据库名称
        'username' => 'root',       //用户名
        'password' => '',           //密码
        'charset'  => 'utf8',        //数据库字符集
        'prefix'   => '',     //数据库表名前缀
    ),
    'hosts' => array( //主机名配置
        'default' => MODULES_DIR .'default/controllers',
        //'default.yunphp.com' => 'default',
        'admin' => MODULES_DIR .'admin/controllers',
        'shop' => MODULES_DIR .'shop/controllers',
    ),
    'mail' =>array(
        'host' => 'smtp.qq.com',
        'config' => array(
            'auth' => 'login',
            'username' => '121981379@qq.com',
            'password' => '121981379',
        ),
    ),
    'upload' => array(
        'savePath' => WWW_DIR . '/uploads', //上传基本目录
        'maxSize' => 0, //KB
        'allowExtension' => array( //允许上传的文件格式
            'JPG', 'jpeg', 'bmp', 'wbmp', 'gif', 'png',
            'rar', 'zip', 'gz', '7z', 'bzip', 'iso',
            'txt'
        ),
        'rename' => true, //是否重命名
    ),
    'captcha' => array(
        'driver' => 'basic',
        'options' => array(
            'length' => mt_rand(4, 6), //字符长度
            'width' => 120, //图片宽度
            'height' => 40, //图片高度
            'fontDir' => ETC_DIR . '/fonts', //字体目录
            'fonts' => array(), //可随机应用的字体 (空则使用所有)
            'imgDir' => WWW_DIR . 'images/captcha',
            'imgUrl' => '/images/captcha',
            'imgAlt' => '',
        )
    ),
    'cache' => array(
        'frontendName' => 'Core',
        'frontend_config' => array(
            'lifeTime' => 259200, //缓存生存周期(秒)
            'automatic_serialization' => true, //缓存生存周期(秒)
        ),

        'adapter' => 'file', //为便于开发时进行调试，暂时使用FILE做为缓存
        'config' => array (
           'cache_dir' => Yun_Io::strip(APP_DIR .'/cache'), //缓存文件保存目录
           'file_name_prefix' => 'z', // 缓存前缀
        ),

//        'adapter' => 'memcached', //缓存适配器
//        'config' => array (
//            'compression' => 'false', //是否启用压缩
//            'servers' => array (
//                'host' => '127.0.0.1', //Memcached 服务器
//                'port' => '11211', //Memcached 通信端口
//                'persistent' => '1',//是否使用持久连接
//            ),
//        ),
    )

);