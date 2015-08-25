<?php
/**
 * 点型图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Scatter extends OFC_Charts_Base
{
    /**
     * 构造函数
     *
     * @param string $colour
     * @param integer $dotSize
     */
    public function __construct($colour = null, $dotSize = 5)
    {
        parent::__construct();
        $this->type = 'scatter';
        if (isset($colour)) {
            $this->setColour($colour);
        }
        $this->setDotSize($dotSize);
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