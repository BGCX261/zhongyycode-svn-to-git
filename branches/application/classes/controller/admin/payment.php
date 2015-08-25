<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 支付配置
 *
 * @package    class
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-12-30
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Payment  extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '支付配置管理',
            'action' => array(
                'index' => array(
                    'url' => '/admin/payment/index',
                    'text' => '支付列表',
                ),
                'add' => array(
                    'url' => '/admin/payment/add',
                    'text' => '添加',
                ),

            ),
            'current' => $this->request->action
        );
    }

    /*
     * 首页
     */
    public function action_index()
    {
        $this->template->payments = DB::select()->from('payments')->fetch_all();
    }

    /**
     * 设置状态
     */
    public function action_setStat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $adapter = $this->getQuery('adapter');

        DB::update('payments')->set(array($type => $val))->where('adapter', '=', $adapter)->execute();
        $this->auto_render = false;
    }

    /**
     * 添加支付类型
     */
    public function action_add()
    {
        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('adapter', 'not_empty')
                ->rule('pay_name', 'not_empty')
                ->rule('pay_key', 'not_empty');
            if ($post->check()) {
                $pay = ORM::factory('payment');
                $pay->pay_name = $_POST['pay_name'];
                $pay->adapter = $_POST['adapter'];
                $pay->enabled = isset($_POST['enabled']) ? 1 : 0 ;
                $pay->online = isset($_POST['online']) ? 1 : 0 ;
                $pay->pay_fee = floatval($_POST['pay_fee']);
                $pay->pay_desc = $_POST['pay_desc'];
                $pay->pay_key = $_POST['pay_key'];
                $pay->receive_url = $_POST['receive_url'];
                $pay->sort_order = intval($_POST['sort_order']);

                $arr_config_new = array();
                $arr_config = $_POST['config'];
                for($i=0,$max=count($arr_config['key']);$i<$max;$i++)
                {
                    $arr_config_new[$arr_config['key'][$i]] = $arr_config['val'][$i];
                }
                $pay->config = serialize($arr_config_new);

                $pay->save();
                $this->request->redirect('/admin/payment');
            } else {
                $errors = $post->errors('/admin/payment');
                $this->show_message($errors);
            }

        }
    }

    /**
     * 设置
     */
    public function action_set()
    {
        $pay = ORM::factory('payment',$this->getQuery('adapter'));
        if(!$pay->loaded())
        {
            echo 'ID错误';
            exit();
        }
        if($_POST) {
           $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('adapter', 'not_empty')
                ->rule('pay_name', 'not_empty')
                ->rule('pay_key', 'not_empty')
                ;
            if ($post->check()) {
                $pay->pay_name = $_POST['pay_name'];
                $pay->enabled = isset($_POST['enabled']) ? 1 : 0 ;
                $pay->online = isset($_POST['online']) ? 1 : 0 ;
                $pay->pay_fee = floatval($_POST['pay_fee']);
                $pay->pay_desc = $_POST['pay_desc'];
                $pay->pay_key = $_POST['pay_key'];
                $pay->receive_url = $_POST['receive_url'];
                $pay->sort_order = intval($_POST['sort_order']);

                $arr_config_new = array();
                $arr_config = $_POST['config'];
                for($i=0,$max=count($arr_config['key']);$i<$max;$i++)
                {
                    $arr_config_new[$arr_config['key'][$i]] = $arr_config['val'][$i];
                }
                $pay->config = serialize($arr_config_new);

                $pay->save();
                $this->request->redirect('/admin/payment');

            } else {
                $errors = $post->errors('/admin/payment');
                $this->show_message($errors);
            }
        }
        $this->template->pay = $pay;
    }

    /**
     * 删除支付类型
     */
    public function action_del()
    {
        ORM::factory('payment',$this->getQuery('adapter'))->delete();
        $this->request->redirect('/admin/payment');
    }

    /**
     * 支付日志
     */
    public function action_logs()
    {
        $select = DB::select()->from('payment_logs');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if(!empty($keyword)) {
            $select->where('request_uri','like','%'.$keyword.'%')
                ->or_where('server_vars','like','%'.$keyword.'%')
                ->or_where('get_vars','like','%'.$keyword.'%')
                ->or_where('post_vars','like','%'.$keyword.'%');
        }
        $this->template->payment = $payment = $this->getQuery('payment');
        if(!empty($payment)) {
            $select->where('adapter','=',$payment);
        }
        $select->order_by('log_id', 'DESC');
        $this->template->payments = Payment::get_all();
        $this->template->pagination = new Pager($select, array('items_per_page' => 30));
    }

    /**
     * 查看支付日志
     */
    public function action_view()
    {
        $id = $this->getRequest('id');
        $this->template->info =  $info = DB::select('log.*', 'pay.pay_name')
            ->from(array('payment_logs', 'log'))
            ->join(array('payments','pay'))
            ->on('log.adapter', '=', 'pay.adapter', 'pay_name')
            ->where('log.log_id', '=', $id)
            ->fetch_row();

    }

}
