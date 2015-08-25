<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台图片分类
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Category extends Controller_Admin_Base {

    /*
     * 首页
     */
    public function action_list()
    {

        $select = DB::select('i.*', 'u.username')->from(array('img_categories', 'i'))
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'i.uid')
            ->order_by('i.cate_id','ASC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('i.cate_name', 'like', "%$keyword%");
        }

        $this->template->username = $username = trim($this->getQuery('username'));
        if (!empty($username)) {

            $select->where('u.username', 'like', "%$username%")
                ->or_where('u.uid', '=', $username);
        }

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
    }


}
