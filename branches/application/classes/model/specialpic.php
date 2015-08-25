<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 专题图片表
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-5
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_Specialpic extends ORM{

    /**
     * 设置主健
     *
     */
    public $_primary_key = 'sid';

    /**
     * 自动格式化时间
     */
    protected $_created_column = array('column' => 'add_time', 'format' => TRUE);

    /**
     * 获取首页推荐专题图片
     */
    public function getIndexTop($limit = 10)
    {
        return  DB::select()->from(array('specialpics', 's'))
                    ->join(array('users', 'u'), 'LEFT')
                    ->on('u.uid', '=', 's.uid')
                    ->where('u.expire_time', '>', time())
                    ->where('s.is_top', '=', 1)
                    ->where('u.expire_time', '>', time())
                    ->limit($limit)
                    ->order_by('s.sid', 'DESC')
                    ->execute()->as_array();
    }

    /**
     * 获取下一个专题
     */
    public function nextSpecial($sid, $uid = 0)
    {
         $row = DB::select()->from('specialpics')->where('sid', '>', $sid)
            ->order_by('sid', 'ASC');
         if ($uid > 0) {
            $row->where('uid', '=', $uid);
         }
        return $row->execute()->current();
    }

    /**
     * 获取上一个专题
     */
    public function preSpecial($sid, $uid = 0)
    {
        $row = DB::select()->from('specialpics')->where('sid', '<', $sid)
            ->order_by('sid', 'ASC');
        if ($uid > 0) {
            $row->where('uid', '=', $uid);
         }
        return $row->execute()->current();
    }

    /**
     * 获取用户最新专题
     */
    public function newSpecial($uid, $num = 11)
    {

       return $this->where('uid', '=', $uid)
            ->limit($num)
            ->order_by('sid', 'DESC')->find_all();
    }
}
