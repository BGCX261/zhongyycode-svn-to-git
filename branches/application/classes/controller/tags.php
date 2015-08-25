<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 标签搜索
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-26
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Tags extends Controller_Base {

    /**
     * 首页
     *
     */
    public function action_index()
    {
        $uid = (int) $this->getQuery('uid');
        $this->template->tag = $tag = urldecode($this->getQuery('tags'));
        $this->template->userInfo = $userInfo = ORM::factory('user')->where('uid', '=', $uid)->find();
        if (empty($userInfo->username)) {
            $this->show_messages('该用户信息不存在');
            die();
        }
        $tag_id = DB::select('tag_id')->from('tags_name')->where('tag_name', '=', $tag)->fetch_one();

        $select = DB::select('tags.item_id')->from('tags')->where('uid', '=', $uid);
        if ($tag_id > 0) {
            $select->where('tags.tag_id', '=', $tag_id);
        }
        $results = $select->execute()->as_array();
        $item_id = array();
        foreach ($results as $item) {
            $item_id[] = $item['item_id'];
        }

        $select = DB::select('i.picname', 'i.id', 'i.userid', 'i.custom_name', 'd.disk_domain', 'd.disk_name', array('i.disk_name', 'img_dir'))
            ->from(array('imgs', 'i'))
            ->join(array('img_disks', 'd'))->on('d.disk_domain', '=', 'i.disk_id')
            ->where('i.userid', '=', $uid);

         if (!empty($item_id)) {
            $select->where('i.id', 'in', $item_id);
        }
        $this->template->pagination = $pagination = new pager ($select);

    }


}
