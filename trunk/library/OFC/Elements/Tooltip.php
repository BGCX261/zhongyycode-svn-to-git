<?php
/**
 * 提示文字（鼠标移上去显示的内容）的样式设置
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Elements_Tooltip extends OFC_Elements_Base
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 设置是否显示阴影
     *
     * @param  boolean $v
     * @return OFC_Elements_Tooltip
     */
    public function setShadow($v = true)
    {
        $this->shadow = $v;
        return $this;
    }

    /**
     * 设置边框大小
     *
     * @param  integer $s
     * @return OFC_Elements_Tooltip
     */
    public function setStroke($s = 1)
    {
        $this->stroke = $s;
        return $this;
    }

    /**
     * 设置背景颜色
     *
     * @param  string $colour
     * @return OFC_Elements_Tooltip
     */
    public function setBgColour($colour = '#FFFFFF')
    {
        $this->background = $colour;
        return $this;
    }

    /**
     * 设置标题样式
     *
     * @param  string $t
     * @return OFC_Elements_Tooltip
     */
    public function setTitle($t)
    {
        $this->title = $t;
        return $this;
    }

    /**
     * 设置内容样式
     *
     * @param  string $b
     * @return OFC_Elements_Tooltip
     */
    public function setBody($b)
    {
        $this->body = $b;
        return $this;
    }
}