<?php
/**
 * 分类
 *
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class YUN_Cate
{
    /**
     * 存储所有分类
     *
     * @var array
     */
    protected $_allCates = null;

    /**
     * DB类
     *
     * @var obj
     */
    public $db = null;

    /**
     * 构造函数
     */
    public function __construct($db){
        $this->db = $db;
    }

    /**
     * 获取指定类别的path
     *
     * @param integer $cateId 类别ID
     */
    public function getPath($cateId)
    {
        if ($cateId == 0) {
            $path = '0;';
        } else {
            $select = $this->db->select()
                ->from('category', 'path')
                ->where('cate_id = ?', $cateId);
             $path = $this->db->fetchOne($select);
        }
        return $path;
    }

    /**
     * 递归获取排序分类列表
     *
     * @param  integer $cateId 分类ID
     * @return array
     */
    public function cateList($cateId = 0)
    {
        $list = array();
        $data = $this->getAllCates();
        $childs = array();
        foreach ($data as $item) { // 获取该分类的所有子分类
            if ($item['parent_id'] == $cateId) {
                $childs[] = $item;
            }
        }
        if (!empty($childs)) { // 存在子分类
            $this->_sort($childs);
            foreach ($childs as $child) {
                $list[] = $child;
                $subList = self::cateList($child['cate_id']);
                $list = array_merge($list, $subList);
            }
        }
        return $list;
    }

    /**
     * 获取分类路径上所有节点的信息
     *
     * @param integer $cateId 分类ID
     */
    public function pathSql($cateId = 0)
    {
        if (empty($cateId)) {
            return '';
        }
        $path = $this->getPath($cateId);
        $path = substr($path, 0, strlen($path) - 1);
        $arr_id = explode(';', $path);
        $arr_id[] = $cateId;
        return $this->db->select()
                ->from('category')
                ->where('cate_id in (?)', $arr_id)
                ->order('cate_id');
    }

    /**
     * 提供给jquery插件jquery.mcdropdown.min.js使用的格式化类别树
     *
     * @param integer $cateId 分类ID
     */
    public function jqCateList($cateId = 0)
    {
        $data = $this->getAllCates();
        $childs = array();
        foreach ($data as $item) { // 获取该分类的所有子分类
            if ($item['parent_id'] == $cateId) {
                $childs[] = $item;
            }
        }

        $list = '';
        if ($childs) {
            if ($cateId > 0) {
                $list .= '<ul>';
            }
            foreach ($childs as $child) {
                $list .= '<li rel=' . $child['cate_id'] . '>';
                $list .= $child['cate_name'];
                $list .= self::jqCateList($child['cate_id']);
                $list .= '</li>';
            }
            if ($cateId > 0) {
                $list .= '</ul>';
            }
        }
        return $list;
    }

   /**
     * 获取所有分类
     *
     * @return array
     */
    public function getAllCates()
    {
        if (!empty($this->_allCates)) {
            return $this->_allCates;
        }
        $select = $this->db->select()->from('category', '*');

       $data = $this->db->fetchAll($select);

        foreach ($data as $node) {
            $this->_allCates[$node['cate_id']] = $node;
        }
        return $this->_allCates;
    }

   /**
     * 添加类别
     *
     * @param array $data 类别信息数组
     */
    public function add(array $data)
    {

        $node['cate_name'] = $data['cate_name'];
        $node['parent_id'] = $data['parent_id'];
        $node['sort_order'] = $data['sort_order'];
        $node['is_show'] = $data['is_show'];
        if (!empty($data['cate_id'])) { // 导入数据需要设定id
            $node['cate_id'] = $data['cate_id'];
        }
        $this->db->insert('category', $node);
        $lastId = $this->db->lastInsertId();

        // 更新路径信息
        $path = $this->getPath($node['parent_id']) . "$lastId;";
        $where = $this->db->quoteInto('cate_id = ?', $lastId);
        $this->db->update('category', array('path' => $path), $where);

        $this->_allCates = null;
    }

    /**
     * 删除分类
     *
     * @param integer $cateId 分类ID
     */
    public function delCate($cateId) {
            // 先检查该分类是否有子分类
        $select = $this->db->select()->from('category', 'cate_id')
                    ->where('parent_id = ?', $cateId)
                    ->limit(1);
        $child = $this->db->fetchOne($select);
        if (!empty($child)) {
            throw new Regulus_Exception('该分类下有子分类，必须先删除或者转移所有子分类才能删除父分类');
        }

        $where = $this->db->quoteInto('cate_id = ?', $cateId);
        $this->db->delete('category', $where);
        $this->_allCates = null;
    }

    /**
     * 更新类别
     *
     * @param array $data 类别信息数组
     */
    public function update(array $data)
    {

        $node['cate_name'] = $data['cate_name'];
        $node['parent_id'] = $data['parent_id'];
        $node['sort_order'] = $data['sort_order'];
        $node['is_show'] = $data['is_show'];
        // 更新路径信息
        $node['path'] = $this->getPath($node['parent_id']). $data['cate_id'] . ';';

        $where = $this->db->quoteInto('cate_id = ?', $data['cate_id']);
        $this->db->update('category', $node, $where);

        if (isset($data['is_show'])) { // 继承设置显示状态
            $childs = $this->getAllChilds($data['cate_id']);
            if (!empty($childs)) {
                $where = $this->db->quoteInto('cate_id in (?)', $childs);
                $this->db->update('category', array('is_show' => $data['is_show']), $where);

            }
        }

        $this->_allCates = null;
    }

   /**
     * 获取所有子孙ID
     *
     * @param integer $cateId
     * @return array
     */
    public function getAllChilds($cateId)
    {
        $childs = array();
        $select = $this->db->select()
                ->from('category', 'cate_id')
                ->where('parent_id = ?', $cateId);
        $res = $this->db->fetchAll($select);
        foreach ($res as $r) {
            $childs[] = $r['cate_id'];
            $subChilds = self::getAllChilds($r['cate_id']);
            $childs = array_merge($childs, $subChilds);
        }
        return $childs;
    }

    /**
     * 获取单个分类信息
     *
     * @param integer $cateId 分类ID
     */
    public function infoSql($cateId)
    {
        return $this->db->select()
                ->from('category')
                ->where('cate_id = ?', $cateId)
                ->limit(1);
    }

    /**
     * 升序冒泡排序
     *
     * @param   array $data
     * @return  array
     */
    protected function _sort(&$data)
    {
        for ($i = 0; $i < count($data) - 1; $i++) {
            $no_swap = true;
            for ($j = 0; $j < count($data) - 1 - $i; $j++) {
                if ($data[$j]['sort_order'] > $data[$j + 1]['sort_order']) {
                    $tmp = $data[$j];
                    $data[$j] = $data[$j + 1];
                    $data[$j + 1] = $tmp;
                    $no_swap = false;
                }
            }
            if ($no_swap) return $data;
        }
        return $data;
    }
}
