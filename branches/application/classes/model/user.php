<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户model
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-15
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_User extends ORM{

    /**
     * 插入数据时自动填充的字段
     *
     * @var array
     */
    protected $_created_column = array('column' => 'reg_time', 'format' => TRUE);

    /**
     * 设置主健
     *
     */
    public $_primary_key = 'uid';

    /**
     * ORM一对一关系
     *
     */
    protected $_has_one = array(
        'field' => array('model' => 'user_field', 'foreign_key' => 'uid'),
    );

    protected $_has_many = array('students' => array('through' => 'enrollment')) ;
    /**
     * 保存登录信息
     *
     * @param unknown_type $user
     */
    public function session_save($identify, $array)
    {
        if(empty($array))return;
        Session::instance()->set($identify, $array);
    }

    /**
     * 用户信息更新
     *
     * @param unknown_type $uid
     * @return unknown
     */
    public function login($uid)
    {
        $user = $this->where('uid','=',$uid)->find();
        if ($user->_loaded) {
            $result =  $user->as_array();
            $result['field'] = $this->field->as_array();
            $result['group'] = DB::select()->from('imgup_group')->where('id', '=', $result['rank'])->execute()->current();          $result['group'] = DB::select()->from('imgup_group')->where('id', '=', $result['rank'])->execute()->current();
            $result['roles'] = DB::select()->from('user_roles')->where('uid', '=', $result['uid'])->execute()->current();

            //更新登录记录
            $this->login_count = $user->login_count + 1;
            $this->last_time = time();
            $this->last_ip = Request::$client_ip;
            $this->save();
            return $result;
        } else {
            return 0;
        }
    }

    /**
     * 获取指定用户所有信息
     *
     * @param  integer $uid
     * @return array
     */
    public function getInfo($uid)
    {
        $user = $this->where('uid','=',$uid)->find();
        if($user->_loaded)
        {
            $result =  $user->as_array();
            $result['field'] = $this->field->as_array();
            $result['group'] = DB::select()->from('imgup_group')->where('id', '=', $result['rank'])->execute()->current();
            return $result;
        }
    }

    /**
     * 重新设置session
     *
     * @param string $uid
     * @return unknown
     */
    public function upcache($uid, $upcache = true)
    {
        if((int)$uid <= 0) return;
        $cateList = DB::select('cate_id', 'path', 'parent_id')
            ->from('img_categories')
            ->where('uid', '=', (int) $uid)
            ->fetch_all();
        if(!empty($cateList)) {
            $cates = new Category();
            foreach ($cateList as $cate) {
                $ids = $cates->getAllChilds($cate['cate_id']);
                $ids[] = $cate['cate_id'];
                $num = ORM::factory('img')->where('userid', '=', (int) $uid)
                    ->where('cate_id', 'in', $ids)
                    ->count_all();
                DB::update('img_categories')->set(array('img_num' => $num))
                    ->where('uid', '=', (int) $uid)
                    ->where('cate_id', '=', (int) $cate['cate_id'])
                    ->execute();
            }
        }
        $rows = DB::select(array('sum("filesize")', 'total_size'),array('count("userid")', 'total_num'))
            ->from('imgs')
            ->where('userid', '=', (int) $uid)
            ->fetch_row();
        DB::update('users')->set(array('use_space' => $rows['total_size'],'count_img' => $rows['total_num']))
            ->where('uid', '=', (int) $uid)
            ->execute();
        $user = $this->where('uid','=',$uid)->find();
        if ($user->_loaded) {
            $result =  $user->as_array();
            $result['field'] = $this->field->as_array();
            $result['group'] = DB::select()->from('imgup_group')->where('id', '=', $result['rank'])->execute()->current();
            $rows = DB::select()->from('user_roles')->where('uid', '=', (int) $result['uid'])->execute()->as_array();
            $arr = array();
            foreach($rows as $row) {
                $arr[$row['mod_name']] = $row;
            }
            $result['roles'] = $arr;
            if ($upcache) {
                $this->session_save('user', $result);
            }
            return $result;
        } else {
            return 0;
        }
    }

    /**
     * 检查用户过期时间
     */
    public function check_expire($uid)
    {

        $user = $this->where('uid','=',$uid)->find();
        if ($user->_loaded) {
             if ($user->status == 'overtime'  || $user->status == 'disapproval') {
                $set ['status'] = 'disapproval';
                DB::update('users')->set($set)->where('uid', '=', $uid)->execute();
                return true;
            }
            if ($user->expire_time < time()) {
                if ($user->points >= 10 && $user->rank == 1) {
                    $set['points'] = $user->points - 10;
                    $set['expire_time'] = strtotime(date('Y-m-d H:i:s', strtotime('+1 month')));
                    DB::update('users')->set($set)->where('uid', '=', $uid)->execute();
                    return false;
                } else {
                    $set ['status'] = 'disapproval';
                    DB::update('users')->set($set)->where('uid', '=', $uid)->execute();
                    return true;
                }

            } else {
                return false;
            }
        }
    }

    /**
     * 检查用户空间容量
     */
    public function check_space($uid)
    {

        $user = $this->where('uid','=',$uid)->find();

        if ($user->_loaded) {

            $rows = DB::select()->from('imgup_group')->where('id', '=', $user->rank)->execute()->current();

            $use_space = round($user->use_space / 1024 / 1024, 2);
             if ($use_space >= ($rows['max_space'] + $user->gift)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 设置滚动广告
     */
    public function setConfig()
    {
        $rows = DB::select('allowed_ext', 'max_upload', 'marquee_message', 'disk_id', 'disk_name', 'tmp_message_top','show_top')
            ->from('imgup_config')->limit(1)->execute()->current();

        if (!empty($rows)) {
            Cache::instance()->set('sys_configs',$rows);
        }
        return $rows;
    }
}
