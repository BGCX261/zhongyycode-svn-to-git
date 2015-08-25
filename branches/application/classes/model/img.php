<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 图片表
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-5
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Img extends ORM
{
    /**
     * 自动格式化时间
     */
    protected $_created_column = array('column' => 'uploadtime', 'format' => TRUE);

    /**
     * ORM一对一关系
     *
     */
    protected $_has_one = array(
        'category' => array('model' => 'img_category', 'foreign_key' => 'cate_id'),

    );

    /**
     * 图片赞一个或鄙视一下
     *
     * @param  integer  $articleId
     * @param  string   $do
     * @return integer
     */
    public function digg($pid, $do)
    {
        $do = strtolower($do);
        $do != 'support' && $do = 'oppose';

        $auth = Session::instance()->get('user', false);;
        $select = DB::select()->from('mood_click')
            ->where('item_id', '=', $pid)
            ->where('app', '=', 'img')
            ->where('sid', '=', session_id());
        if ($auth['uid'] > 0 ) {
            $select->where('uid', '=', (integer) $auth['uid']);
        }
        $row = $select->execute()
            ->current();


        if (!empty($row) ) {
            throw new Exception('您已经赞过或者鄙视过这张图片了，请不要重复。');
        }

        $data = array(
            'item_id' => $pid,
            'sid' => session_id(),
            'uid' => (integer) $auth['uid'],
            'ip' => Request::$client_ip,
            'time' => time(),
            'action' => $do,
        );

        $result = DB::insert('mood_click', array('item_id','app', 'sid', 'uid', 'ip', 'time', 'action' ))
            ->values(
                array($pid, 'img', session_id(),(integer) $auth['uid'], Request::$client_ip, time(), $do)
            )->execute();



        $nums = DB::select(DB::expr('COUNT(*) AS count'))
            ->from('mood_click')
            ->where('item_id', '=', $pid)
            ->where('app', '=', 'img')
            ->where('action', '=', $do)
            ->execute()
            ->get('count');

        $set = array($do => $nums);

        DB::update('imgs')->set($set)->where('id', '=', $pid)->execute();


    }
}
?>