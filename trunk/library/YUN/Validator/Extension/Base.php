<?php
/**
 * EGP Framework
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
 */

!defined('LIB_DIR') && die('Access Deny!');

/**
 * 数据校验器扩展
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_Validator_Extension_Base extends YUN_Validator_Extension_Abstract
{

    /**
     * 注册校验处理器
     *
     * @return array
     */
    public function registerProcessor()
    {
        $processor = parent::registerProcessor();
        $exts = array(
            'Numeric'   => 'is_numeric',   //是否数字
            'Array'     => 'is_array',     //是否数组
            'InArray'   => 'in_array',     //数组中是否存在某个值
            'Alpha'     => 'ctype_alpha',  //是否为字母
            'Hex'       => 'ctype_xdigit', //是否十六进制数
        );
        return array_merge($processor, $exts);
    }

    /**
     * 是否相等
     *
     * @param   mixed   $value
     * @param   mixed   $target
     * @return  boolean
     */
    public static function equal($value, $target)
    {
        return ($value === $target);
    }

    /**
     * 忽略大小写判断是否相等
     *
     * @param   mixed   $value
     * @param   mixed   $target
     * @return  boolean
     */
    public static function caseEqual($value, $target)
    {
        if (is_string($value) && is_string($target)) {
            $value = strtolower($value);
            $target = strtolower($target);
        }
        return self::equal($value, $target);
    }

    /**
     * 是否不相等
     *
     * @param   mixed   $value
     * @param   mixed   $target
     * @return  boolean
     */
    public static function notEqual($value, $target)
    {
        return !self::equal($value, $target);
    }

    /**
     * 是否为空
     *
     * @param  mixed  $value
     * @return boolean
     */
    public static function notEmpty($value)
    {
        return !((is_string($value) && trim($value) == '')
            || $value == null
            | (is_array($value) && count($value) == 0));
    }

    /**
     * 是否为有效的整数
     *
     * @param  mixed  $value
     * @return boolean
     */
    public static function integer($value)
    {
        return (is_numeric($value) ? intval($value) == $value : false);
    }

    /**
     * 是否为有效的布尔值
     *
     * @param  mixed  $value
     * @return boolean
     */
    public static function boolean($value)
    {
        return is_bool($value) || self::regex($value, '/^0|1|true|false$/i');
    }

    /**
     * 是否浮点数
     *
     * @param  mixed  $value
     * @return boolean
     */
    public static function float($value)
    {
        $locale = localeconv();
        $filtered = str_replace($locale['thousands_sep'], '', $value);
        $filtered = str_replace($locale['decimal_point'], '.', $filtered);
        return (strval(floatval($filtered)) == $filtered);
    }

    /**
     * 是否有效的日期格式
     *
     * @param  string  $value      Y-m-d格式的日期
     * @param  string  $separator  日期分隔符
     * @return boolean
     */
    public static function dateFormat($value, $separator = '-')
    {
        if(!empty($value)) {
            list($year, $month, $day) = explode($separator, $value);
            return checkdate($month, $day, $year);
        }
        return false;
    }

    /**
     * 是否有效的邮件地址
     *
     * @param  string  $value
     * @return boolean
     */
    public static function email($value)
    {
        return self::regex($value, '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/');
    }

    /**
     * 检测是否有效的身份证号码
     *
     */
    public static function idCard($value)
    {
        return self::regex($value, '/^\d{15}(\d{2}[\dx])?$/i');
    }

    /**
     * 是否有效的 URL 地址
     *
     * @param  string  $value
     * @return boolean
     */
    public static function url($value)
    {
        return self::regex($value, '/^https?:\/\/([^\["\'\s\.]+\.)+[^\["\'\s\<\>]+$/i');
    }

    /**
     * 是否有效的 IP 地址
     *
     * @param  string  $value
     * @return boolean
     */
    public static function ip($value)
    {
        $result = ip2long($value);
        return ($result == -1 || $result === false) ? false : true;
    }

    /**
     * 是否 QQ 号码
     *
     * @param  integer  $value
     * @return boolean
     */
    public static function qQ($value)
    {
        return self::integer($value) && ($value > 10001);
    }

    /**
     * 是否只包含中文字符
     *
     * @param  string  $value
     * @return boolean
     */
    public static function chinese($value)
    {
        return self::regex($value, '/^[\x{4e00}-\x{9fa5}]+$/u');
    }

    /**
     * 是否只包含英文字母
     *
     * @param  string  $value
     * @return boolean
     */
    public static function english($value)
    {
        return self::regex($value, '/^\w+$/');
    }

    /**
     * 是否大于指定的值
     *
     * @param  integer  $value
     * @param  integer  $min
     * @return boolean
     */
    public static function greaterThan($value, $min = 0)
    {
        return $value > $min;
    }

    /**
     * 是否大于等于指定的值
     *
     * @param  integer  $value
     * @param  integer  $min
     * @return boolean
     */
    public static function greaterEqualThan($value, $min = 0)
    {
        return $value >= $min;
    }

    /**
     * 是否小于指定的值
     *
     * @param  integer  $value
     * @param  integer  $max
     * @return boolean
     */
    public static function lessThan($value, $max = 0)
    {
        return $value < $max;
    }

    /**
     * 是否小于等于指定的值
     *
     * @param  integer  $value
     * @param  integer  $max
     * @return boolean
     */
    public static function lessEqualThan($value, $max = 0)
    {
        return $value <= $max;
    }

    /**
     * 是否介于指定的值之间
     *
     * @param  integer  $value
     * @param  integer  $min
     * @param  integer  $max
     * @return boolean
     */
    public static function between($value, $min = 0, $max = 0)
    {
        return self::greaterEqualThan($value, $min) && self::lessEqualThan($value, $max);
    }

    /**
     * 字符串是否大于指定的长度
     *
     * @param  string   $value
     * @param  integer  $min
     * @param  integer  $max
     * @param  string   $charset
     * @return boolean
     */
    public static function strlenGreaterThan($value, $min = 0)
    {
        return self::greaterThan(strlen($value), $min);
    }

    /**
     * 字符串是否小于指定的长度
     *
     * @param  string   $value
     * @param  integer  $min
     * @param  integer  $max
     * @param  string   $charset
     * @return boolean
     */
    public static function strlenLessThan($value, $max = 0)
    {
        return self::lessThan(strlen($value), $max);
    }

    /**
     * 字符串长度是否介于指定的长度之间
     *
     * @param  string   $value
     * @param  integer  $min
     * @param  integer  $max
     * @param  string   $charset
     * @return boolean
     */
    public static function stringLength($value, $min = 0, $max = 0)
    {
        return self::between(strlen($value), $min, $max);
    }

    /**
     * 使用PERL正则表达式对字符串进行判断
     *
     * @param  string  $value
     * @param  string  $pattern
     * @return boolean
     */
    public static function regex($value, $pattern)
    {
        return (boolean) preg_match($pattern, $value);
    }

    /**
     * 判断验证码
     *
     * @param  string  $value
     * @return boolean
     */
    public static function captcha($value)
    {
        return EGP_Captcha::getInstance()->isValid($value);
    }

}
