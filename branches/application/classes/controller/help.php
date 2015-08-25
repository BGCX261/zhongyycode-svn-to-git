<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 帮助中心
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-10
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Help extends Controller_Base {

    /**
     * 首页
     *
     */
    public function action_index()
    {
        $this->template->k = $k = (int) $this->getQuery('k', 0);
        $this->template->menu = $menu = DB::select()->from('imgup_docs')
            ->where('cid', '=', 1)
            ->order_by('id', 'ASC')
            ->execute()->as_array();


        $select = DB::select()->from('imgup_docs')
            ->where('cid', '=', 1)
            ->limit(1);
        ($k > 0 ) &&  $select->where('id', '=', $k);

        $this->template->rows = $select->execute()->current();
    }


}
