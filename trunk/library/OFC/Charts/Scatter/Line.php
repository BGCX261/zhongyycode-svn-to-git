<?php
/**
 * 有线条连接的点型图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Scatter_Line extends OFC_Charts_Scatter
{
    /**
     * 构造函数
     *
     * @param string $colour
     * @param integer $dotSize
     */
    public function __construct($colour = null, $dotSize = 5)
    {
        parent::__construct($colour, $dotSize);
        $this->type = 'scatter_line';
   }
}