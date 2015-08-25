<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 公共操作类
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Goods extends Controller_Base {


    public function action_detail()
    {
        $goods_id = $this->getQuery('goods_id');
        $info = DB::select()->from('goods')->where('goods_id', '=', $goods_id)->fetch_row();
        $this->template->info = $info;

    }


}
