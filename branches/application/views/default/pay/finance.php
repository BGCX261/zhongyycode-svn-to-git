<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.fright {float:right;width:100px;}
.fleft{float:left;width:570px;}
.user_shengji li {margin-bottom:10px;height:75px;}
input{border:none;}
.green {color:#4FAF03;}
.huang {color:#FF7E00;}
.user_shengji table td {height:20px;line-height:20px;}
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:;padding-left:85px;width:660px;}
.lh40 {line-height:40px;}
.user_xiaofei table td {border:1px solid #CFE9B9;height:30px;line-height:30px;}
.user_xiaofei .t1 {color:#4FAF03;font-weight:bold;}
table {border-collapse:collapse; text-align:center;}
</style>

<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="content">
        <div class="container">
                <div class="rbox2 user0right">
                    <div class="zxxx">
                        <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
                            <span id="newgoals">
                                <?php echo $configs['marquee_message']; ?>
                            </span>
                        </marquee>
                    </div>
                   <div><img src="/images/user/user_xiaofei_2.gif" /></div>
                   <div class="user_xiaofei">
                   <p class="huang lh40">会员升级差价公式：差价=升级后-（升级前-（升级前/服务天数）X使用天数），结果四舍五入</p>
                       <table class="t1">
                           <tr>
                               <td style="width: 42px; height: 70px;"> 序号</td>
                               <td style="width: 116px;">订单号</td>
                               <td style="width: 66px;">升级为</td>
                               <td style="width: 64px;">类型</td>
                               <td style="width: 64px;">金额</td>
                               <td style="width: 83px;">方式</td>
                               <td style="width: 87px;">服务</td>
                               <td style="width: 103px;">升级时间</td>
                               <td style="width: 104px;">到期时间</td>
                           </tr>
                       </table>
                       <table>
                        <?php foreach ($results as $k => $item) {
                            switch($item['consume_type']){
                                case 0: $consume_type="淘宝";break;
                                case 1: $consume_type="网站";break;
                                case 2:$consume_type="代理";break;
                            }


                            if ($item['month'] % 12 == 0) {
                                $type = '年';
                            } else {
                                 $type = '月';
                            }
                            if ($item['fee_type'] == 'year') {
                                $type = '年';
                            }
                            if ($item['fee_type'] == 'month') {
                                $type = '月';
                            }
                            if($item['time'] == 0) {
                                $item['time'] = $item['month'];
                                if ($type == '年') {
                                    $item['time'] = $item['month'] / 12;
                                }
                            }
                        ?>
                        <tr>
                           <td style="width: 42px;"><?=$k + 1?></td>
                           <td style="width: 116px;"><?=$item['orderno']?></td>
                           <td style="width: 66px;"><?=$item['gname2']?></td>
                           <td style="width: 64px;"><?=$type?>付</td>
                           <td style="width: 64px;"><?=$item['fee']?>元</td>
                           <td style="width: 83px;"><?=$consume_type?></td>
                           <td style="width: 87px;"><?=$item['gname2'].'会员'?><?=$item['time']?> <?=$type?></td>
                           <td style="width: 103px;"><?=date('Y-m-d',strtotime($item['submit_time']))?></td>
                           <td style="width: 104px;"><?=date('Y-m-d',strtotime($item['will_exceed']))?></td>
                               </tr>
                        <?php } ?>
                       </table>

                       <!---   </tr>数据结束   --->
                   </div>
                   <div class="clear fenye">

                    </div>
                   </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>