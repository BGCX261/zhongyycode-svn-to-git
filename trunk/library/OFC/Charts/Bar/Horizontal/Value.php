<?php
/**
 * 水平柱状图的值
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Horizontal_Value extends OFC_Charts_Base
{
    /**
     * 构造函数
     *
     * @param float $left
     * @param float $right
     */
    public function __construct($left = null, $right = null)
    {
        if (isset($left)) {
            $this->left = $left;
        }
        if (isset($right)) {
            $this->right = $right;
        }
    }
}