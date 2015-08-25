<?php
/**
 * 角色 Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class RoleModel extends AclModelAbstract
{
    /**
     * 获取到角色列表
     *
     * @return EGP_Db_Select
     */
    public function getAll()
    {
        $select = $this->db->select()
            ->from(array('role' => 'acl_role'))
            ->join('acl_module', 'role.mod_name=acl_module.mod_name', array())
            ->where('role.mod_name=?', $this->_modName)
            ->order('role.role_level ASC');
        return $this->db->fetchAll($select);
    }

    /**
     * 查询角色 ID 是否存在
     * @param  string  $roleName
     * @param  integer $roleId
     */
    public function idExists($roleId)
    {
        $select = $this->db->select()
            ->from(array('role' => 'acl_role'))
            ->join('acl_module', 'role.mod_name=acl_module.mod_name', array())
            ->where('role.mod_name=?', $this->_modName)
            ->where('role.role_id=?', (integer) $roleId);
        $row = $this->db->fetchRow($select);
        return empty($row) ? false : true;
    }
}