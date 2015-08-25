<?php
/**
 * ACL Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class AclModel extends AclModelAbstract
{


    /**
     * 对指定的角色执行 ACL 初始化
     * @param  integer  $roleId
     */
    public function initRole($roleId)
    {
        $rules = $this->db->select()
            ->from(
                array('rule' => 'acl_rule'),
                array('rule_id')
            )
            ->join(
                array('res' => 'acl_resource'),
                'rule.res_name=res.res_name',
                array()
            )
            ->where('res.mod_name=?', $this->_modName)
            ->fetchAll();
        if (!empty($rules)) {
            $data = array();
            foreach ($rules as $rule) {
                $data[] = array(
                    'rule_id' => $rule['rule_id'],
                    'role_id' => (integer) $roleId,
                );
            }
            $this->db->insert('acl', $data);
        }
    }

    /**
     * 获取当前角色被允许的 ACL 权限
     * @param  integer  $roleId
     */
    public function getRoleAllowRule($roleId)
    {
        $select = $this->db->select()
            ->from('acl', 'rule_id')
            ->where('role_id=?', $roleId)
            ->where('permit=1');
        $rows = $this->db->fetchAll($select);
        $result = array();
        foreach ($rows as $row) {
            $result[] = $row['rule_id'];
        }
        return $result;
    }

    /**
     * 指派权限
     * @param  integer  $roleId
     * @param  mixed    $rules
     * @param  boolean  $resetOther
     */
    public function assign($roleId, $rules, $resetOther = true)
    {
        if (!is_array($rules)) {
            $rules = array($rules);
        }

        if (empty($rules)) {
            return ;
        }

        $where = $this->db->quoteInto('role_id=?', (integer) $roleId);
        if ($resetOther) {
            $set = array('permit' => 0);
            $this->db->update('acl', $set, $where);
        }

        $where .= ' AND ' . $this->db->quoteInto('rule_id IN (?)', $rules);
        $set = array('permit' => 1);
        $this->db->update('acl', $set, $where);


    }

}