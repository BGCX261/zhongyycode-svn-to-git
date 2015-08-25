<?php
/**
 * 举报信息管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Report extends Controller_Admin_Base
{


    /**
     * 初始化
     */
    public function before()
    {
        parent::before();

        $this->template->layout = array('title' => '举报管理');

    }

    /**
     * 规则列表
     */
    public function action_index()
    {
        $select = DB::select()->from(array('report', 'r'))->order_by('r.id','DESC');
        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE), array('items_per_page' => 20));
    }

    /**
     * 删除
     */
    public function action_del()
    {
        $id = (int) $this->getQuery('id');
        if ($id > 0 ) {
            DB::delete('report')->where('id', '=', $id)->execute();
            $this->request->redirect('/admin/report');
        }
        $this->auto_render = false;
    }


}
