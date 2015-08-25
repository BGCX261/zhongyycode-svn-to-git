<?php
/**
 * 模块 Model
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-31
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Acl_Resource extends ORM{


    /**
     * 设置主健
     *
     */
    public $_primary_key = 'mod_name';

    /**
     * 当前模块名称
     *
     * @var string
     */
    protected $_modName = null;

    /**
     * 当前模块名称 说明
     *
     * @var string
     */
    public $modDesc = null;

    /**
     * 获取所有的资源列表
     *
     * @return array
     */
    public function getAll()
    {
       $resources = Cache::instance()->get('acl_resources');
       if (null == $resources) {
           $rows = $this->where('mod_name', '=', $this->_modName)->find_all();
           $resources = array();
           foreach ($rows as $row) {
               $resources[$row->res_name] = $row->res_desc;
           }
           Cache::instance()->set('acl_resources', $resources, 2592000);
       }
       return $resources;
    }

    /**
     * 设置所属模块
     *
     * @param  string  $modName
     * @throws EGP_Exception
     */
    public function setModule($modName)
    {
        $module = ORM::factory('module');
        if (!$module->exists($modName)) {
            throw new Exception("指定的模块名称 '$modName' 不存在");
        }
        $this->_modName = $modName;
        $this->modDesc = $module->getDesc($this->_modName);
        return $this;
    }

    /**
     * 查询资源是否已经存在
     *
     * @param  string  $resName
     * @return boolean
     */
    public function resExists($resName)
    {
        $row = $this->where('res_name', '=', $resName)->where('mod_name', '=', $this->_modName)->find();

        return empty($row->res_name) ? false : true;
    }
}