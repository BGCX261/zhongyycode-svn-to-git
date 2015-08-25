<?php
!defined('LIB_DIR') && die('Access Deny!');
/**
 * 框架核心类
 *
 * @package    classes
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
final class YUN_Core {

    /**
     * 存储单件模式实例
     *
     * @var Regulus_Core
     */
    private static $_instance = null;

    /**
     * 是否开启调试模式
     *
     * @var boolean
     */
    protected static $_debug = true;

    /**
     * 配置文件
     *
     * @var array
     */
    private  static $_configs = array();

    /**
     * REQUEST_URI
     *
     * @var string
     */
    private $_requestUri = null;

    /**
     * 構造函數
     *
     */
    private function __construct(){
        require_once 'Zend/Loader/Autoloader.php';
        Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

    }

    /**
     * 单件模式调用方法
     *
     * @return Regulus_Core
     */
    final  static function getInstance() {
        if(null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 设定文件查找路径
     *
     * @param  string  $path
     */
    public static function setIncludePath($path)
    {
        if (empty($path))
        return ;
        $paths = explode(PATH_SEP, get_include_path());
        !in_array($path, $paths) && $paths[] = $path;
        set_include_path(implode(PATH_SEP, $paths));
    }

    /**
     * 获取主机名
     *
     * @return string
     */
    public function getHttpHost() {
        $httpHost = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ?
                    $_SERVER['HTTP_X_FORWARDED_HOST'] :
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
        return strtolower($httpHost);
    }

    /**
     * 获取 REQUEST_URI
     *
     * @return string
     */
    public function getRequestUri()
    {
        if (null == $this->_requestUri) {
            $requestUri = '';
            if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
                $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
            } elseif (isset($_SERVER['REQUEST_URI'])) {
                $requestUri = $_SERVER['REQUEST_URI'];
            } elseif (isset($_SERVER['ORIG_PATH_INFO'])) {
                $requestUri = $_SERVER['ORIG_PATH_INFO'];
                !empty($_SERVER['QUERY_STRING']) && $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
            $this->_requestUri = $requestUri;
        }
        return $this->_requestUri;
    }

    /**
     * 载入配置文件
     *
     * @param  string  $configName  配置名
     * @return EGP_ArrayObject
     * @throws EGP_Exception
     */
    public static function loadConfig($configName) {
        if (!isset(self::$_configs[$configName])) {
            $filename = ETC_DIR  . $configName . '.php';
            if (!is_readable($filename))
                throw new Regulus_Exception("File '$filename' does not exist or can't readable");
            $config = require($filename);
            if (!is_array($config))
                throw new Regulus_Exception("Invalid config file '$filename'");
            $config = new YUN_ArrayObject($config);
            self::$_configs[$configName]  = $config;

			return self::$_configs[$configName];
        }
    }
    /**
     * 在所有及指定的目录内查找文件，并返回完整路径
     *
     * @param  string  $file  文件及路径
     * @param  mixed   $dirs  查找的目录
     * @return string|false
     */
    public static function findFile($file, $dirs = null)
    {
        $file = preg_replace('/[\\\\\/]+/', DIR_SEP, $file);
        if (!is_file($file)) {
            !is_array($dirs) && $dirs = array($dirs);
            null == self::$_dirs && self::$_dirs = explode(PATH_SEP, get_include_path());
            $dirs = array_merge($dirs, self::$_dirs);
            $tmp = '';
            foreach ($dirs as $dir) {
                $tmp = preg_replace('/[\\\\\/]+$/', '', trim($dir)) . DIR_SEP . $file;
                if (@is_file($tmp))
                    break;
                unset($tmp);
            }
            $file = empty($tmp) ? $file : $tmp;
        }
        return is_readable($file) ? $file : false;
    }

    /**
     * 查询是否存在指定的类，如果存在则自动加载
     *
     * @param  string  $class
     * @return boolean
     */
    public static function classExists($class, $dirs = null)
    {
        if (class_exists($class, false) || interface_exists($class, false))
            return true;
        $file = str_replace('_', DIR_SEP, $class) . '.php';
        if (is_readable(LIB_DIR . DIR_SEP . $file)) {
            require(LIB_DIR . DIR_SEP . $file);
        } else {
            $file = self::findFile($file, $dirs);
            if ($file !== false)
                require($file);
        }
        return class_exists($class, false) || interface_exists($class, false);
    }


    /**
     * Exception 异常处理器
     *
     * @param Exception $e
     */
    public static function exceptionHandler(Exception $e)
    {
        $trace = '';
        if (self::$_debug) {
            $trace = $e->getTraceAsString();
            preg_match_all('/\(\d+\): ([^\r\n]*)/', $trace, $code);
            preg_match_all('/#\d+ ([^(\(\d+\))]*)/', $trace, $file);
            preg_match_all('/\((\d+)\): /', $trace, $line);
            $trace = '';
            $k = 0;
            if ($code[1] && $file[1] && $line[1]) {
                foreach ($code[1] as $k => $v) {
                    $trace .= "    <b>#$k:</b> <font color=green>$v</font> on <i>" .
                              $file[1][$k] . "</i> in line " . $line[1][$k] . "<br>\r\n";
                }
            }
            $trace .= "    <b>#" . ($k + 1) . ":</b> <font color=green>{main}</font>";
        }
        @header('Content-Type:text/html; charset=utf-8');
        $trace && $trace = "  <div style=\"font:12px 'Courier New';border-top:1px dashed #999;" .
                           "margin:8px 0;padding-top:8px;\">\r\n$trace\r\n  </div>";
        echo <<<EOF
\r\n<div style="line-height:160%;color:#000;font:14px Arial;margin:5px;text-align:left;">
<b>Exception:&nbsp;</b><span style="color:#f00">{$e->getMessage()}</span>
(in <i>{$e->getFile()}</i> on line {$e->getLine()})
$trace
</div>\r\n
EOF;
        die();
    }

    /**
     * Error 错误处理器
     *
     * @param  integer  $errno
     * @param  string   $errstr
     * @param  string   $errfile
     * @param  integer  $errline
     * @param  mixed    $errcontext
     */
    public static function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        if (error_reporting() == 0)
            return;
        if (!self::$_debug && in_array($errno, array(8, 1024)))
            return;
        $errorTypes = array (
            E_ERROR             => 'ERROR',
            E_WARNING           => 'WARNING',
            E_PARSE             => 'PARSING ERROR',
            E_NOTICE            => 'NOTICE',
            E_CORE_ERROR        => 'CORE ERROR',
            E_CORE_WARNING      => 'CORE WARNING',
            E_COMPILE_ERROR     => 'COMPILE ERROR',
            E_COMPILE_WARNING   => 'COMPILE WARNING',
            E_USER_ERROR        => 'USER ERROR',
            E_USER_WARNING      => 'USER WARNING',
            E_USER_NOTICE       => 'USER NOTICE',
            E_STRICT            => 'STRICT NOTICE',
            E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
        );
        $errtype = $errorTypes[$errno];
        $trace = '';
        if (self::$_debug) {
            $backtrace = debug_backtrace();
            foreach ($backtrace as $k => $v) {
                if ($k == 0)
                    continue;
                $trace .= "    <b>#" . ($k - 1) . ":</b> ";
                $parse = '';
                if (isset($v['args']) && is_array($v['args']))
                    $parse = '(' . self::_errParseArgs($v['args']) . ')';
                if (isset($v['class'])) {
                    $obj = new ReflectionClass($v['class']);
                    $file = $obj->getFileName();
                    if ($obj->hasMethod($v['function'])) {
                        $func = $obj->getMethod($v['function']);
                        $line = $func->getStartLine();
                        $trace .= "<font color=green>{$v['class']}::{$v['function']}$parse</font> " .
                                  "on <i>$file</i> in line $line";
                    } else {
                        $trace .= "<del><font color=green>{$v['class']}::{$v['function']}$parse</font> " .
                                  "on <i>$file</i></del>";
                    }
                } elseif (isset($v['function'])) {
                    $trace .= "<font color=green>{$v['function']}$parse</font> " .
                              "on <i>{$v['file']}</i> in line {$v['line']}";
                }
                $trace .= "<br>\r\n";
            }
            $trace .= "<b>#" . $k . ":</b> <font color=green>{main}</font>\r\n";
        }
        $trace && $trace = "  <div style=\"font:12px 'Courier New';border-top:1px dashed #999;" .
                           "margin:8px 0;padding-top:8px;\">\r\n$trace  </div>";
        echo <<<EOF
\r\n<div style="line-height:160%;color:#000;font:14px Arial;margin:5px;text-align:left;">
<b>$errtype:&nbsp;</b><span style="color:#f00">$errstr</span>
(in <i>$errfile</i> on line $errline)
$trace
</div>\r\n
EOF;
        if (in_array($errno, array(1, 4, 16, 64, 256, 4096)))
            die();
    }

    /**
     * 解释错误相关参数，并以字符串形态返回
     *
     * @param  array   $args
     * @return string
     */
    public static function _errParseArgs(array $args)
    {
        $string = '';
        $separtor = '';
        foreach ($args as $arg) {
            $string .= $separtor . self::_errArgToString($arg);
            $separtor = ', ';
        }
        return $string;
    }

    /**
     * 将错误参数转换为字符串
     *
     * @param  mixed  $arg
     * @return string
     */
    public static function _errArgToString($arg)
    {
        $type = strtolower(gettype($arg));
        is_float($arg) && $type = 'float';
        switch ($type) {
            case 'double':
            case 'float':
            case 'integer':  return $arg;
            case 'string':   return "'$arg'";
            case 'boolean':  return $arg ? 'true' : 'false';
            case 'object':   return 'Object(' . get_class($arg) . ')';
            case 'resource': return 'Resource' . get_resource_type($arg) . ')';
            case 'null':     return("NULL");
            case 'array':
                $ret = 'array(';
                $separtor = '';
                foreach ($arg as $k => $v) {
                    $ret .= $separtor . $k . ' => ' . self::_errArgToString($v);
                    $separtor = ', ';
                }
                $ret .= ')';
                return $ret;
        }
    }

    /**
     * 返回调试模式
     *
     * @return unknown
     */
    public static function _getdebug()
    {
		return self::$_debug;
    }
}