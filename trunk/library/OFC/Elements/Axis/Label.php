<?php
/**
 * 坐标轴标签，目前只对X轴有效
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Elements_Axis_Label extends OFC_Elements_Base
{
    /**
     * 构造函数
     *
     * @param  array $labels
     */
    public function __construct($labels = null)
    {
        parent::__construct();
        if (!empty($labels)) {
            $this->setLabels($labels);
        }
    }

    /**
     * 设置文字大小
     *
     * @param  integer $size
     * @return OFC_Elements_Axis_Label
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * 设置文字旋转角度
     * 注意：这个函数对中文不支持，显示不出来
     *
     * @param  integer $rotate
     * @return OFC_Elements_Axis_Label
     */
    public function setRotate($rotate = 90)
    {
        $this->rotate = $rotate;
        return $this;
    }

    /**
     * 设置文字方向为垂直，这里也相当于setRotate(90)
     *
     * @return OFC_Elements_Axis_Label
     */
    public function setVertical()
    {
        return $this->setRotate('vertical');
    }

    /**
     * 设置显示状态，这个经过我的测试似乎目前没啥作用
     *
     * @param  boolean $v
     * @return OFC_Elements_Axis_Label
     */
    public function setVisible($v = true)
    {
        $this->visible = $v;
        return $this;
    }

    /**
     * 设置标签
     *
     * @param  array
     * @return OFC_Elements_Axis_Label
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;
        return $this;
    }

    /**
     * 设置坐标刻度
     *
     * @param  integer $steps
     * @return OFC_Elements_Axis_Label
     */
    public function setSteps($steps = 1)
    {
        $this->steps = $steps;
        return $this;
    }
}