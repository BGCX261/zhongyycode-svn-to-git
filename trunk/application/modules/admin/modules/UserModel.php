<?php
/**
 * 用户管理
 *
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('APP_DIR') && die('Access Deny!');

class UserModel extends YUN_Abstract
{
    /**
     * 查询用户基本信息
     *
     * @param  string  $where
     * @return EGP_Db_Select
     */
    public function infoSql($where)
    {
        return $this->db->select()
            ->from('user')
            ->where($where);
    }


    /**
     * 分组获取角色列表
     * @return array
     */
    public function getRolesGroup()
    {
        $select = $this->db->select()
            ->from(array('role' => 'acl_role'))
            ->join('acl_module', 'role.mod_name=acl_module.mod_name', array())
            ->order('role.mod_name ASC')
            ->order('role.is_guest ASC')
            ->order('role.role_level ASC')
            ->where('role.is_guest=0');
        $rows = $this->db->fetchAll($select);

        $rolesGroup = array();
        foreach ($rows as $row) {
            $rolesGroup[$row['mod_name']][] = array(
                'role_id'    => $row['role_id'],
                'role_name'  => $row['role_name'],
                'role_desc'  => $row['role_desc'],
                'is_default' => $row['is_default'],
            );
        }
        return $rolesGroup;
    }

    /**
     * 获取用户角色列表
     * @return array
     */
    public function getUserRoles($uid)
    {
        $select = $this->db->select()
            ->from(
                array('urole' => 'user_role'),
                array()
            )
            ->join(
                array('role' => 'acl_role'),
                'role.role_id=urole.role_id'
            )
            ->join('acl_module', 'role.mod_name=acl_module.mod_name', array())
            ->order('role.mod_name ASC')
            ->order('role.is_guest ASC')
            ->where('role.is_guest=0')
            ->where('urole.uid=?', $uid);
        $rows = $this->db->fetchAll($select);

        $roles = array();
        foreach ($rows as $row) {
            $roles[$row['mod_name']] = array(
                'role_id'   => $row['role_id'],
                'role_name' => $row['role_name'],
                'role_desc' => $row['role_desc'],
                'is_default' => $row['is_default'],
            );
        }

        return $roles;
    }
    /**
     * 获取指定用户所有信息
     * @param  integer $uid
     * @return array
     */
    public function getInfo($uid)
    {
        $select = $this->db->select()
                ->from('user')
                ->where('user.uid = ?', $uid)
                ->limit(1);
         return  $this->db->fetchRow($select);
    }

    /**
     * 修改资料
     * @param string $uid
     * @param array $info
     */
    public function updateInfo($uid, $data)
    {
        $info = array();
        $validator = new YUN_Validator();

        $where = $this->db->quoteInto('uid=?', $uid);
        $user = $this->db->fetchRow($this->infoSql($where));
        if (empty($user)) {
            throw new Zend_Exception("用户ID '{$uid}' 不存在");
        }

        if (!empty($data['password'])) { //密码有变动
            $validator->check(
                $data['password'],
                array(
                    array('StringLength' => array(6, 50), '密码必须介于 6~50 个字符之间'),
                )
            )
            ->check(
                $data['confirmPwd'],
                array(
                    array('NotEmpty', '确认密码不允许为空'),
                    array('Equal' => $data['password'], '两次输入的密码不一致')
                )
            );

            $info['password'] = md5(md5($data['password']));
            $info['salt'] = '';
        }

        //数据校验
        if (!$validator->isValid()) {
            throw new Zend_Exception($validator->getMessage());
        }

        if (!empty($info)) {
            $where = $this->db->quoteInto('uid=?', $uid);
            $this->db->update('user', $info, $where);
        }
    }
}