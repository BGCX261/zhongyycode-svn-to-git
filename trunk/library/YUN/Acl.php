<?php
/**
 * acl
 *
 * @package    classes
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('LIB_DIR') && die('Access Deny!');

class YUN_Acl extends YUN_Abstract
{

    /**
     * acl
     *
     * @var zend_Acl
     */
    protected $acl = null;

    /**
     * 设置ACL
     *
     */
    public function setAcl()
    {
        //定义角色
        $acl = new Zend_Acl();
        $roles = $this->getRoles();
        foreach ($roles as $value) {
            $acl->addRole(new Zend_Acl_Role($value['mod_name'] . '.' . $value['role_name']));
        }

        //添加资源
        $resources = $this->getResources();
        foreach ($resources as $value) {
            $acl->add(new Zend_Acl_Resource($value['mod_name'] . '.' . $value['res_name']));
        }

        foreach ($this->_getRules() as $rule) {
                $roleName = "{$rule['mod_name']}.{$rule['role_name']}";
                $resName  = "{$rule['mod_name']}.{$rule['res_name']}";
                $method = ($rule['permit'] == 1) ? 'allow' : 'deny';
                $acl->$method($roleName, $resName, $rule['priv_name']);
        }
        return $acl;
    }

    /**
     * 取出所有角色
     *
     * @return array
     */
    public function getRoles()
    {
        $result = $this->cache->load('acl_role');
        if (!$result) {
            $select = $this->db->select()->from('acl_role', array('mod_name', 'role_name'));
            $result = $this->db->fetchAll($select);
            $this->cache->save($result, 'acl_role');
        }
        return $result;
    }

    /**
     * 获取所有资源
     *
     * @return array
     */
    public function getResources()
    {
        $result = $this->cache->load('acl_resource');
        if (!$result) {
            $select = $this->db->select()
                ->from('acl_resource', array('mod_name', 'res_name'));
            $result = $this->db->fetchAll($select);
            $this->cache->save($result, 'acl_resource');
        }
        return $result;
    }



    /**
     * 获取所有规则
     *
     * @return array
     */
    protected function _getRules()
    {
        $result = $this->cache->load('acl_all_rule');
        if (!$result) {
            $result = $this->db->fetchAll(
                $this->db->select()
                    ->from('acl', 'permit')
                    ->join(
                        array('rule' => 'acl_rule'),
                        'acl.rule_id=rule.rule_id',
                        array('res_name', 'priv_name')
                    )
                    ->join(
                        array('res' => 'acl_resource'),
                        'rule.res_name=res.res_name',
                        array('mod_name')
                    )
                    ->join(
                        array('role' => 'acl_role'),
                        'acl.role_id=role.role_id AND res.mod_name=role.mod_name',
                        array('role_name')
                    )
                );

            $result = $this->cache->save($result, 'acl_all_rule');
        }

        return $result;
    }



}