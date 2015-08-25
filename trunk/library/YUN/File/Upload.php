<?php
/**
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

!defined('LIB_DIR') && die('Access Deny!');

/**
 * 文件上传类
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_File_Upload extends YUN_File_Abstract
{

    /**
     * 上传配置
     *
     * @var array
     */
    protected $_config = array(
        'allowExtension' => array('jpg', 'jpeg', 'bmp', 'wbmp', 'gif', 'png',
                                  'rar', 'zip', 'gz', '7z', 'bzip'),
        'maxSize'  => 0, //KB
        'savePath' => './uploads',
        'rename'   => true,
    );

    /**
     * 错误信息
     *
     * @var string
     */
    protected $_message = null;

    /**
     * 上传结果
     *
     * @var array
     */
    protected $_result = array();

    /**
     * 构造方法
     *
     * @param  mixed  $config
     * @throws Exception
     */
    public function __construct($config = array())
    {
        if ($config instanceof YUN_ArrayObject) {
            $config = $config->toArray();
        }
        if (!is_array($config)) {
            throw new Zend_Exception('上传配置必须是一个有效的数组');
        }
        $this->setConfig($config);
    }

    /**
     * 设置上传配置
     *
     * @param  array  $config
     * @return YUN_File_Upload
     * @throws Zend_Exception
     */
    public function setConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (!method_exists($this, $method)) {
                throw new Zend_Exception("参数选项 '$key' 不存在");
            }
            $this->$method($value);
        }
        return $this;
    }

    /**
     * 设置允许上传的文件扩展名
     *
     * @param  array  $extensions
     * @return YUN_File_Upload
     * @throws Zend_Exception
     */
    public function setAllowExtension(array $extensions)
    {
        foreach ($extensions as &$extension) {
            if (!preg_match('/^[\w]+$/', (string) $extension)) {
                throw new Zend_Exception("非法的文件扩展名 $extension");
            }
            $extension = strtolower(trim($extension));
        }

        $this->_config['allowExtension'] = $extensions;
        return $this;
    }

    /**
     * 设置允许上传的文件最大值 (0：无限制，单位：kb)
     *
     * @param  integer  $size
     * @return YUN_File_Upload
     * @throws Zend_Exception
     */
    public function setMaxSize($size)
    {
        if ($size < 0) {
            throw new Zend_Exception('上传文件限制的值不能小于 0');
        }

        $this->_config['maxSize'] = (integer) $size;

        return $this;
    }

    /**
     * 设置文件保存路径
     *
     * @param  string  $path
     * @return YUN_File_Upload
     * @throws Zend_Exception
     */
    public function setSavePath($path)
    {
        $mkpath = YUN_Io::mkdir($path);
        if ($mkpath === false) {
            throw new Zend_Exception("无法创建文件保存路径 '$path'");
        }

        $this->_config['savePath'] = rtrim($mkpath, '\\/');
        return $this;
    }

    /**
     * 设置是否对文件进行重命名
     *
     * @param  boolean  $flag
     * @return YUN_File_Upload
     */
    public function setRename($flag)
    {
        $this->_config['rename'] = (boolean) $flag;
        return $this;
    }

    /**
     * 验证是否 POST 的文件上传数据
     *
     * @param  array  $data
     * @return boolean
     */
    public function isPostFile(array $data)
    {
        return isset($data['name']) && isset($data['tmp_name']) &&
               isset($data['type']) && isset($data['size']);
    }

    /**
     * 判断是否被允许上传的文件扩展名
     *
     * @param  string  $filename
     * @return boolean
     */
    public function isAllowExtension($filename)
    {
        return in_array($this->getExtension($filename), $this->_config['allowExtension']);
    }

    /**
     * 是否允许上传的文件大小
     *
     * @param  integer  $size
     * @return boolean
     */
    public function isAllowSize($size)
    {
        return $this->_config['maxSize'] == 0 || ($this->_config['maxSize'] * 1024) < $size;
    }

    /**
     * 保存上传的文件
     *
     * @example YUN_File_Upload::save($_FILES['fieldname']);
     *
     * @param  array   $data      POST 的文件上传数据
     * @param  string  $saveName
     * @param  string  $savePath
     * @return boolean
     */
    public function save(array $data, $saveName = null, $savePath = null)
    {
        if (!$this->isPostFile($data)) {
            $this->_message = '无效的 POST 数据';
            return false;
        }

        if (isset($data['error']) && $data['error'] != 0) {
            $this->_message = $this->getError($data['error']);
            return false;
        }

        if (!$this->isAllowExtension($data['name'])) {
            $this->_message = '禁止上传该类型的文件';
            return false;
        }

        if (!$this->isAllowSize($data['size'])) {
            $this->_message = "文件大小超出服务器限定的值 ({$this->_config['maxSize']} Kb)";
            return false;
        }

        empty($savePath) && $savePath = $this->_config['savePath'];
        $mkpath = YUN_Io::mkdir($savePath);
        if ($mkpath === false) {
            $this->_message = "无法创建文件上传目录 '$savePath'";
            return false;
        }

        $extension = $this->getExtension($data['name']);
        if (empty($saveName)) {
            $saveName = $this->_config['rename'] ?
                        str_replace('.', '', microtime(true)) . ".$extension" :
                        $data['name'];
        } else {
            $saveName = strtolower($saveName); // 兼容 win 平台
        }

        $saveFilename = YUN_Io::strip("$savePath/$saveName");
        if (!@move_uploaded_file($data['tmp_name'], $saveFilename)) {
            $this->_message = '无法从临时目录复制上传文件';
            return false;
        }

        $this->_result = array(
            'filename'      => $data['name'],
            'filesize'      => $data['size'],
            'filetype'      => $data['type'],
            'extension'     => $extension,
            'savename'      => $saveFilename,
        );

        return true;
    }

    /**
     * 获取文件上传的结果
     *
     * @return array
     */
    public function getResult()
    {
        return $this->_result;
    }

    /**
     * 根据上传错误代码获取相应的文件信息
     *
     * @param  integer  $errno
     * @return string
     */
    public function getError($errno)
    {
        switch ($errno) {
            case 1:  return '上传的文件大小超出服务器限定的值';
            case 2:  return '文件大小超出 HTML 控件限定的值';
            case 3:  return '文件只有部分被上传';
            case 4:  return '没有文件被上传';
            case 5:  return '上传失败，原因未知';
            case 6:  return '找不到临时活页夹';
            case 7:  return '文件写入失败';
            default: return '未知错误';
        }
    }

    /**
     * 获取文件上传的错误信息
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

}