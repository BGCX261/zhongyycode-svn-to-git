<?php
/**
 * 分页处理
 *
 * @package    classes
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('LIB_DIR') && die('Access Deny!');

class YUN_Paginator
{
    /**
     * 平均每页显示记录数
     *
     * @var integer
     */
    private $_itemsPerPage = 20;

    /**
     * 当前页页码
     *
     * @var integer
     */
    private $_currentPage = null;

    /**
     * 记录总数
     *
     * @var integer
     */
    private $_itemsCount = null;

    /**
     * 当前页记录
     *
     * @var integer
     */
    private $_currentItems = null;

    /**
     * 通过工厂方法快速获取 YUN_Paginator 对象
     *
     * @param  array  $data
     * @param  integer        $perPage
     * @param  string         $uriSegment
     * @return YUN_Paginator
     */
    public static  function factory($data, Zend_Controller_Request_Http $request, $perPage = 20, $uriSegment = 'page')
    {
        $paginator = Zend_Paginator::factory($data);
        $paginator->setItemCountPerPage($perPage); // 每页显示数
        $paginator->setCurrentPageNumber($request->getParam($uriSegment));  // 设置当前页
        return $paginator;
    }

    /**
     * 获取URI获取当前页页码的关键字
     *
     * @return string
     */
    public function getUriSegment()
    {
        return $this->_uriSegment;
    }

    /**
     * 设置平均每页显示记录数
     *
     * @param  integer  $perPage
     * @return EGP_Paginator
     */
    public function setItemsPerPage($perPage)
    {
        $this->_itemsPerPage = $perPage < 1 ? 1 : (integer) $perPage;
        return $this;
    }

    /**
     * 获取平均每页显示记录数
     *
     * @return integer
     */
    public function getItemsPerPage()
    {
        return $this->_itemsPerPage;
    }

    /**
     * 设置当前页页码
     *
     * @param  integer  $currentPage
     * @return EGP_Paginator
     */
    public function setCurrentPage($currentPage)
    {
        $this->_currentPage = $currentPage < 1 ? 1 : (integer) $currentPage;
        return $this;
    }

    /**
     * 获取当前页页码
     *
     * @return integer
     */
    public function getCurrentPage()
    {
        if (null === $this->_currentPage) {
            $request = new Zend_Controller_Request_Http();
            $currentPage = $request->getQuery($this->getUriSegment());
            $this->setCurrentPage($currentPage);
        }
         return $this->_currentPage;
    }

}