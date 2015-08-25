<?php
/**
 * 文件控制抽像类
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('LIB_DIR') && die('Access Deny!');
abstract class YUN_File_Abstract
{

    /**
     * 图片文件扩展名类型
     *
     * @var array
     */
    protected $_imgExt = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'wbmp');

    /**
     * 是否图片文件
     *
     * @param  string  $filename
     * @return boolean
     */
    public function isImage($filename) {
        return in_array($this->getExtension(basename($filename)), $this->_imgExt);
    }

    /**
     * 获取文件扩展名
     *
     * @param  string  $filename
     * @return string
     */
    public function getExtension($filename) {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }

}