<?php
/**
 * 柱状图的值
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Value extends OFC_Charts_Base
{
    /**
     * 构造函数，柱状图的值相当于 $top - $bottom
     *
     * @param float $top
     * @param float $bottom
     */
    public function __construct($top, $bottom = null)
    {
        $this->top = $top;

        if (isset($bottom)) {
            $this->bottom = $bottom;
        }
    }
}