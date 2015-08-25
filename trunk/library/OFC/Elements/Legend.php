<?php
/**
 * 坐标轴说明文字
 *
 * @author      hyperjiang <hyperjiang@gmail.com>
 * @copyright   Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class OFC_Elements_Legend extends OFC_Elements_Base
{
    /**
     * 文本内容
     *
     * @var string
     */
    public $text = '';

    /**
     * 样式
     *
     * @var string
     */
    public $style = '{font-size: 16px; color:#7E97A6;}';

    /**
     * 构造函数
     *
     * @param string $text
     */
    public function __construct($text = '')
    {
        parent::__construct();
        $this->text = $text;
    }
}