<?php
/**
 * 堆栈柱状图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Stack extends OFC_Charts_Bar
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'bar_stack';
    }

    /**
     * 插入数值，这里插入的值必须是一个数组，柱状图的总值是这个数组的值的总和，
     * 例如array(1, 2, 3)，那么柱状图的总值是6，然后会分为三部分显示。
     * 此外，这个数组的元素除了普通的数值还可以是OFC_Charts_Bar_Stack_Value，可以指定
     * 显示的颜色。
     *
     * @param  array $v
     * @return OFC_Charts_Bar_Stack
     */
    public function appendValue(array $v)
    {
        $this->values[] = $v;
        return $this;
    }
}
