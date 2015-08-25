<?php
/**
 * 权限 Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
!defined('APP_DIR') && die('Access Deny!');

class PrivilegeModel extends YUN_Abstract
{

    /**
     * 所有权限
     * @var array
     */
    protected $_privileges = null;

    /**
     * 获取所有权限
     * @return array
     */
    public function getAll()
    {
        if (null == $this->_privileges) {
            $select = $this->db->select()
                ->from('acl_privilege')
                ->order('priv_name ASC');
            $rows = $this->db->fetchAll($select);
            $this->_privileges = array();
            foreach ($rows as $row) {
                $this->_privileges[$row['priv_name']] = $row['priv_desc'];
            }
        }
        return $this->_privileges;
    }

    /**
     * 查询权限是否存在
     *
     * @param  string  $privName
     * @return boolean
     */
    public function exists($privName)
    {
        $privileges = $this->getAll();
        return isset($privileges[$privName]);
    }

    /**
     * 获取权限说明
     *
     * @param  string  $privName
     * @return string
     */
    public function getDesc($privName)
    {
        $privileges = $this->getAll();
        return isset($privileges[$privName]) ? $privileges[$privName] : null;
    }

    /**
     * 添加权限
     *
     * @param  array  $data
     * @throws EGP_Exception
     */
    public function add(array $data)
    {
        if ($this->exists($data['new_priv_name'])) {
           throw new Zend_Exception ("权限名称 '{$data['new_priv_name']}' 已经存在");
        }

        $data = array(
            'priv_name' => $data['new_priv_name'],
            'priv_desc' => $data['priv_desc']
        );
        $this->db->insert('acl_privilege', $data); //插入权限

    }

    /**
     * 编辑权限
     * @param  string  $privName
     * @param  array   $data
     * @throws EGP_Exception
     */
    public function edit($privName, array $data)
    {
        if ($data['new_priv_name'] != $privName && $this->exists($data['new_priv_name'])) {
            throw new Zend_Exception("权限名称 '{$data['new_priv_name']}' 已经存在");
        }

        $where = $this->db->quoteInto('priv_name=?', $privName);
        $set['priv_desc'] = $data['priv_desc'];
        $this->db->update('acl_privilege', $set, $where); //更新权限表


    }

    /**
     * 删除权限
     * @param  string  $privName
     */
    public function del($privName)
    {
        if (empty($privName)) {
            return ;
        }
        $where = $this->db->quoteInto('priv_name=?', $privName);
        $this->db->delete('acl_privilege', $where); //删除权限表
    }

    /**
     * 对数据进行校验
     * @param  array  $data
     * @return EGP_Validator
     */
    protected function _validate(array $data)
    {
        $validator = new EGP_Validator();
        $validator->check(
                $data['new_priv_name'],
                array(
                    array('NotEmpty', '权限名称不允许为空'),
                    array('English', '权限名称包含除 [a-zA-Z0-9_] 之外的非法字符'),
                    array('StringLength' => array(2, 20), '权限名称必须介于 2~20 个字符之间'),
                )
            )
            ->check(
                $data['priv_desc'],
                array(
                    array('NotEmpty', '权限说明不允许为空'),
                    array('StringLength' => array(2, 80), '权限说明必须介于 2~80 个字符之间'),
                )
            );
        return $validator;
    }

}