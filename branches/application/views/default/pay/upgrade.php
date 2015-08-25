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
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;
margin-bottom:0;padding-left:85px;width:660px;}
</style>
<script type="text/javascript" src="/scripts/wal8/cal_fee.js"></script>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content">
    <div class="container">
        <div class="rbox2 user0right">
            <div class="zxxx">
                <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
                    <span id="newgoals">
                        <?=$configs['marquee_message']; ?>
                    </span>
                </marquee>
            </div>
           <div><img src="/images/user/user_shengji_2.gif" /></div>

            <form action="/pay/paymoney" method="get" name="payment">
           <ul class="user_shengji"><br /><br />

            <!--循环开始-->


            <li >
            <table class="fleft" style="">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> 铜牌用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('2, 12');?>"   class="group_2_12"/> 49.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠35.00元</span></td>
                    <td><em id="group_2_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：150M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('2,3');?>" class="group_2_3" /> 21.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td>
                    <td><em id="group_2_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('2,1');?>" class="group_2_1" /> 7.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td>
                    <td><em id="group_2_1"></em></td>
                    </td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> 银牌用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('3,12');?>" class="group_3_12" /> 59.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠49.00元</span></td>
                    <td><em id="group_3_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：200M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('3,3');?>" class="group_3_3" /> 27.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_3_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('3,1');?>" class="group_3_1"/> 9.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_3_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> 金牌用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('4,12');?>" class="group_4_12"/> 98.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠46.00元</span></td>
                    <td><em id="group_4_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：300M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('4,3');?>" class="group_4_3" /> 36.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_4_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('4,1');?>" class="group_4_1"/> 12.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_4_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> VIP-A用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('13,12');?>" class="group_13_12"/> 159.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠69.00元</span></td>
                    <td><em id="group_13_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：500M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('13,3');?>" class="group_13_3"/>
                    57.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_13_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('13,1');?>" class="group_13_1"/>
                    19.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_13_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> VIP-B用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('14,12');?>"class="group_14_12"/>
                    239.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠109.00元</span></td>
                    <td><em id="group_14_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：1000M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('14,3');?>"class="group_14_3"/>
                    87.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_14_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('14,1');?>" class="group_14_1"/>
                    29.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_14_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> VIP-E用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('17,12');?>" class="group_17_12"/>
                    299.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠169.00元</span></td>
                    <td><em id="group_17_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：2000M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('17,3');?>"class="group_17_3"/>
                    117.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_17_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('17,1');?>"class="group_17_1"/>
                    39.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_17_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> VIP-G用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('21,12');?>" class="group_21_12"/>
                    399.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠261.00元</span></td>
                    <td><em id="group_21_12"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td>总空间：3000M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('21,3');?>" class="group_21_3"/>
                    165.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_21_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('21,1');?>" class="group_21_1" />
                    55.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_21_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <br />
            <hr size="1" style="border-top:2px solid #F5F5F5; border-left:0px;height:2px;clear:both;margin-left:0px; width:95%;" />
            <br />
            <li>
            <table class="fleft">
                <tr>
                    <td style="width:5%;"><img src="/images/user/icon_3.gif" /></td>
                    <td class="green" style="width:30%;"> 海外用户</td>
                    <td class="tleft" style="width:20%;">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('5,12');?>" class="group_5_12"/> 129.00元 </td>
                    <td>12个月</td>
                    <td>比月付<span class="huang">优惠87.00元</span></td>
                    <td><em id="group_5_12"></em></td>
                </tr>
                    <tr>
                    <td></td>
                    <td>总空间：100M </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('5,3');?>" class="group_5_3"/> 54.00元 </td>
                    <td>3个月</td>
                    <td> </td>
                    <td><em id="group_5_3"></em></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td class="tleft">
                    <input name="t" id="t" type="radio" value="<?php echo base64_encode('5,1');?>" class="group_5_1"/> 18.00元 </td>
                    <td>1个月</td>
                    <td> </td>
                    <td><em id="group_5_1"></em></td>
                </tr>
            </table>
            <input name="pay" type="submit" class="fright" style="background:url(/images/user/user_shengji_btn.gif); width:97px; height:27px;" value=" " />
            </li>
            <!--循环结束-->
            </form>
           </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=t]').click(function() {
       var val = $(this).attr('class');
       $.get("/pay/ajax", { "t": $(this).val() },function(data){
            var content = "应付：<span style=\"huang\">" + 5 + "</span>元";
            $('em').html('');
            $('#'+ val).html(data);
      });
    })

    $('input[name=pay]').click(function(){
        if(typeof($('input:checked').val()) == 'undefined'){
            alert('请选择升级或者续费的用户组');
            return false;
        }
    });
});
</script>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>