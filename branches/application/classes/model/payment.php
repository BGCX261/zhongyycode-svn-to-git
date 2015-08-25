<?php
/**
 * 支付模块
 *
 * @package    model
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-12-30
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Payment extends ORM{

    protected $_table_name = 'payments';

    protected $_primary_key = 'adapter';

    /**
     * 数据验证规则定义
     *
     * @var array
     */

    protected $_rules = array
    (
        'adapter' => array('not_empty' => array(),'max_length' => array('20')),
        'enabled' => array('not_empty' => array()),
        'online' => array('not_empty' => array()),
        'pay_fee' => array('not_empty' => array()),
        'pay_name' => array('not_empty' => array(),'max_length' => array('30')),
        'pay_desc' => array('not_empty' => array()),
        'pay_key' => array('not_empty' => array()),
        'config' => array('not_empty' => array()),
        'receive_url' => array('not_empty' => array(),'max_length' => array('250')),
        'sort_order' => array('not_empty' => array())
    );


    /**
     * 数据验证过滤器定义
     *
     * @var array
     */

    protected $_filters = array
    (
        TRUE => array('trim' => array()),
    );

    /**
     * 重写 ORM::save 方法
     *
     * @return ORM
     */
    public function save()
    {
        parent::save();
        Cache::instance()->delete('payments');

        return $this;
    }

    /**
     * 重写 ORM::delete 方法
     *
     * @return ORM
     */
    public function delete($id = NULL)
    {
        parent::delete($id);
        Cache::instance()->delete('payments');

        return $this;
    }

    /**
     * 重写 ORM::delete_all 方法
     *
     * @return ORM
     */
    public function delete_all()
    {
        parent::delete_all();
        Cache::instance()->delete('payments');

        return $this;
    }


}