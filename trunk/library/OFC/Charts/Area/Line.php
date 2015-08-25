<?php
/**
 * 实线区域图（移上去会显示实心节点）
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Area_Line extends OFC_Charts_Area
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'area_line';
    }
}
