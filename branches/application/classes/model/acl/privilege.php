<?php
/**
 * 权限 Model Acl_Privileges
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-31
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Acl_Privilege extends ORM{


    /**
     * 所有权限
     *
     * @var array
     */
    protected $_privileges = null;



    /**
     * 设置主健
     *
     */
    public $_primary_key = 'priv_name';


    /**
     * 获取所有权限
     *
     * @return array
     */
    public function getAll()
    {

        $this->_privileges = Cache::instance()->get('acl_privileges');
        if (null == $this->_privileges) {
            $rows = DB::select()
                ->from('acl_privileges')
                ->order_by('priv_name', 'ASC')
                ->execute()->as_array();
            $this->_privileges = array();
            foreach ($rows as $row) {
                $this->_privileges[$row['priv_name']] = $row['priv_desc'];
            }
            Cache::instance()->set('acl_privileges', $this->_privileges, 2592000);
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
     * @throws Exception
     */
    public function addPrivilege(array $data)
    {
        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('new_priv_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('new_priv_name', 'min_length', array('2'))
            ->rule('new_priv_name', 'max_length', array('20'))
            ->rule('new_priv_name', 'not_empty')
            ->rule('priv_desc', 'not_empty');
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/privilege')));
        }
        if ($this->exists($data['new_priv_name'])) {
            throw new Exception("权限名称 '{$data['new_priv_name']}' 已经存在");
        }

        $data = array(
            'priv_name' => $data['new_priv_name'],
            'priv_desc' => $data['priv_desc']
        );
        //插入权限
        $this->priv_name = $data['new_priv_name'];
        $this->values($data)->save();
        Cache::instance()->delete('acl_privileges');
    }

    /**
     * 编辑权限
     *
     * @param  string  $privName
     * @param  array   $data
     * @throws Exception
     */
    public function editPrivilege($privName, array $data)
    {
        //数据验证
        $validator = Validate::factory($data)
            ->filter(TRUE, 'trim')
            ->rule('new_priv_name', 'regex', array('/^[A-Za-z0-9_]++$/iD'))
            ->rule('new_priv_name', 'min_length', array('2'))
            ->rule('new_priv_name', 'max_length', array('20'))
            ->rule('new_priv_name', 'not_empty')
            ->rule('priv_desc', 'not_empty');
        if (!$validator->check()) {
            throw new Exception(implode(',', $validator->errors('admin/privilege')));
        }
        if ($data['new_priv_name'] != $privName && $this->exists($data['new_priv_name'])) {
            throw new Exception("权限名称 '{$data['new_priv_name']}' 已经存在");
        }

        $set['priv_desc'] = $data['priv_desc'];
        DB::update('acl_privileges')->set($set)->where('priv_name', '=', $privName)->execute(); //更新权限表
        Cache::instance()->delete('acl_privileges');
    }

    /**
     * 删除权限
     *
     * @param  string  $privName
     */
    public function delPrivilege($privName)
    {
        if (empty($privName)) {
            return ;
        }
        DB::delete('acl_privileges')->where('priv_name', '=', $privName)->execute(); //删除权限表
        Cache::instance()->delete('acl_privileges');
    }

}