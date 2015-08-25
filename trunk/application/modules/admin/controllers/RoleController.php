<?php
/**
 * acl角色管理
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_RoleController extends YUN_Controller_Action_Admin
{
    /**
     * RuleModel
     * @var RuleModel
     */
    public $rule = null;

    /**
     * PrivilegeModel
     * @var PrivilegeModel
     */
    public $privilege = null;

    /**
     * 初始化
     */
    public function init(){
        parent::init();
        $this->view->layout =array(
            'title' => '管理后台 - 角色管理',
        );
        $cache = Zend_Registry::get('cache');
        $cache->remove('acl_role');  // 删除缓存
    }

    /**
     * 角色列表
     */
    public function listAction()
    {
        $this->view->layout['description'] =array('<ul>
<li>角色名称必须为 2~20 英文字母+数字组成的字符</li>
<li>角色定义长度为 2~80 个字符</li>
<li>角色等级为扩展信息，用于区分等级的高低 ( 低->高 )</li>
<li>“游客” - 网站未登录用户的角色，该角色是唯一的</li>
<li>“默认” - 新用户注册后的默认角色，该角色是唯一的</li>
</ul>');
        $modName = $this->view->modName = $this->_request->getParam('mod_name');
        $select = $this->db->select()
            ->from(array('role' => 'acl_role'))
            ->join('acl_module', 'role.mod_name=acl_module.mod_name', array())
            ->where('role.mod_name=?', $modName)
            ->order('role.role_level ASC');
        $this->view->roles = $this->db->fetchAll($select);
    }

    /**
     * 添加角色组
     */
    public function addAction()
    {
        if ($this->_request->isPost()) {
            try {
                $data = array(
                    'mod_name'    => $this->_request->getPost('modName'),
                    'role_name'   => $this->_request->getPost('role_name'),
                    'role_desc'   => $this->_request->getPost('role_desc'),
                    'role_level'  => $this->_request->getPost('role_level'),
                    'is_guest'    => $this->_request->getPost('is_guest', 0),
                    'is_default'  => $this->_request->getPost('is_default', 0),
                );
                if (empty($data['role_name']) && empty($data['role_desc'])) {
                    throw new Zend_Exception('角色名称和角色定义不能为空');
                }
                $this->db->insert('acl_role', $data);

                $this->_redirect($this->view->url(array('action' => 'list')));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
        $this->isload = false;

    }

    /**
     * 编辑角色
     */
    public function editAction()
    {
        if ($this->_request->isPost()) {
            try {
                $data = array(
                    'mod_name'    => $this->_request->getPost('modName'),
                    'role_name'   => $this->_request->getPost('role_name'),
                    'role_desc'   => $this->_request->getPost('role_desc'),
                    'role_level'  => $this->_request->getPost('role_level'),
                    'is_guest'    => $this->_request->getPost('is_guest', 0),
                    'is_default'  => $this->_request->getPost('is_default', 0),
                );
                if (empty($data['role_name']) && empty($data['role_desc'])) {
                    throw new Zend_Exception('角色名称和角色定义不能为空');
                }
                if ($data['is_default'] > 0) { //清除掉已有的默认角色
                    $where = array(
                        $this->db->quoteInto('mod_name=?', $data['mod_name']),
                        $this->db->quoteInto('is_default=1')
                    );
                    $this->db->update('acl_role', array('is_default' => 0), $where);
                }
                if ($data['is_guest']) { //清除掉已有的游客角色
                    $where = array(
                        $this->db->quoteInto('mod_name=?', $data['mod_name']),
                        $this->db->quoteInto('is_guest=1')
                    );
                    $this->db->update('acl_role', array('is_guest' => 0), $where);
                }
                $role_id = (int) $this->_request->getPost('role_id');
                if ( $role_id > 0) {
                    $where = $this->db->quoteInto('role_id = ?', $role_id);
                    $this->db->update('acl_role', $data, $where); //更新模块表
                }
                $this->_redirect($this->view->url(array('action' => 'list')));
            } catch (Exception $e) {
                $this->view->feedback(array(
                    'title'    => '发生错误',
                    'message'  => '操作失败：' . $e->getMessage(),
                ));
            }
        }
        $this->isload = false;
    }

    /**
     * 删除角色
     */
    public function delAction()
    {
        $role_id = (int) $this->_request->getParam('role_id', 0);
        try {
            $where = $this->db->quoteInto('role_id = ?', $role_id);
            $this->db->delete('acl_role', $where);
            $this->_redirect($this->view->url(array('action' => 'list')));
        } catch (Exception $e) {
            $this->view->feedback(array(
                'title'    => '发生错误',
                'message'  => '操作失败：' . $e->getMessage(),
            ));
        }
        $this->isload = false;
    }
}