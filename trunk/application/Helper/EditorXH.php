<?php
/**
 * Editor_XH (View Helper)
 *
 * @package    helper
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('LIB_DIR') && die('Access Deny!');

class Helper_EditorXH extends Zend_View_Helper_Abstract
{
    /**
     * 标识是否已经载入 JS 文件
     * @var boolean
     */
    protected static $_isLoadedJS = false;

    /**
     * 标识是否已经载入 UBB 插件
     * @var boolean
     */
    protected static $_isLoadedUBB = false;

    /**
     * 是否使用UBB
     * @var boolean
     */
    protected $_useUBB = false;

    /**
     * 风格样式
     * @var string
     */
    protected $_style = 'full'; // full(完全),simple(简单),mini(迷你)

    /**
     * 编辑器根路径
     * @var string
     */
    protected $_basePath = '/editors/xheditor/';

    /**
     * 编辑器配置
     * @see http://code.google.com/p/xheditor/wiki/Help
     * @var array
     */
    protected $_config = array(
        'name'          => 'editor_xh',
        'value'         => '请输入内容',
        'tools'         => 'custom', //工具栏
        'skin'          => 'default', //皮肤
        'clearScript'   => true, //清理JS代码
        'clearStyle'    => true, //清理style样式
        'showBlocktag'  => false, //显示段落标签
        'width'         => 500, //编辑器宽度
        'height'        => 100, //编辑器高度
        'loadCSS'       => '', //加载样式
        'fullscreen'    => false, //全屏显示
        'sourceMode'    => false, //默认源代码模式
        'forcePtag'     => true, //强制使用P标签
        'keepValue'     => true, //自动保存src和href属性值
        'uploadUrl'     => '', //文件上传接收URL
        'uploadExt'     => "jpg,jpeg,gif,png,bmp" //上传前限制本地文件扩展名
    );

    /**
     * 设置编辑器高度
     * @param  string  $width
     * @return EGP_View_Helper_Editor_XH
     */
    public function setWidth($width)
    {
        $this->_width = $this->_config['width'] = $width;
        return $this;
    }

    /**
     * 设置编辑器高度
     *
     * @param  string  $height
     * @return EGP_View_Helper_Editor_XH
     */
    public function setHeight($height)
    {
        $this->_height = $this->_config['height'] = $height;
        return $this;
    }

    /**
     * 设置编辑器显示风格/样式
     * @param  string  $style
     * @return EGP_View_Helper_Editor_XH
     */
    public function setStyle($style)
    {
        $this->_style = $this->_config['tools'] = (string) $style;
        return $this;
    }

    /**
     * 设置使用UBB
     * @param  boolean $flag
     * @return EGP_View_Helper_Editor_XH
     */
    public function setUBB($flag = true)
    {
        $this->_useUBB = (boolean) $flag;
        return $this;
    }

    /**
     * 设定编辑器配置
     * @param  array  $config
     * @return EGP_View_Helper_Editor_XH
     */
    public function setConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $this->_config[$key] = $value;
        }
        return $this;
    }

    /**
     * 输出 HTML 代码
     * @return string
     */
    public function EditorXH(array $arr = array())
    {
        !empty($arr) && $this->setConfig($arr);
        return $this;
    }

    /**
     * 生成数据
     *
     * @return unknown
     */
    public function __toString()
    {
        $configStr = json_encode($this->_config);
        if ($this->_useUBB) {
            $configStr = substr($configStr, 0, -1) . ',beforeSetSource:ubb2html,beforeGetSource:html2ubb}';
        }

        $this->configStr = $configStr;
        $html = <<<EOF
<textarea name="{$this->_config['name']}" style="display:none">{$this->_config['value']}</textarea>
<script type="text/javascript" language="javascript">
$().ready(function() {
    $('textarea[name={$this->_config['name']}]').xheditor(true, {$this->configStr});
});
</script>
EOF;
        $js = '';
        if (self::$_isLoadedJS === false) {
            $js = "<script type='text/javascript' language='javascript' src='{$this->_basePath}xheditor.js'></script>";
            self::$_isLoadedJS = true;
        }
        if ($this->_useUBB && self::$_isLoadedUBB === false) {
            $js .= "<script type='text/javascript' language='javascript' src='{$this->_basePath}xheditor_plugins/ubb.js'></script>";
            self::$_isLoadedUBB = true;
        }
        return $js . $html;
    }
}