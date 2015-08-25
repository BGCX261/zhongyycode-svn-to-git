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

.user_xiaofei .t1 {color:#4FAF03;font-weight:bold;}
table {border-collapse:collapse; text-align:center;}
.sjTop {float:right;padding-top:20px;}
.sjTop span {color:#FF7601;}
.sjTable {clear:both;margin:112px auto 0;text-align:center;width:648px;}
.sjTable th {font-size:12px;font-weight:normal;}
.sjTable td {color:#4FAF05;font-weight:bold;}
.sjYf {padding-top:50px;text-align:right;width:50%;}
.sjYf p {color:#FF7601;font-size:14px;font-weight:bold;}
.sjYf span {color:#4FAF05;}
.sjBottom {padding-top:50px;text-align:center;}
.sjText {font-size:14px;padding-left:50px;padding-top:50px;}
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
                   <div><img src="/images/user/user_shengji_2.gif" /></div>
                    <div class="sjTop"><span><img src="/images/user/img1.gif"><b>选择支付方式</b>→</span> <img src="/images/user/img2.gif"> 支付成功</div>
                   <div class="user_xiaofei">
                    <table border="1" class="sjTable">
                        <tbody>
                        <tr>
                            <th>交易订单</th>
                            <th>升级业务</th>
                            <th>相册空间</th>
                            <th>有效期</th>
                            <th>价格</th>
                        </tr>
                        <tr>
                            <td><?=$order_id?></td>
                            <td><?=$group['group_name']?>会员</td>
                            <td><?=$group['max_space']?>M<?=$gift?></td>
                            <td><?=$unit?></td>
                            <td><?=$getGroupPrice?>元</td>
                        </tr>
                    </tbody>
                    </table>
                    <div style="float: left;" class="sjYf">
                    <p>应付金额：￥<?=round($payPrice, 2)?>元</p><br>
                    <span>升级后您的有效期至：<?=$will_exceed?></span>
                    </div>
                    <div class="sjBottom">
                       <a href="<?=$payment->get_payurl()?>"><img src="/images/user/sjBtn.gif" /></a><p style="color: rgb(0, 0, 0);"><strong>如果支付失败，请到<a target="_blank" href="http://shop33867464.taobao.com/">官方店铺</a>购买</strong></p>
                </div>
                      <div class="sjText">
                        <p style="height: 50px; line-height: 50px;">支付方式：<img src="/images/user/zhiFubao.gif"></p>
                         <p>支付宝（中国）网络技术有限公司是国内领先的独立第三方支付平台，由阿里巴巴集团创办。</p>
                         <p>支付宝（www.alipay.com）致力于喂中国电子商务提供“简单、安全、快速”的在线支付解决方案。</p>
                        </div>

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
<script type="text/javascript" src="/scripts/wal8/cal_fee.js"></script>
<script type="text/javascript">
function form_submit (_p){
openNewDiv('newDiv',_p);
document.forms["alipaysubmit"].submit();
}


</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>