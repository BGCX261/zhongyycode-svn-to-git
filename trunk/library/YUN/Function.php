<?php
/**
 * EGP Framework v1.0.0 Beta
 *
 * LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 * @version    v1.0.0 Beta @ $update_time$
 */

!defined('LIB_DIR') && die('Access Deny!');

/**
 * 自定通用函数集
 *
 * <i>以下的函数，很可能在其他的框架中已经被定义过了</i>
 *
 * @package    function
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

if (!function_exists('array_merge_deep')) {
    /**
     * 递归地合并一个或多个数组(不同于 array_merge_recursive )
     *
     * @return array
     */
    function array_merge_deep()
    {
        $a = func_get_args();
        for ($i = 1; $i < count($a); $i++) {
            foreach ($a[$i] as $k => $v) {
                if (isset($a[0][$k])) {
                    if (is_array($v)) {
                        if (is_array($a[0][$k])) {
                            $a[0][$k] = array_merge_deep($a[0][$k], $v);
                        } else {
                            $v[] = $a[0][$k];
                            $a[0][$k] = $v;
                        }
                    } else {
                        $a[0][$k] = is_array($a[0][$k]) ? array_merge($a[0][$k], array($v)) : $v;
                    }
                } else {
                    $a[0][$k] = $v;
                }
            }
        }
        return $a[0];
    }
}

if (!function_exists('stripslashes_deep')) {
    /**
     * 支持数组形态的 stripslashes
     *
     * @param  mixed  $value
     * @return mixed
     */
    function stripslashes_deep($value)
    {
        return is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);
    }
}

if (!function_exists('addslashes_deep')) {
    /**
     * 支持数组形态的 addslashes
     *
     * @param  mixed  $value
     * @return mixed
     */
    function addslashes_deep($value)
    {
        return is_array($value) ?
                array_map('addslashes_deep', $value) :
                addslashes($value);
    }
}

if (!function_exists('lcfirst')) {
    /**
     * Make a string's first character lowercase
     *
     * @param  string  $string
     * @return string
     */
    function lcfirst($string)
    {
        $string = (string) $string;
        return empty($string) ? '' : strtolower($string{0}) . substr($string, 1);
    }
}

if (!function_exists('lcwords')) {
    /**
     * Lowercase the first character of each word in a string
     *
     * @param  string  $string
     * @return string
     */
    function lcwords($string)
    {
        $tokens = explode(' ', $string);
        if (!is_array($tokens) || count($tokens) <= 1)
            return lcfirst($string);
        $result = array();
        foreach ($tokens as $token)
            $result[] = lcfirst($token);
        return implode(' ', $result);
    }
}

if (!function_exists('str_break')) {
    /**
     * 按指定的长度切割字符串
     *
     * @param  string   $string     需要切割的字符串
     * @param  integer  $length     长度
     * @param  string   $suffix     切割后补充的字符串
     * @return string
     */
    function str_break($string, $length, $suffix = '')
    {
        if (strlen($string) <= $length + strlen($suffix))
            return $string;

        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif (224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $length)
                break;
        }
        $noc > $length && $n -= $tn;
        $strcut = substr($string, 0, $n);
        if (strlen($strcut) < strlen($string)) {
            $strcut .= $suffix;
        }
        return $strcut;
    }
}

if (!function_exists('zh_strlen')) {
    /**
     * 获取中文字符长度(包括全角字符)
     *
     * @param  string  $str
     * @return integer
     */
    function zh_strlen($str)
    {
        $len = strlen($str);
        $n = $i = 0;
        while($i < $len){
            if (preg_match('/^[' . chr(0xa1) . '-' . chr(0xff) . ']+$/', $str[$i])) {
                $i += 2;
            } else {
                $i++;
            }
            $n++;
        }
        return $n;
    }
}

if (!function_exists('light_keyword')) {
    /**
     * 字符串高亮
     *
     * @param  string  $string   需要的高亮的字符串
     * @param  string  $keyword  关键字
     * @return string
     */
    function light_keyword($string, $keyword)
    {
        if ($string && $keyword) {
            if (!is_array($keyword)) {
                $keyword = array($keyword);
            }
            $pattern = array();
            foreach ($keyword as $word) {
                $pattern[] = '(' . preg_quote($word) . ')';
            }
            $string = preg_replace(
                '/(' . implode('|', $pattern) . ')/is',
                '<span class="highlight">\\1</span>',
                $string
            );
        }
        return $string;
    }
}

