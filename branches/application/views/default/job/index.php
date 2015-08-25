<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:;padding-left:85px;width:660px;}
#content{width:750px; float:left;}
.user_mianfei {background:url("/images/user_mianfei_bg.gif") no-repeat scroll 0 0 transparent;height:678px;line-height20px;margin-top:10px;padding-left:20px;padding-right:50px;padding-top:20px;line-height:20px;}
.tcent {text-align:center;}
.huang {color:#FF7E00;}
</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content">
    <div class="zxxx">
        <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
            <span id="newgoals"><?php echo $configs['marquee_message']; ?></span>
        </marquee>
    </div>
    <div><img src="/images/user/user_mianfei_top_2.gif" /></div>
    <div class="user_mianfei" >
        <?php echo $job_content['content'];?>
        <p class="tcent"><a href="/help?k=13" class="ahuang" target="_blank">[查看帮助]</a></p>
        <p class="tcent"><a href="/job/sumbit"><img src="/images/user/user_renwu_tijiao.gif" /></a></p>
   </div>
    <div class="user_mianfei_renwu">
       <div><img src="/images/user/user_renwu_top.gif" /></div>
        <a name="list"> </a>
       <ul class="renwujifen">
            <?php foreach ($pagination as $key => $item) {
                if($item['status']==0) {
                        $status='未审';
                        $audit_date='';
                    }
                    else {
                        $status='已审';
                        $audit_date = '审核时间：' . date('Y-m-d',strtotime($item['audite_date']));
                    }
            ?>
            <li>
                <table>
                <tbody><tr>
                <td style="width: 24px;" class="tleft">
                <a onclick="kai(this, 'a<?=$key?>')" id="a<?=$key?>"><img src="/images/user/user_renwu_1.gif"></a>
                </td>
                <td width="200" class="tleft">发帖ID：<span class="huang"><?=$item['title']?></span> </td>
                <td width="180">完成时间：<?=$item['submit_date']?></td>
                <td  width="180"><?=$audit_date?></td>
                <td>状态：<span class="huang"><?=$status?></span></td>
                <td>积分：<span class="huang"><?=$item['points']?></span></td>
                </tr>
                </tbody></table>
                <div style="display: none;" id="diva<?=$key?>"><img src="/images/user/user_renwu_3.gif">
                <span style="width: 250px; margin-right: 30px;">任务地址：<?=$item['url']?></span>

                <span style="margin-left: 26px;">审核备注：<span class="huang"><?=(!empty($item['audite_memo'])) ? $item['audite_memo'] : '暂无信息'?></span></span>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php echo $pagination->render('pagination/digg');?>
   </div>

   </div>
</div>
<script type="text/javascript">
var temp=1;
function kai(dx, ids)
{
 var id=ids;

 var vimg=dx.lastChild.src;
 var weihao=vimg.substr(vimg.length-5,5);
 if( weihao =="1.gif" ) {
     if (temp!=1) {
        var tempid=id;
        document.getElementById(tempid).lastChild.src="/images/user/user_renwu_1.gif"
        document.getElementById(temp).style.display='none';
     }
    dx.lastChild.src="/images/user/user_renwu_2.gif"
    document.getElementById("div"+id).style.display='block';
    temp="div"+id;
    } else {
    dx.lastChild.src="/images/user/user_renwu_1.gif"
    document.getElementById("div"+id).style.display='none';
    }
}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>