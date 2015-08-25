<?php
/**
 * 线条
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Line extends OFC_Charts_Base
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'line';
    }

    /**
     * 设置线条粗细
     *
     * @param  float $w
     * @return OFC_Charts_Line
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
     * @return OFC_Charts_Line
     */
    public function setDotSize($size)
    {
        $this->{'dot-size'} = $size;
        return $this;
    }

    /**
     * 设置节点与线条之间的空隙大小
     *
     * @param  integer $size
     * @return OFC_Charts_Line
     */
    public function setHaloSize($size)
    {
        $this->{'halo-size'} = $size;
        return $this;
    }
}