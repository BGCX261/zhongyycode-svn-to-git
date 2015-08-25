<?php
/**
 * 用户类
 *
 * @package    classes
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('LIB_DIR') && die('Access Deny!');

class YUN_Users extends YUN_Abstract
{
    /**
     * 返回用户sql
     *
     * @return object
     */
    public function infoSql()
    {
        return $this->db->select()
            ->from('user')
            ->order('user.uid DESC');
    }

    public function logou()
    {

    }
}
