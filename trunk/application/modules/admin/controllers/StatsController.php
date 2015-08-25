<?php
/**
 * 统计信息管理
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
!defined('APP_DIR') && die('Access Deny!');

class Admin_StatsController extends YUN_Controller_Action_Admin
{

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
    }

    public function userAction()
    {

        $start_date = $this->view->start_date = $this->_request->getParam('start_date');
        if (empty($start_date)) {
            $this->view->start_date = date('Y-m-01');
        }

        $end_date = $this->view->end_date = $this->_request->getParam('end_date');
        if (empty($end_date)) {
            $this->view->end_date = date('Y-m-d', time() + 86400);
        }

    }

    public function listsAction()
    {
        $title = new OFC_Elements_Title('测试统计');
        $title->setStyle('{font-size: 16px;}');

        $start = strtotime(date('Y-m-d', strtotime('-30 days')));

        $l = array();
        for ($i = 0; $i <= 30; $i++) {
            $l[] = date('m/d', $start + $i * 86400);
        }
        $labels = new OFC_Elements_Axis_Label($l);
        $labels->setRotate(30);

        $x = new OFC_Elements_Axis_X();
        $x->setLabels($labels)->setGridColour('#EAF4FB');

        $data1 = array();
        $data2 = array();

        for ($i = 0; $i <= 30; $i++) {
//            $s = $this->db->select()
//                ->from('order_info', 'sum(order_amount)')
//                ->where('order_status = 1')
//                ->where('add_time >= ?', $start)
//                ->where('add_time < ?', $start + 86400);
//                ->fetchOne();
            $data1[] = $i ;

//            $s = $this->db->select()
//                ->from('order_info', 'sum(order_amount)')
//                ->where('order_status = 1')
//                ->where('pay_status = 2 OR shipping_status = 1 OR shipping_status = 2')
//                ->where('add_time >= ?', $start)
//                ->where('add_time < ?', $start + 86400)
//                ->fetchOne();
//            $data2[] = $s ? floatval($s) : 0;
            $data2[] = $i + rand(200,1000);

            $start += 86400;
        }

        $y = new OFC_Elements_Axis_Y();
        $max = max(20000, max($data1) + 1000);
        $y->setRange(0, $max, floor($max / 20000) * 1000)->setGridColour('#EAF4FB');

        $line1 = new OFC_Charts_Line_Dot();
        $line1->setKey('总数', 12)
            ->setValues($data1)
            ->setTip('#x_label# 总数 ￥#val#');

        $line2 = new OFC_Charts_Line_Dot();
        $line2->setColour('#FF0000')
            ->setKey('变化的数据', 12)
            ->setValues($data2)
            ->setTip('#x_label# 变化 ￥#val#');

        $chart = new OFC_Chart();
        $chart->setTitle($title)
            ->setXaxis($x)
            ->setYaxis($y)
            ->setBgColour('#FEFFFF')
            ->addElement($line1)
            ->addElement($line2)
            ->output();
       $this->isload = false;
    }

}


