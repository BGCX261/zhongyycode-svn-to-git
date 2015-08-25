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
 * 将数组转换为对象形态使用
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_ArrayObject extends ArrayObject
{

    /**
     * 构造方法
     *
     * @param  array  $array
     */
    public function __construct(array $array = array())
    {
        foreach ($array as &$value)
            is_array($value) && $value = new self($value);
        parent::__construct($array);
    }

    /**
     * 使用魔术方法通过指定 name 获取值
     *
     * @param  string  $index
     * @return mixed
     */
    public function __get($index)
    {
        return $this->offsetGet($index);
    }

    /**
     * 使用魔术方法修改指定 name 的值
     *
     * @param  string  $index
     * @param  mixed   $value
     */
    public function __set($index, $value)
    {
        $this->offsetSet($index, $value);
    }

    /**
     * 通过魔术方法判断数据是否已被设置
     *
     * @param  string  $index
     * @return boolean
     */
    public function __isset($index)
    {
        return $this->offsetExists($index);
    }

    /**
     * 通过魔术方法删除数据
     *
     * @param  string  $index
     */
    public function __unset($index)
    {
        $this->offsetUnset($index);
    }

    /**
     * 将数据信息转换为数组形式
     *
     * @return array
     */
    public function toArray()
    {
        $array = $this->getArrayCopy();
        foreach ($array as &$value)
            ($value instanceof self) && $value = $value->toArray();
        return $array;
    }

    /**
     * 将数据组转换为字符串形式
     *
     * @return array
     */
    public function __toString()
    {
        return var_export($this->toArray(), true);
    }

}