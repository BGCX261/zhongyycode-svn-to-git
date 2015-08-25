<?php
/**
 * 显示空心节点的线条
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Line_Hollow extends OFC_Charts_Line
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'line_hollow';
    }
}