<?php
/**
 * 统计管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-19
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Stat extends Controller_Admin_Base
{


    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('stat.access')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        $this->template->layout = array('title' => '流量统计管理');

    }


    /**
     * 流量统计
     */
    public function action_flowrate()
    {
        $select = DB::select('f.id', 'f.tot_times', 'f.tot_flow', 'u.username','f.uname', 'u.type', 'u.count_img', 'u.reg_time', 'u.expire_time', 'u.login_count',  'u.use_space', 'u.status', 'g.group_name','g.max_space', 'save_dir')->from(array('imgup_flow', 'f'))
                ->join(array('users', 'u'))->on('u.username', '=', 'f.uname')
                ->join(array('imgup_group', 'g'))->on('g.id', '=', 'u.rank');

        $startDate = $this->template->start_date = $this->getQuery('start_date', date("Y-m-d",strtotime("-1 day")));
        if (!empty($startDate)) {
            $select->where("f.date", '>=', $startDate);
        }
        $end_date = $this->template->end_date = $this->getQuery('end_date', '');
        if (!empty($end_date)) {
            $select->where("f.date", '<=', $end_date);
        }

        $username = $this->template->username = trim($this->getQuery('username'));
        if (!empty($username)) {
            $select->where("f.uname", '=', $username);
        }
        $rank = $this->template->rank = $this->getQuery('rank');
        if ($rank > 0) {
            $select->where("u.rank", '=', $rank);
        }

        $order_by = $this->template->order_by = $this->getQuery('order_by');
        if (!empty($order_by)) {
            $select->order_by("f.$order_by", 'DESC');
        }


        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE),array('items_per_page' => 20));
        $this->template->group = DB::select('g.*')->from(array('imgup_group', 'g'))->execute()->as_array();
    }

    /**
     * 查看统计
     */
    public function action_list()
    {

       $this->template->save_dir = $this->getQuery('save_dir');
       $this->template->start_date = $this->getQuery('start_date', '');
        if (empty($this->template->start_date)) {
            $this->template->start_date = date('Y-m-01');
        }
        $this->template->end_date = $this->getQuery('end_date', '');
        if (empty($this->template->end_date)) {
            $this->template->end_date = date('Y-m-d', time() + 86400);
        }

    }

    /**
     * 最近30天浏览统计
     */
    public function action_month()
    {
        $uname = $this->getQuery('save_dir');

        //$stat_date = urldecode($this->getRequest('stat_date', 'stat_date'));
        //$end_date = urldecode($this->getRequest('end_date', 'end_date'));
        $title = new OFC_Elements_Title($uname  .'最近30日流量统计');
        $title->setStyle('{font-size: 16px;}');

        $start = strtotime(date('Y-m-d', strtotime('-30 days')));
        $l = array();
        for ($i = 0; $i <= 30; $i++) {
            $l[] = date('m/d', $start + $i * 86400);
            $listDay[] = date('y-m-d', $start + $i * 86400);
        }

        $labels = new OFC_Elements_Axis_Label($l);
        $labels->setRotate(30);

        $x = new OFC_Elements_Axis_X();
        $x->setLabels($labels)->setGridColour('#EAF4FB');

        $data1 = array();
        $data2 = array();

        foreach($listDay as $i){
            $time = date('Y-m-d', strtotime($i));
            $tot_flow = DB::select('tot_flow')
                ->from('imgup_flow')
                ->where('uname', '=', $uname)
                ->where('date', '=', $time)
                ->fetch_one();

            $s1 = $tot_flow / 1048576;
            $data1[] = $s1 ? round($s1) : 0;

            $s2 = DB::select('tot_times')
                ->from('imgup_flow')
                ->where('uname', '=', $uname)
                ->where('date', '=', $time)
                ->fetch_one();
            $s2 = $s2 ;
            $data2[] = $s2 ? floatval($s2) : 0;
            $start += 86400;
        }

        $y = new OFC_Elements_Axis_Y();
        $max = max(2000, max($data2) + 100);
        $y->setRange(0, $max, floor($max / 2000) * 100)->setGridColour('#EAF4FB');

        $line1 = new OFC_Charts_Line_Dot();
        $line1->setKey('流量', 12)
            ->setValues($data1)
            ->setTip('#x_label# 访问 #val# m');

        $line2 = new OFC_Charts_Line_Dot();
        $line2->setColour('#FF0000')
            ->setKey('访问次数', 12)
            ->setValues($data2)
            ->setTip('#x_label# 访问 #val# 次');

        $chart = new OFC_Chart();
        $chart->setTitle($title)
            ->setXaxis($x)
            ->setYaxis($y)
            ->setBgColour('#FEFFFF')
            ->addElement($line1)
            ->addElement($line2)
            ->output();
        $this->auto_render = false;

    }


    /**
     * 订单统计
     */
    public function action_order()
    {
    }

    /**
     * 最近30日订单统计
     */
    public function action_orderday()
    {
        $this->auto_render = false;

        $title = new Ofc_Elements_Title('最近30日订单统计');
        $title->setStyle('{font-size: 16px;}');

        $start = strtotime(date('Y-m-d', strtotime('-30 days')));

        $l = array();
        for ($i = 0; $i <= 30; $i++) {
            $l[] = date('m/d', $start + $i * 86400);
        }
        $labels = new Ofc_Elements_Axis_Label($l);
        $labels->setRotate(30);

        $x = new Ofc_Elements_Axis_X();
        $x->setLabels($labels)->setGridColour('#EAF4FB');

        $data1 = array();
        $data2 = array();

        for ($i = 0; $i <= 30; $i++) {
            $s = DB::select(DB::expr('sum(fee)'))
                ->from('imgup_upgrade')
                ->where('status', '!=', 2)
                ->where('save_time', '>=', date('Y-m-d',$start))
                ->where('save_time', '<', date('Y-m-d',$start + 86400))
                ->fetch_one();

            $data1[] = $s ? floatval($s) : 0;

            $s = DB::select(DB::expr('sum(fee)'))
                ->from('imgup_upgrade')
                ->where('status', '=', 1)
                ->where('save_time', '>=', date('Y-m-d',$start))
                ->where('save_time', '<', date('Y-m-d',$start + 86400))
                ->fetch_one();
            $data2[] = $s ? floatval($s) : 0;

            $start += 86400;
        }

        $y = new Ofc_Elements_Axis_Y();
        $max = max(20000, max($data1) + 1000);
        $y->setRange(0, $max, floor($max / 20000) * 1000)->setGridColour('#EAF4FB');

        $line1 = new Ofc_Charts_Line_Dot();
        $line1->setKey('总订单额', 12)
            ->setValues($data1)
            ->setTip('#x_label# 总金额 ￥#val#');

        $line2 = new Ofc_Charts_Line_Dot();
        $line2->setColour('#FF0000')
            ->setKey('已成交订单额', 12)
            ->setValues($data2)
            ->setTip('#x_label# 已成交 ￥#val#');

        $chart = new Ofc_Chart();
        $chart->setTitle($title)
            ->setXaxis($x)
            ->setYaxis($y)
            ->setBgColour('#FEFFFF')
            ->addElement($line1)
            ->addElement($line2)
            ->output();
    }
     /**
     * 最近1年订单统计
     */
    public function action_ordermonth()
    {
        $this->auto_render = false;

        $title = new Ofc_Elements_Title('最近1年订单统计');
        $title->setStyle('{font-size: 16px;}');

        $start = strtotime(date('Y-m-01', strtotime('-12 month')));

        $l = array();
        for ($i = 0; $i <= 12; $i++) {
            $l[] = date('Y/m', strtotime("+$i month", $start));
        }

        $labels = new Ofc_Elements_Axis_Label($l);

        $x = new Ofc_Elements_Axis_X();
        $x->setLabels($labels)->setGridColour('#EAF4FB');

        $data1 = array();
        $data2 = array();
        $data3 = array();

        for ($i = 0; $i <= 12; $i++) {
            $s1 = DB::select(DB::expr('sum(fee)'))
                ->from('imgup_upgrade')
                ->where('status', '!=', 2)
                ->where('save_time', '>=',  date('Y-m-d',$start))
                ->where('save_time', '<',  date('Y-m-d',strtotime("+1 month", $start)))
                ->fetch_one();
            $data1[] = $s1 ? floatval($s1) : 0;

            $s2 = DB::select(DB::expr('sum(fee) as sum'))
                ->from('imgup_upgrade')
                ->where('status', '=', 1)
                ->where('save_time', '>=', date('Y-m-d',$start))
                ->where('save_time',  '<', date('Y-m-d',strtotime("+1 month", $start)))
                ->fetch_row();
            $data2[] = $s2 ? floatval($s2['sum']) : 0;



            $start = strtotime("+1 month", $start);
        }

        $y = new Ofc_Elements_Axis_Y();
        $y->setRange(0, max(400000, max($data1) + 10000), 20000)->setGridColour('#EAF4FB');

        $bar1 = new Ofc_Charts_Bar_Glass();
        $bar1->setKey('总订单额', 12)
            ->setValues($data1)
            ->setTip('#x_label# 总金额 ￥#val#');

        $bar2 = new Ofc_Charts_Bar_Glass();
        $bar2->setColour('#FF0000')
            ->setKey('已成交订单额', 12)
            ->setValues($data2)
            ->setTip('#x_label# 已成交 ￥#val#');


        $chart = new Ofc_Chart();
        $chart->setTitle($title)
            ->setXaxis($x)
            ->setYaxis($y)
            ->setBgColour('#FEFFFF')
            ->addElement($bar1)
            ->addElement($bar2)
            ->output();
    }

}