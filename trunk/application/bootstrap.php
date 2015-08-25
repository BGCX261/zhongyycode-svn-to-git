<?php
/**
 * 项目入口引导文件
 *
 * @package    script
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://hi.baidu.com/121981379)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

/* 强制性设定编码 */
@header("Content-type: text/html;charset=utf-8");
@session_cache_limiter('private, must-revalidate');
/*开启错误调试*/
error_reporting(E_ALL|E_STRICT);

//设定时区
date_default_timezone_set('Asia/Shanghai');

/**
 * 设定项目开始时间
 */
define('START_TIME', microtime(true));
define('REGULUS_CHARSET',  'utf-8');    //定义编码

define('DIR_SEP',  DIRECTORY_SEPARATOR);
define('PATH_SEP', PATH_SEPARATOR);

/*定义项目目录结构*/
define("WEB_DIR",  dirname(__FILE__));
define('APP_DIR',  dirname(WEB_DIR) . '/application' . DIR_SEP);
define('WWW_DIR',  dirname(WEB_DIR) . '/public' . DIR_SEP);
define('LIB_DIR',   dirname(WEB_DIR) . '/library' . DIR_SEP);
define('MODULES_DIR',   APP_DIR . 'modules' . DIR_SEP);
define('ETC_DIR',  APP_DIR . '/config' . DIR_SEP);

/* 关闭 magic_quotes_runtime */
set_magic_quotes_runtime(0);

/* 修正配置文件不显示错误信息的设定 */
!ini_get('display_errors') && ini_set('display_errors', 1);

/* 开启 short_open_tag */
!ini_get('short_open_tag') && ini_set('short_open_tag', 1);

require(LIB_DIR . DIR_SEP . 'YUN' . DIR_SEP . 'Core.php'); // 核心类
require(LIB_DIR . DIR_SEP . 'YUN' . DIR_SEP . 'Function.php'); // 公用函数

//关闭修正符转义
$_var =   (boolean) get_magic_quotes_gpc();
$value = '0';
$value = (boolean) $value;
$tmp = array($_POST, $_GET, $_COOKIE, $_REQUEST);
if ($_var != $value) {
    $tmp = $value ? addslashes_deep($tmp) : stripslashes_deep($tmp);
    $_var = $value;
    list($_POST, $_GET, $_COOKIE, $_REQUEST) = $tmp;
}
/**
 * 設置類的查找路徑
 */
YUN_Core::setIncludePath(strip(LIB_DIR));

//Regulus_Core的單例模式實現
$regulusCore = YUN_Core::getInstance();

/**
 * 设定异常处理控制器 错误处理控制器
 */
set_exception_handler(array($regulusCore, 'exceptionHandler'));
set_error_handler(array($regulusCore, 'errorHandler'));

/**
 * 加载配置文件
 */
$config = YUN_Core::loadConfig('config');
Zend_Registry::set('config', $config);
$route  = YUN_Core::loadConfig('route');

/**
 * Zend_Controller_Front 初始化
 */
$controller = Zend_Controller_Front::getInstance();
foreach ($config->hosts as  $key => $value) {
    $arr[$key] = $value;
}
$controller->setControllerDirectory($arr);// 添加模塊
$controller->setDefaultModule('default');
$controller->throwExceptions(true); // 設置錯誤機制
$controller->setParam('noViewRenderer', true); // 不使用默認的視圖
$controller->setParam('noErrorHandler', false);
Zend_Registry::set('controller', $controller);

/**
 * 設置連接資料庫
 */
$db = Zend_Db::factory($config->db->adapter, $config->db->toArray());
$db->query('SET NAMES ' . $config['db']->charset);
Zend_Db_Table::setDefaultAdapter($db);
Zend_Registry::set('db', $db);
unset($db);

/**
 *  配置缓存
 */
$cache = Zend_Cache::factory(
    $config->cache->frontendName,
    $config->cache->adapter,
    $config->cache->frontend_config->toArray(),
    $config->cache->config->toArray()
);
Zend_Registry::set('cache', $cache);
unset($cache);

/**
 * 加载ACL
 */
$acls = new YUN_Acl();
$acl = $acls->setAcl();
Zend_Registry::set('acl', $acl);

/**
 * 配置路由
 */
$router = $controller->getRouter();
foreach ($route as $item) {
    foreach ($route as $item) {
        $regex = new Zend_Controller_Router_Route_Regex(
            $item->route,
            $item->hosts,
            $item->reqs
        );
        $router->addRoute($item->key, $regex);
    }
}
unset($router, $route);


//开始运行程序
//try{
    $controller->dispatch();
//} catch (Exception $e) {
    //echo '你访问的页面不存在 </br>';
    //echo '<a href="/">返回首页</a>';
//}
