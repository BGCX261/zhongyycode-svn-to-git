<?php
/**
 * 规则 Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('APP_DIR') && die('Access Deny!');

class RuleModel extends AclModelAbstract
{
    /**
     * 分组获取权限规则
     * @return array
     */
    public function getRuleGroup()
    {
        $select = $this->db->select()
            ->from(
                array('rule' => 'acl_rule'),
                array('rule_id')
            )
            ->join(
                array('res' => 'acl_resource'),
                'rule.res_name=res.res_name',
                array('mod_name', 'res_name', 'res_desc')
            )
            ->join(
                array('priv' => 'acl_privilege'),
                'rule.priv_name=priv.priv_name',
                array('priv_name', 'priv_desc')
            )
            ->where('res.mod_name=?', $this->_modName)
            ->order('res.res_name ASC')
            ->order('priv.priv_name ASC');
        $rows = $this->db->fetchAll($select);
        $group = array();
        foreach ($rows as $row) {
            $group['resource'][$row['res_name']] = $row['res_desc'];
            $group['rule'][$row['res_name']][$row['priv_name']] = $row['rule_id'];
            $group['privilege'][$row['priv_name']] = $row['priv_desc'];
        }

        return $group;
    }

    /**
     * 获取所有的资源列表
     * @return array
     */
    public function getResourceAll()
    {
        $select = $this->db->select()
            ->from(
                array('res' => 'acl_resource'),
                array('res_name', 'res_desc')
            )
            ->where('res.mod_name=?', $this->_modName);
       $rows = $this->db->fetchAll($select);
       $resources = array();
       foreach ($rows as $row) {
           $resources[$row['res_name']] = $row['res_desc'];
       }
       return $resources;
    }

    /**
     * 查询资源是否已经存在
     * @param  string  $resName
     * @return boolean
     */
    public function resExists($resName)
    {
        $select = $this->db->select()
            ->from('acl_resource')
            ->where('res_name=?', $resName)
            ->where('mod_name=?', $this->_modName);

        $row = $this->db->fetchRow($select);
        return empty($row) ? false : true;
    }

    /**
     * 添加新的规则 (批量)
     * @param array $data
     */
    public function add($data)
    {
        if($this->resExists($data['res_name'])) {
           throw new Zend_Exception("资源名称已经存在 '{$data['res_name']}'");
        }
        $insert = array(
            'mod_name' => $this->_modName,
            'res_name' => $data['res_name'],
            'res_desc' => $data['res_desc'],
        );

        if(empty($data['privileges'])) {
           throw new Zend_Exception("至少需要选择一个权限");
        }
        $this->db->insert('acl_resource', $insert);
        foreach ($data['privileges'] as $privName) {

            $this->_add($data['res_name'], $privName);
        }
    }

    /**
     * 添加规则
     * @param  string  $resName
     * @param  string  $privName
     */
    protected function _add($resName, $privName)
    {
        $data = array(
            'res_name' => $resName,
            'priv_name' => $privName,
        );
        $this->db->insert('acl_rule', $data);

        $ruleId = $this->db->lastInsertId();
        $roleModel = new RoleModel($this->_modName);
        $roleList = $roleModel->getAll();

        $data = array();
        foreach ($roleList as $role) {
            $data = array(
                'rule_id' => $ruleId,
                'role_id' => $role['role_id'],
                'permit'  => 0
            );
            $this->db->insert('acl', $data);
        }
    }
    /**
     * 追加权限
     * @param  string  $resName
     * @param  string  $privName
     * @throws EGP_Exception
     */
    public function append($resName, $privName)
    {
        if (!$this->resExists($resName)) {
            throw new Zend_Exception("资源 '$resName' 不存在或者已经被删除");
        }

        $privilege = new PrivilegeModel();
        if (!$privilege->exists($privName)) {
            throw new Zend_Exception("权限 '$privName' 不存在或者已经被删除");
        }

        if ($this->resHasPriv($resName, $privName)) {
            throw new Zend_Exception("资源 '$resName' 下已经存在 '$privName' 这个权限了");
        }

        $this->_add($resName, $privName);


    }

    /**
     * 查询规则是否已经存在
     * @param  string  $resName
     * @param  string  $privName
     */
    public function resHasPriv($resName, $privName)
    {
        $select = $this->db->select()
            ->from(
                array('rule' => 'acl_rule'),
                array('COUNT(*)')
            )
            ->join(
                array('res' => 'acl_resource'),
                'rule.res_name=res.res_name',
                array()
            )
            ->where('res.mod_name=?', $this->_modName)
            ->where('rule.res_name=?', $resName)
            ->where('rule.priv_name=?', $privName);
        $count = $this->db->fetchOne($select);
        return $count > 0;
    }

    /**
     * 删除规则
     * @param  array  $rules
     */
    public function del($rules)
    {
        if (!is_array($rules)) {
            $rules = array($rules);
        }

        $where = $this->db->quoteInto('rule_id IN (?)', $rules);
        $select = $this->db->select()
            ->distinct()
            ->from('acl_rule', 'res_name')
            ->where($where);
        $checkRes = $this->db->fetchAll($select);

        $this->db->delete('acl_rule', $where); //删除规则
        $this->db->delete('acl', $where); //删除访问控制表

        foreach ($checkRes as $resName) {
            $this->resClean($resName);
        }
    }

    /**
     * 清除没有被规则使用的资源
     * @param  string  $resName
     */
    public function resClean($resName)
    {
        $select = $this->db->select()
            ->from(
                array('rule' => 'acl_rule'),
                array('COUNT(*)')
            )
            ->join(
                array('res' => 'acl_resource'),
                'rule.res_name=res.res_name',
                array()
            )
            ->where('res.res_name=?', $resName)
            ->where('res.mod_name=?', $this->_modName);
        $count =$this->db->fetchOne($select);
        if ($count == 0) {
            $where = array(
                $this->db->quoteInto('res_name=?', $resName),
                $this->db->quoteInto('mod_name=?', $this->_modName),
            );
            $this->db->delete('acl_resource', $where); //删除资源
        }
    }
}