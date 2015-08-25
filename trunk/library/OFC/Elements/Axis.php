<?php
/**
 * 坐标轴基类
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class OFC_Elements_Axis extends OFC_Elements_Base
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 设置颜色
     *
     * @param  string $colour
     * @param  string $gridColour
     * @return OFC_Elements_Axis
     */
    public function setColours($colour, $gridColour)
    {
        return $this->setColour($colour)->setGridColour($gridColour);
    }

    /**
     * 设置栅格颜色
     *
     * @param  string $colour
     * @return OFC_Elements_Axis
     */
    public function setGridColour($colour = '#F5E6B5')
    {
        $this->{'grid-colour'} = $colour;
        return $this;
    }

    /**
     * 设置坐标刻度
     *
     * @param  integer $steps
     * @return OFC_Elements_Axis
     */
    public function setSteps($steps = 1)
    {
        $this->steps = $steps;
        return $this;
    }

    /**
     * 设置坐标范围
     *
     * @param  float $min
     * @param  float $max
     * @param  integer $steps
     * @return OFC_Elements_Axis
     */
    public function setRange($min, $max, $steps = 1)
    {
        $this->min = $min;
        $this->max = $max;
        return $this->setSteps($steps);
    }

    /**
     * 设置坐标起始位置是否偏移原点
     *
     * @param  boolean $o
     * @return OFC_Elements_Axis
     */
    public function setOffset($o = true)
    {
        $this->offset = ($o) ? true : false;
        return $this;
    }

    /**
     * 设置坐标轴粗细
     *
     * @param  integer $stroke
     * @return OFC_Elements_Axis
     */
    public function setStroke($stroke = 2)
    {
        $this->stroke = $stroke;
        return $this;
    }
}