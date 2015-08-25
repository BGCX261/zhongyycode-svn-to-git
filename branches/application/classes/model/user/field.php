<? defined('SYSPATH') or die('No direct script access.');
/**
 * 用户信息详细model
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_User_Field extends ORM
{
    protected $_primary_key = 'uid';
    protected $_belongs_to = array('users' => array('foreign_key' => 'uid'));

    /**
     * 数据验证规则定义
     *
     * @var array
     */
    protected $_rules = array
    (
        'birthday' => array('date' => array()),
        'mobile' => array('phone' => array()),
        'phone' => array('phone' => array()),
        'qq' => array('regex' => array('/^\d{5,13}$/')),
        'msn' => array('email' => array()),
        'postalcode' => array('regex' => array('/^\d{6}$/')),
    );
}