<?php
/**
 * 水平柱状图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Horizontal extends OFC_Charts_Bar
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = "hbar";
    }

    /**
     * 插入数值
     *
     * @param  OFC_Charts_Bar_Horizontal_Value $v
     * @return OFC_Charts_Bar_Horizontal
     */
    public function appendValue(OFC_Charts_Bar_Horizontal_Value $v)
    {
        $this->values[] = $v;
        return $this;
    }
}
