<?php
/**
 * 玻璃柱状图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Glass extends OFC_Charts_Bar
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'bar_glass';
    }
}