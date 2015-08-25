<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台图片列表
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Pics extends Controller_Admin_Base {

    /**
     * 控制器方法执行前
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '图片列表管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/pics/list',
                    'text' => '图片列表',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /*
     * 图片列表
     */
    public function action_list()
    {

        $this->template->description = '<ul>
<li>美图推荐:在公共社区显示站美图推荐告信息</li>
<li>图片滚动:在公共社区显示图片滚动信息</li>
</ul>';
        $select = DB::select(
                'i.userid', 'i.is_top', 'i.is_flash', 'i.is_share', 'i.cate_id', 'i.id', 'i.custom_name',
                'uploadtime', 'i.support', 'i.oppose', 'u.username', 'i.filesize', 'i.disk_name',
                'i.disk_name', 'i.picname')->from(array('imgs', 'i'))
            ->join(array('users', 'u'))
            ->on('u.uid', '=', 'i.userid')

            ->order_by('i.id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->or_where('i.custom_name', 'like', "%$keyword%");
        }

        $this->template->username = $username = trim($this->getQuery('username'));
        if (!empty($username)) {
            $user = ORM::factory('user')->where('username', '=', $username)->find();
            if ($user->uid > 0) {
                $select->where('i.userid', '=', $user->uid );
            }
        }
        // 用户ID
        $this->template->uid = $uid = (int) $this->getQuery('uid', 0);
        if ($uid > 0) {
            $select->where('i.userid', '=', $uid );
        }

        // 美图推荐
        $this->template->is_top = $is_top = (int) $this->getQuery('is_top', 0);
        if ($is_top) {
            $select->where('i.is_top', '=',1);
        }
         // 图片滚动
        $this->template->is_flash = $is_flash = (int) $this->getQuery('is_flash', 0);
        if ($is_flash) {
            $select->where('i.is_flash', '=',1);
        }
        // 分类
        $this->template->cate_id = $cate_id = (int) $this->getQuery('cate_id', 0);
        if ($cate_id) {
            $select->where('i.cate_id', '=',$cate_id);
        }
        // 分享
        $this->template->is_share = $is_share = (int) $this->getQuery('is_share', 0);
        if ($is_share) {
            $select->where('i.is_share', '=',1);
        }

        $startDate = $this->template->start_date = $this->getQuery('start_date', '');
        if (!empty($startDate)) {
            $select->where("i.uploadtime", '>=', strtotime($startDate));
        }
        $end_date = $this->template->end_date = $this->getQuery('end_date', '');
        if (!empty($end_date)) {
            $select->where("i.uploadtime", '<=', strtotime($end_date));
        }
       $this->template->pagination = $pagination = new Pager(
            $select->distinct(FALSE),
            array(
                'items_per_page' => 20,
                'current_page' => array('source' => 'route', 'key' => 'id')
            )
        );

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
            }
            $this->request->redirect('/admin/pics/list');
        }
        $this->auto_render = false;
    }

    /**
     * 设置图片状态
     */
    public function action_setStat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $id = (int) $this->getQuery('pid');

        DB::update('imgs')->set(array($type => $val))->where('id', '=', $id)->execute();
        $this->auto_render = false;
    }

}
