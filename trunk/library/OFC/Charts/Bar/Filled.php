<?php
/**
 * 带边框的柱状图
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Charts_Bar_Filled extends OFC_Charts_Bar
{
    /**
     * 构造函数
     *
     * @param string $colour 柱体颜色
     * @param string $outlineColour 边框颜色
     */
    public function __construct($colour = null, $outlineColour = null)
    {
        parent::__construct();
        $this->type = 'bar_filled';

        if (!empty($colour)) {
            $this->setColour($colour);
        }

        if (!empty($outlineColour)) {
            $this->setOutlineColour($outlineColour);
        }
    }

    /**
     * 设置外边框颜色
     *
     * @param  string $outlineColour
     * @return OFC_Charts_Bar_Filled
     */
    public function setOutlineColour($outlineColour)
    {
        $this->{'outline-colour'} = $outlineColour;
        return $this;
    }
}