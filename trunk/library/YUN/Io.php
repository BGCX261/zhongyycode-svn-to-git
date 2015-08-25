<?php
!defined('LIB_DIR') && die('Access Deny!');

/**
 * IO 处理
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class YUN_Io
{

    /**
     * 修正路径分隔符为操作系统的正确形式
     *
     * @param  string  $path
     * @return string
     */
    public static function strip($path)
    {
        return empty($path) ? $path : preg_replace('/[\\\\\/]+/', DIR_SEP, (string) $path);
    }

    /**
     * 创建目录(递归创建)
     *
     * @param  string  $path
     * @return string|false
     */
    public static function mkdir($dir)
    {
        $dir = self::strip($dir);
        if (!is_dir($dir)) {
            $mk = @mkdir($dir, 0777, true);
            if ($mk === false)
                return false;
        }
        return $dir;
    }

    /**
     * 删除目录(递归删除)
     *
     * @param  string  $dir
     * @return boolean
     */
    public static function rmdir($dir)
    {
        if (is_dir($dir)) {
            $dirs = self::scan($dir);
            if (is_array($dirs)) {
                $flag = true;
                foreach ($dirs as $file) {
                    $file = "$dir/$file";
                    if (is_dir($file)) {
                        $flag = self::rmdir($file);
                    } else {
                        $flag = @unlink($file);
                    }
                    if ($flag == false) {
                        break;
                    }
                }
            }
            return @rmdir($dir);
        }
        return false;
    }

    /**
     * 扫描目录下所有的文件/目录
     *
     * @param  string  $dir     指定的目录
     * @param  array   $ignore  需要跳过的文件/目录
     * @return array|false
     */
    public static function scan($dir, array $ignore = array('.svn'))
    {
        $dir = self::strip($dir);
        if (is_dir($dir)) {
            $dirs = scandir($dir);
            foreach ($dirs as $k => $v) {
                if ($v == '.' || $v == '..' || in_array($v, $ignore))
                    unset($dirs[$k]);
            }
            return $dirs;
        }
        return false;
    }

    /**
     * 复制文件/目录
     *
     * @param  string   $from      源文件/目录
     * @param  string   $to        目标文件/目录
     * @param  boolean  $override  是否覆盖
     * @param  array    $ignore    需要跳过的文件/目录
     * @return boolean
     */
    public static function copy($from, $to, $override = false, array $ignore = array('.svn'))
    {
        $from = self::strip($from);
        $to   = self::strip($to);
        if (is_file($from)) {
            self::mkdir(dirname($to));
            return is_file($to) && $override !== true ? true : @copy($from, $to);
        } elseif (is_dir($from)) {
            $dirs = self::scan($from, $ignore);
            if (is_array($dirs)) {
                foreach ($dirs as $file)
                    self::copy("$from/$file", "$to/$file", $override, $ignore);
            }
            return true;
        }
        return false;
    }

}