<?php
/**
 * 饼形图的值
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Pie_Value extends OFC_Charts_Base
{
    /**
     * 构造函数
     *
     * @param float $value
     * @param string $label
     * @param string $tip
     */
    public function __construct($value, $label = null, $tip = null)
    {
        $this->setValue($value);
        if (isset($label)) {
            $this->setLabel($label);
        } else {
            $this->setLabel($value);
        }
        if (isset($tip)) {
            $this->setTip($tip);
        }
    }

    /**
     * 设置值
     *
     * @param  float $value
     * @return OFC_Charts_Pie_Value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * 从OFC_Charts_Base继承过来，但实际上没法用，所以定义为空
     *
     * @param  array $v
     * @return OFC_Charts_Pie_Value
     */
    public function setValues(array $v)
    {
        return $this;
    }

    /**
     * 设置标签
     *
     * @param  string $label
     * @return OFC_Charts_Pie_Value
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * 设置提示文字
     *
     * @param  string $tip
     * @return OFC_Charts_Pie_Value
     */
    public function setTip($tip)
    {
        $this->tip = $tip;
        return $this;
    }

    /**
     * 设置字体大小
     *
     * @param  integer $size
     * @return OFC_Charts_Pie_Value
     */
    public function setFontSize($size = 12)
    {
        $this->{'font-size'} = $size;
        return $this;
    }

    /**
     * 设置标签颜色
     *
     * @param  string $colour
     * @return OFC_Charts_Pie_Value
     */
    public function setLabelColour($colour)
    {
        $this->{'label-colour'} = $colour;
        return $this;
    }
}