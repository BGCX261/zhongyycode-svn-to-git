<?php
/**
 * X轴坐标
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class OFC_Elements_Axis_X extends OFC_Elements_Axis
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 设置坐标刻度高度
     *
     * @param  integer $height
     * @return OFC_Elements_Axis_X
     */
    public function setTickHeight($height = 3)
    {
        $this->{'tick-height'} = $height;
        return $this;
    }

    /**
     * 设置3d显示效果
     *
     * @param  integer $val 3d坐标的高度
     * @return OFC_Elements_Axis_X
     */
    public function set3d($val = 5)
    {
        $this->{'3d'} = $val;
        return $this;
    }

    /**
     * 设置标签
     *
     * @param  mix $labels
     * @return OFC_Elements_Axis_X
     */
    public function setLabels($labels)
    {
        if ($labels instanceof OFC_Elements_Axis_Label) {
            $this->labels = $labels;
        } else if (is_array($labels)) {
            $this->labels = new OFC_Elements_Axis_Label($labels);
            if (isset($this->steps)) {
                $this->labels->setSteps($this->steps);
            }
        }
        return $this;
    }
}