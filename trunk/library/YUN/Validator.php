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
 * 数据校验器
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_Validator
{

    /**
     * 存储扩展校验器
     *
     * @var array
     */
    protected $_processor = array();

    /**
     * 校验规则
     *
     * @var array
     */
    protected $_rules = array();

    /**
     * 校验错误信息
     *
     * @var array
     */
    protected $_trace = array();

    /**
     * 构造方法
     *
     */
    public function __construct()
    {
        $this->loadExtension(new YUN_Validator_Extension_Base());
    }

    /**
     * 载入扩展校验器
     *
     * @param  YUN_Validator_Extension_Abstract  $extension
     * @return YUN_Validator
     * @throws Exception
     */
    public function loadExtension(YUN_Validator_Extension_Abstract $extension)
    {
        $processor = $extension->registerProcessor();
        foreach ($processor as $format => $method) {
            if (isset($this->_processor[$format]))
                throw new Exception("校验类型 '$format' 已存在");
            else
                $this->_processor[$format] = $method;
        }
        return $this;
    }

    /**
     * 批量加入校验器
     *
     * @param  mixed   $value  需要校验的值
     * @param  array   $rules  校验规则 array(array($format&$args, $message), ...)
     * @param  string  $ident  标识符
     * @return mixed
     * @throws Exception
     */
    public function check($value, array $rules, $ident = null)
    {
        if (!empty($rules)) {
            null === $ident && $ident = uniqid();
            foreach ($rules as $rule) {
                if (!is_array($rule))
                    throw new Exception('无效的检验器设定');
                if (is_string(key($rule))) {
                    $format = key($rule);
                    $args = is_array(current($rule)) ? current($rule) : array(current($rule));
                } elseif (is_string(current($rule))) {
                    $format = current($rule);
                    $args = array();
                } else {
                    throw new Exception("必须为校验器指定校验方法");
                }
                $message = next($rule);
                if ($message == false) {
                    throw new Exception("必须为校验器指定一条错误反馈信息");
                }
                $this->addRule($ident, $value, $format, $args, $message);
            }
        }
        return $this;
    }

    /**
     * 添加校验规则
     *
     * @param  string  $ident    标识符
     * @param  mixed   $value    需要校验的值
     * @param  string  $format   校验格式(callback function)
     * @param  array   $args     校验参数(callback argments)
     * @param  string  $message  出错时的反馈信息
     * @return YUN_Validator
     * @throws Exception
     */
    public function addRule($ident, $value, $format, array $args = array(), $message)
    {
        if (!isset($this->_processor[$format]))
            throw new Exception("不支持的校验类型：'$format'");
        $this->_rules[$ident][$format] = compact('value', 'args', 'message');
        return $this;
    }

    /**
     * 判断校验是否通过(所有规则全部通过则返回true)
     *
     * @param  string   $ident  标识符
     * @param  boolean  $break  校验失败是否中断执行
     * @return boolean
     */
    public function isValid($ident = null, $break = false)
    {
        $flag = true;
        foreach ($this->_rules as $key => $rule) {
            if (null === $ident || $key == $ident) {
                $allowEmpty = (boolean) !array_key_exists('NotEmpty', $rule);
                foreach ($rule as $format => $argments) {
                    extract($argments);
                    if (empty($value) && $allowEmpty === true)
                        continue;
                    $args = array_merge(array($value), $args);
                    $method = $this->_processor[$format];
                    $result = call_user_func_array($method, $args);
                    if ($result === false) {
                        $flag = false;
                        $this->_trace($key, $value, $method, $args, $message, $break);
                        if ($break === false)
                            return false;
                    }
                }
            }
        }
        return $flag;
    }

    /**
     * 添加校验跟踪信息
     *
     * @param  string        $ident
     * @param  mixed         $value
     * @param  string|array  $method
     * @param  array         $args
     * @param  string        $message
     * @param  boolean       $break
     */
    protected function _trace($ident, $value, $method, array $args, $message, $break = false)
    {
        $this->_trace[] = compact('ident', 'value', 'method', 'args', 'message', 'break');
    }

    /**
     * 获取第一条校验失败的信息，如果没有任何规则发生错误则返回false
     *
     * @param  boolean $detail
     * @return string|false
     */
    public function getMessage($detail = false)
    {
        $trace = isset($this->_trace[0]) ? $this->_trace[0] : false;
        return $detail === true ? $trace :
                    (isset($trace['message']) ? $trace['message'] : false);
    }

    /**
     * 获取所有校验跟踪信息
     *
     * @return array
     */
    public function getTrace()
    {
        return $this->_trace;
    }

    /**
     *  移除所有检验规则及跟踪信息
     *
     * @return YUN_Validator
     */
    public function clean()
    {
        $this->_trace = array();
        $this->_rules = array();
        return $this;
    }

}