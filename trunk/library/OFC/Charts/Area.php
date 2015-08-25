<?php
/**
 * 区域图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class OFC_Charts_Area extends OFC_Charts_Base
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'area';
        $this->setFillAlpha(0.35);
    }

    /**
     * 设置线条粗细
     *
     * @param  float $w
     * @return OFC_Charts_Area
     */
    public function setWidth($w)
    {
        $this->width = $w;
        return $this;
    }

    /**
     * 设置节点大小
     *
     * @param  float $size
     * @return OFC_Charts_Area
     */
    public function setDotSize($size)
    {
        $this->{'dot-size'} = $size;
        return $this;
    }

    /**
     * 设置区域透明度
     *
     * @param  float $alpha 0～1之间的值，0为完全透明，1为完全不透明
     * @return OFC_Charts_Area
     */
    public function setFillAlpha($alpha)
    {
        $this->{'fill-alpha'} = $alpha;
        return $this;
    }

    /**
     * 设置区域的颜色
     *
     * @param  string $color
     * @return OFC_Charts_Area
     */
    public function setFillColor($color)
    {
        $this->fill = $color;
        return $this;
    }

    /**
     * 设置节点与线条之间的空隙大小
     *
     * @param  integer $size
     * @return OFC_Charts_Area
     */
    public function setHaloSize($size)
    {
        $this->{'halo-size'} = $size;
        return $this;
    }
}