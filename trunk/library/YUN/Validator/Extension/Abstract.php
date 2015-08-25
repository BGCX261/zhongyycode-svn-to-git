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
 * 数据校验器扩展抽像类
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class YUN_Validator_Extension_Abstract
{

    /**
     * 注册校验处理器
     *
     * @return array
     * @throws YUN_Exception
     */
    public function registerProcessor()
    {
        $class = get_class($this);
        $reflection = new ReflectionClass($class);
        $methods = $reflection->getMethods();
        $processor = array();
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if ($method->isPublic() && $method->isStatic())
                $processor[ucfirst($methodName)] = array(&$this, $methodName);
        }
        if (empty($processor))
            throw new Exception("扩展校验器 '$class' 必须拥有至少一个 public static 的校验方法");
        return $processor;
    }

}