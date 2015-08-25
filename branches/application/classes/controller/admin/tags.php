<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台图片标签
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Tags extends Controller_Admin_Base {

    /*
     * 首页
     */
    public function action_list()
    {

        $select = DB::select('i.*', 'u.username', 'cate.cate_name')->from(array('imgs', 'i'))
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'i.userid')
            ->join(array('img_categories', 'cate'), 'LEFT')
            ->on('cate.cate_id', '=', 'i.cate_id')
            ->order_by('i.id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('i.picname', 'like', "%$keyword%")
                ->or_where('i.filename', 'like', "%$keyword%")
                ->or_where('i.custom_name', 'like', "%$keyword%");
        }

        $this->template->username = $username = trim($this->getQuery('username'));
        if (!empty($username)) {

            $select->where('u.username', 'like', "%$username%")
                ->or_where('u.uid', '=', $username);
        }


        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();
    }

    /**
     * 删除图片
     *
     */
    public function action_delPic()
    {
        if ($this->isPost()) {
            $id = $this->getPost('id');
            if (!is_array($id)) {
                $id = array($id);
            }
            foreach ($id as $value) {
                DB::delete('imgs')->where('id', '=', $value)->execute();
                $this->request->redirect('/admin/pics/list');
            }

        }
        $this->auto_render = false;
    }

}
