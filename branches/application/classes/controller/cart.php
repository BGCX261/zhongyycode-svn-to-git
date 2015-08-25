<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 公共操作类
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Cart extends Controller_Base {


    public function action_add()
    {
        $goods_id = $this->getQuery('goods_id');

        $cart = Cart::getInstance();
        $cart->add($goods_id, 1);

        $this->request->redirect('/cart/list');
        $this->auto_render = false;
    }
    public function action_list()
    {
        $list = Session::instance()->get('cart', false);
        print_r($list);
        $this->auto_render = false;
    }


}
