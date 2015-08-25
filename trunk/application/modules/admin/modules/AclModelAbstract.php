<?php
/**
 * ACL Model 抽像类
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

abstract class AclModelAbstract extends YUN_Abstract
{

    /**
     * 当前模块名称
     * @var string
     */
    protected $_modName = null;

    /**
     * 构造方法
     * @param  string  $module
     */
    public function __construct($module)
    {
        parent::__construct();
        $this->setModule($module);
    }

    /**
     * 设置所属模块
     * @param  string  $modName
     * @throws EGP_Exception
     */
    public function setModule($modName)
    {
        $module = new ModuleModel();
        if (!$module->exists($modName)) {
            throw new EGP_Exception("指定的模块名称 '$modName' 不存在");
        }
        $this->_modName = $modName;
        $this->_modDesc = $module->getDesc($this->_modName);
    }

    /**
     * 获取模块名称
     * @return string
     */
    public function getModName()
    {
        return $this->_modName;
    }

    /**
     * 获取模块说明
     * @return string
     */
    public function getModDesc()
    {
        return $this->_modDesc;
    }

}