if (!function_exists('html2txt')) {
    /**
     * 将 HTML 转换为文本
     *
     * @param  string  $html
     * @return string
     */
    function html2txt($html)
    {
        $html = trim($html);
        if (empty($html))
            return $html;
        $search = array("'<script[^>]*?>.*?</script>'si",
            "'<style[^>]*?>.*?</style>'si",
            "'<[\/\!]*?[^<>]*?>'si",
            "'([\r\n])[\s]+'",
            "'&(quot|#34);'i",
            "'&(amp|#38);'i",
            "'&(lt|#60);'i",
            "'&(gt|#62);'i",
            "'&(nbsp|#160)[;]*'i",
            "'&(iexcl|#161);'i",
            "'&(cent|#162);'i",
            "'&(pound|#163);'i",
            "'&(copy|#169);'i",
            "'&#(\d+);'e"
        );
        $replace = array("", "", "", "\\1", "\"", "&", "<", ">", " ",
                         chr(161), chr(162), chr(163), chr(169), "chr(\\1)");
        return preg_replace($search, $replace, $html);
    }
}

if (!function_exists('dnl2br')) {
    /**
     * 重写 nl2br
     *
     * @param  string  $text
     * @return string
     */
    function dnl2br($text)
    {
        return str_replace(array("\r\n", "\r", "\n"), "<br />", str_replace('  ', '&nbsp;&nbsp;', $text));
    }
}

if (!function_exists('url2link')) {
    /**
     * 将内容中的 URL 地址转换为超链接
     *
     * @param  string  $text
     * @param  string  $target
     * @return string
     */
    function url2link($text, $target = '_blank')
    {
        $pattern = '/https?:\/\/([^\["\'\s\.]+\.)+[^\["\'\s\<\>]+/i';
        preg_match_all($pattern, $text, $matches);
        if (isset($matches[0]) && !empty($matches[0])) {
            $matches = array_unique($matches[0]);
            foreach ($matches as $url) {
                $tmp = $url;
                $length = 65;
                if(strlen($tmp) > $length) {
                    $tmp = substr($tmp, 0, intval($length * 0.5)) . ' ... ' . substr($tmp, - intval($length * 0.3));
                }
                $text = str_replace($url, "<a href=\"$url\" target=\"$target\" title=\"$url\">$tmp</a>", $text);
            }
        }
        return $text;
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     *
     * @return unknown
     */
    function get_client_ip()
    {
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        elseif (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        elseif (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        elseif (isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = 'unknown';
        return $ip;
    }
}

if (!function_exists('md5_mix')) {
    /**
     * 对任意类型进行 md5 加密
     *
     * @param  mixed  $mixed
     * @return string
     */
    function md5_mix($mixed)
    {
        return md5(var_export($mixed, true));
    }
}

if (!function_exists('url_ping')) {
    /**
     * 判断网址是否可以正常访问
     *
     * @param  string  $url
     * @return boolean
     */
    function url_ping($url)
    {
        $headers = @get_headers($url);
        if (isset($headers[0])) {
            preg_match('/ (\d{3}) /', $headers[0], $matches);
            if (isset($matches[1]) && $matches[1] < 400) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('strip_html')) {
    /**
     * strip_tags的修改版
     *
     * @param  string  $str
     * @return string
     */
    function strip_html($str)
    {
        $str = strip_tags(preg_replace('/(\s|&nbsp;|<br ?\/?>)+/i', ' ', $str));
        $str = trim(preg_replace('/\s+/', ' ', $str));
        return $str;
    }
}

/**
 * 去除字符串右侧可能出现的乱码
 *
 * @param   string      $str        字符串
 *
 * @return  string
 */
function trim_right($str) {

    $len = strlen($str);
    /* 为空或单个字符直接返回 */
    if ($len == 0 || ord($str{$len-1}) < 127)
    {
        return $str;
    }
    /* 有前导字符的直接把前导字符去掉 */
    if (ord($str{$len-1}) >= 192)
    {
        return substr($str, 0, $len-1);
    }
    /* 有非独立的字符，先把非独立字符去掉，再验证非独立的字符是不是一个完整的字，不是连原来前导字符也截取掉 */
    if (preg_match("/utf/i", REGULUS_CHARSET))
    {
        $r_len = strlen(rtrim($str, "\x80..\xBF"));
    }
    elseif (preg_match("/gb/i", REGULUS_CHARSET))
    {
        $r_len = strlen(rtrim($str, "\u4e00..\u9fa5"));
    }
    else
    {
        $r_len = strlen(rtrim($str, "\x80..\xBF"));
    }
    if ($r_len == 0 || ord($str{$r_len-1}) < 127)
    {
        return sub_str($str, 0, $r_len);
    }

    $as_num = ord(~$str{$r_len -1});
    if ($as_num > (1<<(6 + $r_len - $len)))
    {
        return $str;
    }
    else
    {
        return substr($str, 0, $r_len-1);
    }
}

/**
 * 修正路径分隔符为操作系统的正确形式
 *
 * @param  string  $path
 * @return string
 */
function strip($path)
{
    return empty($path) ? $path : preg_replace('/[\\\\\/]+/', DIR_SEP, (string) $path);
}