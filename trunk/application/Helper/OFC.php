<?php

!defined('LIB_DIR') && die('Access Deny!');

/**
 * Open flash chart helper
 *
 * @package    helper
 * @author     hyperjiang <hyperjiang@gmail.com>
 * @copyright  Copyright (c) 2008-2009 (http://mydraft.cn/)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Helper_OFC extends Zend_View_Helper_Abstract
{
    /**
     * 标识是否已经载入 JS 文件
     *
     * @var boolean
     */
    protected static $_isLoadedJS = false;

    /**
     * Flash路径
     *
     * @var string
     */
    protected $_flash = '/flash/open-flash-chart.swf';

    /**
     * js路径
     *
     * @var string
     */
    protected $_js = '/scripts/swfobject.js';

    /**
     * 显示图形的层的ID
     *
     * @var string
     */
    protected $_id = null;

    /**
     * 显示宽度
     *
     * @var string
     */
    protected $_width = '99%';

    /**
     * 显示高度
     *
     * @var string
     */
    protected $_height = '300';

    /**
     * 图形数据的来源地址
     *
     * @var string
     */
    protected $_data = '';

    /**
     * 初始化
     *
     * @param  array $params [width, height, id, data]，其中data是必设项
     * @return EGP_View_Helper_OFC
     */
    public function OFC(array $params)
    {
        if (empty($params['data'])) {
            throw new EGP_Exception('必须指定数据来源');
        }
        $this->_data = $params['data'];

        if (!empty($params['width'])) {
            $this->_width = $params['width'];
        }
        if (!empty($params['height'])) {
            $this->_height = $params['height'];
        }

        if (!empty($params['id'])) {
            $this->_id = $params['id'];
        } else {
            $this->_id = uniqid('chart_');
        }
        return $this;
    }

    /**
     * 输出 HTML 代码
     *
     * @return string
     */
    public function __toString()
    {
        $html = <<<EOF
<div id="{$this->_id}"></div>
<script type="text/javascript">
var params = {};
var attributes = {};
var flashvars = {'data-file':"{$this->_data}"};
swfobject.embedSWF("{$this->_flash}", "{$this->_id}", "{$this->_width}", "{$this->_height}", "8.0.0", false, flashvars, params, attributes);
</script>
EOF;
        if (self::$_isLoadedJS === false) {
            $html = <<<EOF
<script type="text/javascript" language="javascript" src="{$this->_js}"></script>
$html
EOF;
            self::$_isLoadedJS = true;
        }
        return $html;
    }
}