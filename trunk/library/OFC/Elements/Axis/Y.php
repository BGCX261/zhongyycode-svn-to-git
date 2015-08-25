<?php
/**
 * Y轴坐标
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Elements_Axis_Y extends OFC_Elements_Axis
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 设置坐标刻度长度
     *
     * @param  integer $val
     * @return OFC_Elements_Axis_Y
     */
    public function setTickLength($val = 3)
    {
        $this->{'tick-length'} = $val;
        return $this;
    }

    /**
     * 设置标签
     *
     * @param  array $labels
     * @return OFC_Elements_Axis_Y
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
        return $this;
    }
}