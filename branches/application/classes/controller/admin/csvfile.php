<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 搬家文件管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-12-22
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Csvfile extends Controller_Admin_Base {

    /**
     * 控制器方法执行前
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => 'CSV文件管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/csvfile',
                    'text' => '文件列表',
                ),
            ),
            'current' => $this->request->action
        );
    }

    /*
     * CSV列表
     */
    public function action_index()
    {
        $select = DB::select()
            ->from(array('imgup_movestore', 'i'))
            ->order_by('i.id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->or_where('i.csv_file', 'like', "%$keyword%");
        }

        $this->template->username = $username = trim($this->getQuery('username'));
        if (!empty($username)) {
            $user = ORM::factory('user')->where('username', '=', $username)->find();
            if ($user->uid > 0) {
                $select->where('i.uid', '=', $user->uid );
            }
        }
        // 用户ID
        $this->template->uid = $uid = (int) $this->getQuery('uid', 0);
        if ($uid > 0) {
            $select->where('i.uid', '=', $uid );
        }

        $this->template->status = $status = (int) $this->getQuery('status', '-1');
        if ($status >= 0) {
            $select->where('i.status', '=', $status );
        }

       $this->template->pagination = $pagination = new Pager(
            $select->distinct(FALSE),
            array(
                'items_per_page' => 20,
                'current_page' => array('source' => 'route', 'key' => 'id')
            )
        );

    }

    /*
     * CSV列表
     */
    public function action_list()
    {
        $this->template->sid = $sid = (int) $this->getQuery('sid');
        $select = DB::select()
            ->from(array('store_imgs', 'i'))
            ->where('i.sid', '=', $sid)
            ->order_by('i.sid','DESC');

        $this->template->status = $status = (int) $this->getQuery('status', '-1');
        if ($status >= 0) {
            $select->where('i.status', '=', $status );
        }
       $this->template->pagination = $pagination = new Pager(
            $select->distinct(FALSE),
            array('items_per_page' => 20)
        );

    }

    /**
     * 删除CSV
     *
     */
    public function action_del()
    {
        $id = (int) $this->getQuery('sid');
        $info = DB::select('uid', 'src_file')->from('imgup_movestore')->where('id', '=', $id)->fetch_row();
        if (!empty($info)) {
             $file = Io::strip(DOCROOT . 'src_csv/' . $info['uid'] . '/' . $info['src_file']);
             @unlink($file);
             DB::delete('imgup_movestore')->where('id', '=', $id)->execute();
             DB::delete('store_imgs')->where('sid', '=', $id)->where('uid', '=', $info['uid'])->execute();
        }
        $this->request->redirect('/admin/csvfile');
        $this->auto_render = false;
    }

}
