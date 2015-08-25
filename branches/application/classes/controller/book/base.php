<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 图书馆控制器基础类
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-10
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class Controller_Book_Base extends Controller_Base {


    /**
     * 控制器方法执行前的操作
     *
     */
    public function before()
    {
        parent::before();

    }
}