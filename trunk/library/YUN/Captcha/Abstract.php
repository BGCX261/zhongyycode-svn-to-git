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
 * 图形验证码抽象类
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class YUN_Captcha_Abstract
{

    /**
     * ID 标识
     *
     * @var string
     */
    protected $_id = null;

    /**
     * 可选参数设置
     *
     * @var array
     */
    protected $_options = array(
        'length' => 4, //字符长度
        'width' => 100, //图片宽度
        'height' => 40, //图片高度
        'fontDir' => './fonts', //字体目录
        'fonts' => array(), //可随机应用的字体
        'imgDir' => './images/captcha', //图片文件目录
        'imgUrl' => '/images/captcha',
        'imgAlt' => '',
    );

    /**
     * 字符字典
     *
     * @var array
     */
    public $dict = array('2', '3', '4', '5', '6', '7', '9', 'A', 'C',
                         'D', 'E', 'F', 'H', 'J', 'K', 'L', 'M', 'N',
                         'P', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    /**
     * 验证码字串
     *
     * @var string
     */
    protected $_phrase = null;

    /**
     * 输出图像
     *
     * @var resource
     */
    protected $_image = null;

    /**
     * 构造方法
     *
     * @param  array $options
     * @throws YUN_Exception
     */
    public function __construct(array $options = array())
    {
        if (!extension_loaded("gd"))
            throw new Exception("GD 扩展库未启用");
        $this->_id = md5(uniqid() . microtime(true));
        foreach ($options as $key => $value)
            $this->set($key, $value);
    }

    /**
     * 参数设置
     *
     * @param  string  $key
     * @param  mixed   $value
     */
    public function set($key, $value)
    {
        if (isset($this->_options[$key]))
            $this->_options[$key] = $value;
    }

    /**
     * 获取参数设置
     *
     * @param  string  $key
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->_options[$key]) ? $this->_options[$key] : null;
    }

    /**
     * 魔术方法 - 参数设置
     *
     * @param  string  $key
     * @param  mixed   $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * 魔术方法 - 获取参数设置
     *
     * @param  string  $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * 生成验证码字串
     *
     * @return string
     */
    public function generatePhrase()
    {
        if (strlen($this->_phrase) != $this->_options['length']) {
            $phrase = '';
            $rand = array_rand($this->dict, $this->_options['length']);
            foreach ($rand as $index)
                $phrase .= $this->dict[$index];
            $this->_phrase = $phrase;
        }
        return $this->_phrase;
    }

    /**
     * 垃圾回收
     *
     */
    public function gc()
    {
        if ($this->_options['imgDir'] && mt_rand(0, 10) == 1) {
            $iterator = new DirectoryIterator($this->_options['imgDir']);
            foreach ($iterator as $file) {
                if ($file->isFile() && strrchr($file->getPathname(), '.') == '.png')
                    unlink($file->getPathname());
            }
        }
    }

    /**
     * 生成图像
     *
     * @param  string  $phrase
     * @return resource
     */
    abstract public function generateImage($phrase = null);

    /**
     * 生成验证码
     *
     * @param  boolean  $html  是否输出 HTML
     * @return string|void
     */
    public function generate($html = false)
    {
        $image = is_resource($this->_image) ? $this->_image : $this->generateImage();
        if ($html === true) {
            $this->gc();
            imagepng($image, $this->_options['imgDir'] . '/' . $this->_id . '.png');
            return '<img src="' . $this->_options['imgUrl'] . '/' . $this->_id . '.png" alt="' . $this->_options['imgAlt'] . '" />';
        } else {
            header("Content-type: image/png");
            imagepng($image);
            imagedestroy($image);
        }
    }
}