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
 * 图形验证码类
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_Captcha
{

    /**
     * EGP_Captcha
     *
     * @var EGP_Captcha
     */
    private static $_instance = null;

    /**
     * 验证码数据存储器
     *
     * @var EGP_Session_NameSpace
     */
    private $_storage = null;

    /**
     * 单件模式调用方法
     *
     * @return EGP_Captcha
     */
    public static function getInstance()
    {
        null == self::$_instance && self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * 构造方法
     *
     */
    protected function __construct()
    {}

    /**
     * 工厂模式调用验证码驱动
     *
     * @param  string  $driver
     * @param  mixed   $options
     * @return EGP_Captcha_Abstract
     * @throws Exception
     */
    public static function factory($driver = 'basic', $options = array())
    {
        if ($options instanceof YUN_ArrayObject)
            $options = $options->toArray();

        if (!is_array($options))
            throw new Exception('验证码的配置必须是一个数组(Array)');

        $class = 'YUN_Captcha_' . ucfirst($driver);
        if (!YUN_Core::classExists($class))
            throw new Exception("不支持的验证码类型: '$driver'");

        $obj = new $class($options);
        if (!$obj instanceof YUN_Captcha_Abstract)
            throw new Exception("'$driver' 必须从 'YUN_Captcha_Abstract ' 继承");

        $storage = self::getInstance()->getStorage();
        $storage->phrase = strtolower($obj->generatePhrase());
        //$storage->lock(); //锁定

        return $obj;
    }

    /**
     * 设置验证码数据存储器
     *
     * @param EGP_Session_NameSpace $storage
     */
    public function setStorage(Zend_Session_NameSpace $storage)
    {
        $this->_storage = $storage;
    }

    /**
     * 获取到数据存储器
     *
     * @return EGP_Session_NameSpace
     */
    public function getStorage()
    {
        null == $this->_storage &&
            $this->_storage = new Zend_Session_NameSpace('CAPTCHA');
        return $this->_storage;
    }
    public  function getCaptcha()
    {
        return $this->_storage->phrase;
    }

    /**
     * 判断输入是否通过验证
     *
     * @param  string  $input
     * @return boolean
     */
    public function isValid($input)
    {
        $input = strtolower(trim($input));
        $phrase = $this->getStorage()->phrase;

        return (!empty($input) && $input === $phrase);
    }

}
