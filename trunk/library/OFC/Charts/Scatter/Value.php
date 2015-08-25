<?php
/**
 * 点型图的值
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Scatter_Value extends OFC_Charts_Base
{
    /**
     * 构造函数
     *
     * @param float $x
     * @param float $y
     * @param integer $dotSize
     */
    public function __construct($x, $y, $dotSize = null)
    {
        $this->x = $x;
        $this->y = $y;

        if (isset($dotSize)) {
            $this->setDotSize($dotSize);
        }
    }

    /**
     * 设置节点大小
     *
     * @param  float $size
     * @return OFC_Charts_Scatter
     */
    public function setDotSize($size)
    {
        $this->{'dot-size'} = $size;
        return $this;
    }
}