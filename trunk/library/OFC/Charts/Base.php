<?php
/**
 * 基本图形的抽象类
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
abstract class OFC_Charts_Base
{
    /**
     * 构造函数
     */
    public function __construct()
    {

    }

    /**
     * 设置数值
     *
     * @param  array $v
     * @return OFC_Charts_Base
     */
    public function setValues(array $v)
    {
        $this->values = $v;
        return $this;
    }

    /**
     * 插入数值
     *
     * @param  mix $v
     * @return OFC_Charts_Base
     */
    public function appendValue($v)
    {
        $this->values[] = $v;
        return $this;
    }

    /**
     * 设置图形颜色
     *
     * @param  string $colour
     * @return OFC_Charts_Base
     */
    public function setColour($colour = '#3030D0')
    {
        $this->colour = $colour;
        return $this;
    }

    /**
     * 设置图形说明
     *
     * @param  string $text
     * @param  integer $size
     * @return OFC_Charts_Base
     */
    public function setKey($text, $size = 16)
    {
        $this->text = $text;
        $this->{'font-size'} = $size;
        return $this;
    }

    /**
     * 设置注释（鼠标移上去显示的内容）
     * 注意：$tip字串里面的#key#、#val#等内容会替换成相应的值
     *
     * @param  string $tip
     * @return OFC_Charts_Base
     */
    public function setTip($tip)
    {
        $this->tip = $tip;
        return $this;
    }

    /**
     * 设置点击图形时触发的事件，目前饼状图和线条是支持的
     *
     * @param  string $url
     * @return OFC_Charts_Base
     */
    public function setClick($url)
    {
        $this->{'on-click'} = $url;
        return $this;
    }
}
