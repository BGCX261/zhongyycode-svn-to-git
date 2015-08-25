<?php
/**
 * Open flash chart 画图类
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Chart
{
    /**
     * 标题
     *
     * @var OFC_Elements_Title
     */
    public $title = null;

    /**
     * 元素
     *
     * @var array
     */
    public $elements = array();

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->title = new OFC_Elements_Title('这是标题');
        $this->elements = array();
    }

    /**
     * 设置标题
     *
     * @param  OFC_Elements_Title $t
     * @return OFC_Chart
     */
    public function setTitle(OFC_Elements_Title $t)
    {
        $this->title = $t;
        return $this;
    }

    /**
     * 添加元素
     *
     * @param  OFC_Charts_Base $e
     * @return OFC_Chart
     */
    public function addElement(OFC_Charts_Base $e)
    {
        $this->elements[] = $e;
        return $this;
    }

    /**
     * 设置X坐标轴
     *
     * @param  OFC_Elements_Axis_X $x
     * @return OFC_Chart
     */
    public function setXaxis(OFC_Elements_Axis_X $x)
    {
        $this->x_axis = $x;
        return $this;
    }

    /**
     * 设置Y坐标轴
     *
     * @param  OFC_Elements_Axis_Y $y
     * @return OFC_Chart
     */
    public function setYaxis(OFC_Elements_Axis_Y $y)
    {
        $this->y_axis = $y;
        return $this;
    }

    /**
     * 设置右边的Y坐标轴
     * 注意：右侧Y轴不能设置栅格颜色，只有左侧Y轴可以设置
     *
     * @param  OFC_Elements_Axis_Y $y
     * @return OFC_Chart
     */
    public function setYaxisRight(OFC_Elements_Axis_Y $y)
    {
        $this->y_axis_right = $y;
        return $this;
    }

    /**
     * 设置X轴说明文字
     *
     * @param  OFC_Elements_Legend $legend
     * @return OFC_Chart
     */
    public function setXLegend(OFC_Elements_Legend $legend)
    {
        $this->x_legend = $legend;
        return $this;
    }

    /**
     * 设置Y轴说明文字
     *
     * @param  OFC_Elements_Legend $legend
     * @return OFC_Chart
     */
    public function setYLegend(OFC_Elements_Legend $legend)
    {
        $this->y_legend = $legend;
        return $this;
    }

    /**
     * 设置背景颜色
     *
     * @param  string $colour
     * @return OFC_Chart
     */
    public function setBgColour($colour = '#FFFFFF')
    {
        $this->bg_colour = $colour;
        return $this;
    }

    /**
     * 设置提示文字样式
     *
     * @param  OFC_Elements_Tooltip $tooltip
     * @return OFC_Chart
     */
    public function setTooltip(OFC_Elements_Tooltip $tooltip)
    {
        $this->tooltip = $tooltip;
        return $this;
    }

    /**
     * 转为json字串。
     *
     * 注意：由于这里是直接把类本身转为json输出，因此我没有在类里面定义那些可选的成员变量，
     * 这些变量flash本身是有默认值的，例如背景颜色，X轴坐标等，这些成员变量只能在动态设置中
     * 定义，这样子就不会输出很多为空值的json属性了。
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * 输出json结果
     */
    public function output()
    {
        echo $this->__toString();
    }
}