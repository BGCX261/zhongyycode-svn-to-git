<?php
/**
 * 堆栈柱状图的值
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Stack_Value extends OFC_Charts_Base
{
    /**
     * 构造函数
     *
     * @param float $val
     * @param string $colour
     */
    public function __construct($val, $colour = null)
    {
        $this->val = $val;
        if (isset($colour)) {
            $this->setColour($colour);
        }
    }
}