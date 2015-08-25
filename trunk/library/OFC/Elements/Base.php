<?php
/**
 * 基本元素（标题、坐标等）的抽象类
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class OFC_Elements_Base
{
    /**
     * 构造函数
     */
    public function __construct() {}

    /**
     * 设置样式
     *
     * @param  string $css
     * @return OFC_Elements_Base
     */
    public function setStyle($css)
    {
        $this->style = $css;
        return $this;
    }

    /**
     * 设置颜色
     *
     * @param  string $colour
     * @return OFC_Elements_Base
     */
    public function setColour($colour = '#784016')
    {
        $this->colour = $colour;
        return $this;
    }
}