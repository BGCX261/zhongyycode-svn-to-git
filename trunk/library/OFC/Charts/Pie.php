<?php
/**
 * 饼形图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Pie extends OFC_Charts_Base
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->type = 'pie';
    }

    /**
     * 设置饼形图各块的颜色
     *
     * @param  array $colours
     * @return OFC_Charts_Pie
     */
    public function setColours(array $colours)
    {
        $this->colours = $colours;
        return $this;
    }

    /**
     * 设置是否显示动画
     *
     * @param  boolean $v
     * @return OFC_Charts_Pie
     */
    public function setAnimate($v = true)
    {
        $this->animate = $v;
        return $this;
    }

    /**
     * 设置初始化时的角度
     *
     * @param  float $angle
     * @return OFC_Charts_Pie
     */
    public function setStartAngle($angle = 0)
    {
        $this->{'start-angle'} = $angle;
        return $this;
    }

    /**
     * 设置边框大小，经测试目前暂时不起任何作用
     *
     * @param  integer $border
     * @return OFC_Charts_Pie
     */
    public function setBorder($border = 1)
    {
        $this->border = $border;
        return $this;
    }

    /**
     * 设置透明度，0～1之间的值
     *
     * @param  float $alpha
     * @return OFC_Charts_Pie
     */
    public function setAlpha($alpha = 0.6)
    {
        $this->alpha = $alpha;
        return $this;
    }
}
