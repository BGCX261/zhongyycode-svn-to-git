
<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 用户付费处理 [未整理完成，累]
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-20
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Pay extends Controller_Base {


     /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->checklogin();
    }

    /**
     * 付费中心
     */
    public function action_upgrade()
    {

    }

    /**
     * 生成订单
     */
    public function action_paymoney()
    {

        $this->template->pageTitle = '订单支付';
        $info = explode(',',base64_decode(trim($this->getQuery('t'))));
        if (!empty($info)) {

            $upgrade = new Upgrade($this->auth,(int) $info[0], (int)$info[1]);
            try {
               $upgrade->check_place();
            } catch (Exception $e) {
               $this->show_message('创建订单失败：' . $e->getMessage());
            }

            $this->template->payPrice = $payPrice = ceil($upgrade->calculate()->getMoney()); // 订单金额
            $this->template->getGroupPrice = $getGroupPrice = $upgrade->getGroupPrice(); // 获取升级组需要金额
            if ($payPrice < 1) {
                $links[] = array(
                    'text' => '返回付费中心',
                    'href' => '/pay/upgrade',
                );
                $this->show_message('抱歉，所在用户组无法升级。。。', 0, $links);

            }
            $this->template->group = $upgrade->getGroup();
            switch ($info[0]){

                    default:
                        $gift = '';
                    break;
            }
            $this->template->gift = $gift;

            if ($info[1] == 12 ) {
                $unit= "1年";
            } else{
                $unit= $info[1] . "个月";
            }
            $this->template->unit = $unit;
            # 计算付款后到期时间
            if($this->auth['rank'] == $info[0]){
               $expire = time() - $this->auth['expire_time'];
               if ($expire > 604800 ) {
                  $will_exceed = date('Y-m-d', (strtotime(date('Y-m-d H:i:s') . ' + ' . $info[1] .' '. 'month') - 604800));
               } else {
                  $will_exceed = date('Y-m-d', strtotime(date('Y-m-d H:i:s',  $this->auth['expire_time']) . ' + ' . $info[1] .' '. 'month'));
               }

            } else{
                $will_exceed = date('Y-m-d', strtotime('+' . $info[1] . ' month '));
            }

            $this->template->will_exceed = $will_exceed;
            $this->template->order_id =  $order_id = $upgrade->generateOrderSn();
            $data = array(
                'uid' => $this->auth['uid'],
                'dest_group' => $info[0],
                'save_time' => date('Y-m-d H:i:s'),
                'fee' => $payPrice,
                'current_group' => $this->auth['rank'],
                'orderno' => $order_id,
                'consume_type' => 1,
                'will_exceed' => $will_exceed,
                'month' => $info[1]
            );

            # 创建订单
            DB::insert('imgup_upgrade', array_keys($data))->values(array_values($data))->execute();



        try {
            $order_id = (int) $order_id;

            $info = $data;

            $adapter = $this->template->adapter = 'alipay';

            if ($info['uid'] != $this->auth['uid']) {
                throw new Exception('您不能查看别人的订单。');
            }


            $payConf = $this->template->payConf = Payment::get_all(); // 支付方式

            $adapter = 'alipay';
            if ($payConf->$adapter->online) { // 在线支付

                $title = $this->auth['username'] . '购买外链吧相册服务';
                $body = $this->auth['username'] . '于'.  date('Y年m月d日').'购买外链吧网络相册服务，订单号：' .$info['orderno'];

                $payment = Payment::create('alipay', $payConf->$adapter->config);
                $payment->set_id($info['orderno'])
                        ->set_subject($title)
                        ->set_body($body)
                        ->set_amount($info['fee'])
                        ->set_key($payConf->$adapter->pay_key);
                if ( ! $payment->is_valid())
                {
                    throw new Exception($payment->get_message());
                }
                $this->template->payment = $payment;


            }
        } catch (Exception $e) {
           $this->show_message('订单支付失败：' . $e->getMessage());
        }
        } else {
            $this->request->redirect('/pay/upgrade');
        }
    }


    /**
     * 付费记录
     */
    public function action_finance()
    {

        $uid = $this->auth['uid'];
        $select = DB::select('u.*', 'g.group_name', array('g2.group_name', 'gname2'))->from(array('imgup_upgrade', 'u'))
            ->join(array('imgup_group', 'g'))
            ->on('g.id', '=', 'u.current_group')
            ->join(array('imgup_group', 'g2'))
            ->on('g2.id', '=', 'u.dest_group')
            ->where('u.uid', '=', $uid)
            ->where('u.status','=',1)
            ->order_by('u.id', 'DESC');
        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();

    }

    /**
     * ajax返回提示应付金额或是否允许操作
     */
    public function action_ajax()
    {
        $info = explode(',',base64_decode(trim($this->getQuery('t'))));

        $upgrade = new Upgrade($this->auth,$info[0], $info[1]);
        $payPrice = $upgrade->calculate()->getMoney(); // 订单金额
        $getGroupPrice = $upgrade->getGroupPrice(); // 订单金额
        if ($payPrice < 1) {
            echo '<span style="color:#FF7E00;">无法升级';

        } else {
            echo "应付：<span style=\"color:#FF7E00;\">" . $payPrice . "</span>元";
        }
        $this->auto_render =  false;
    }
}
