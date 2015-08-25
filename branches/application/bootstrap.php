<?php defined('SYSPATH') or die('No direct script access.');

/* 读取首页缓存*/
if(IN_PRODUCTION===true and $_SERVER['REQUEST_URI']=='/'
    and file_exists(DOCROOT.'cache/index.html') and filemtime(DOCROOT.'cache/index.html') + 86400 > time()) {
    include(DOCROOT.'cache/index.html');
    die();
}

/* 读取公共社区缓存*/
if(IN_PRODUCTION===true and $_SERVER['REQUEST_URI']=='/pic'
    and file_exists(DOCROOT.'cache/pic.html') and filemtime(DOCROOT.'cache/pic.html')+86400>time())
{
    include(DOCROOT.'cache/pic.html');
    die();
}

/* 读取图书馆缓存*/
if(IN_PRODUCTION===true and $_SERVER['REQUEST_URI']=='/book'
    and file_exists(DOCROOT.'cache/book.html') and filemtime(DOCROOT.'cache/pic.html')+86400>time())
{
    include(DOCROOT.'cache/book.html');
    die();
}
//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Asia/Shanghai');
/**
 * 设定项目开始时间
 */
define('START_TIME', microtime(true));

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
    'base_url'   => '/',
    'index_file' => '',
    'profile'    => TRUE,


));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
     //'auth'       => MODPATH.'auth',       // Basic authentication
     'cache'      => MODPATH.'cache',      // Caching with multiple backends
    // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool

     'my'           => MODPATH.'my',   // Database access
    'database'   => MODPATH.'database',   // Database access
    // 'image'      => MODPATH.'image',      // Image manipulation
     'orm'        => MODPATH.'orm',        // Object Relationship Mapping
    // 'oauth'      => MODPATH.'oauth',      // OAuth authentication
     'pagination' => MODPATH.'pagination', // Paging of results
     'captcha'    => MODPATH.'captcha',    // captcha of results
    // 'unittest'   => MODPATH.'unittest',   // Unit testing
    // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
    ));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))<url_suffix>',array('url_suffix'=>'(\.html)?'))
    ->defaults(array(
        'directory'  => 'admin',
        'controller' => 'index',
        'action'     => 'index',
    ));
Route::set('book', 'book(/<controller>(/<action>(/<id>)))<url_suffix>',array('url_suffix'=>'(\.html)?'))
    ->defaults(array(
        'directory'  => 'book',
        'controller' => 'index',
        'action'     => 'index',
    ));

/*
 * 用户图书中心
 */
Route::set('book_username', 'books/<username>', array('username' => '.*',))
  ->defaults(array(
    'directory'  => 'book',
    'controller' => 'user',
    'action' => 'index',
  ));
/*
 * 图书页面
 */
Route::set('article_view', 'articles/<aid>.html',  array('aid' => '\d+'))
  ->defaults(array(
    'directory'  => 'book',
    'controller' => 'article',
    'action' => 'reading',
  ));

/*
 * 图片查看静态页面
 */
Route::set('img_static', '<id>.html', array('id' => '\d+'))
  ->defaults(array(
    'controller' => 'pic',
    'action' => 'view',
  ));
/*
 * 图片专题查看静态页面
 */
Route::set('picsubject', 'picsubject/<sid>.html', array('sid' => '\d+'))
  ->defaults(array(
    'controller' => 'picsubject',
    'action' => 'view',
  ));

/*
 * 用户共享静态页面
 */
Route::set('username_static', 'u/<username>', array('username' => '.*',))
  ->defaults(array(
    'controller' => 'pic',
    'action' => 'person',
  ));
Route::set('default', '(<controller>(/<action>(/<id>(/<param1>))))<url_suffix>',array('url_suffix'=>'(\.html)?'))
    ->defaults(array(
        'controller' => 'index',
        'action'     => 'index',
    ));




// 选择语言
I18n::$lang = 'zh-cn';
if ( ! defined('SUPPRESS_REQUEST'))
{
    /**
     * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
     * If no source is specified, the URI will be automatically detected.
     */
   try{
        echo Request::instance()
            ->execute()
            ->send_headers()
            ->response;
   } catch(Exception $e) {
       @ob_clean();
        //@header("HTTP/1.0 404 Not Found");
        @header("Content-type: text/html; charset=utf-8");
        echo <<<EOF
<title>HTTP/1.0 404 Not Found</title>
<h2>HTTP/1.0 404 Not Found</h2>
<p>非常抱歉，请求的页面不存在。<p>
<p>请访问<a href="http://www.wal8.com">http://www.wal8.com</a></p>
EOF;
   }

}
