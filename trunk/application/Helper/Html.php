<?php
/**
 * Html (View Helper)
 *
 * @package    helper
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('LIB_DIR') && die('Access Deny!');

class Helper_Html extends Zend_View_Helper_Abstract
{

    public function Html()
    {
        return $this;
    }
    /**
     * 判断两值如果相等，则返回指定的信息
     *
     * @param  mixed  $target
     * @param  mixed  $source
     * @param  mixed  $echo
     * @return mixed
     */
    public function ifCurrent($target, $source, $echo = null) {
        empty($echo) && $echo = ' style="color:red;font-weight:bold"';
        return $target == $source ? $echo : null;
    }

    /**
     * 判断两值如果相等，则返回 HTML option 的 selected
     *
     * @param  mixed  $target
     * @param  mixed  $source
     * @return string
     */
    public function selected($target, $source) {
        return $this->ifCurrent($target, $source, ' selected="selected"');
    }

    /**
     * 判断两值如果相等，则返回 HTML checkbox/radio 的 checked
     *
     * @param  mixed  $target
     * @param  mixed  $source
     * @return string
     */
    public function checked($target, $source) {
        return $this->ifCurrent($target, $source, ' checked="checked"');
    }

}