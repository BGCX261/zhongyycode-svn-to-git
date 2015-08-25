<?php
/**
 * 手绘式柱状图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Sketch extends OFC_Charts_Bar
{
    /**
     * 构造函数
     *
     * @param string $colour 柱体颜色
     * @param string $outlineColour 边框颜色
     * @param integer $funFactor 草图生成因子，值越大草图画得越潦草
     */
    public function __construct($colour = null, $outlineColour = null, $funFactor = null)
    {
        parent::__construct();
        $this->type = 'bar_sketch';

        if (!empty($colour)) {
            $this->setColour($colour);
        }

        if (!empty($outlineColour)) {
            $this->setOutlineColour($outlineColour);
        }

        if (!empty($funFactor)) {
            $this->setOffset($funFactor);
        }
    }

    /**
     * 设置外边框颜色
     *
     * @param  string $outlineColour
     * @return OFC_Charts_Bar_Sketch
     */
    public function setOutlineColour($outlineColour)
    {
        $this->{'outline-colour'} = $outlineColour;
        return $this;
    }

    /**
     * 设置草图生成因子
     *
     * @param  integer $o
     * @return OFC_Charts_Bar_Sketch
     */
    public function setOffset($o)
    {
        $this->offset = $o;
        return $this;
    }
}