<? defined('SYSPATH') or die('No direct script access.');
/**
 * 用户角色
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-1
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_User_Role extends ORM
{
    protected $_primary_key = null;


    /**
     * 分组获取角色列表
     *
     * @return array
     */
    public function getRolesGroup()
    {
        $rows = DB::select()
            ->from(array('acl_roles', 'role'))
            ->join('modules')
            ->on('modules.mod_name', '=', 'role.mod_name')
            ->where('role.is_guest', '=', 0)
            ->order_by('role.mod_name', 'ASC')
            ->order_by('role.is_guest', 'ASC')
            ->order_by('role.role_level', 'ASC')
            ->execute()->as_array();

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
     *
     * @return array
     */
    public function getUserRoles($uid)
    {
        $rows = DB::select()
            ->from(array('user_roles','urole'))
            ->join(array('acl_roles','role'))
            ->on('urole.role_id', '=', 'role.role_id')
            ->join('modules')
            ->on('modules.mod_name', '=', 'role.mod_name')
            ->where('role.is_guest', '=', 0)
            ->where('urole.uid', '=', $uid)
            ->order_by('role.mod_name', 'ASC')
            ->order_by('role.is_guest', 'ASC')
            ->execute()->as_array();

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
}