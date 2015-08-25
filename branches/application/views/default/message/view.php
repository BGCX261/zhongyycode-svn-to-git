<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.message{background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent; height:30px; line-height:30px;margin-bottom:0; padding-left:85px; width:660px;}
.user_img_zs{  margin-bottom:10px; display:inline-block; height:130px; line-height:130px; width:130px; overflow:hidden;}
.cate_list{margin:10px; width:680px; list-style:none;}
.cate_list li{float:left; width:160px;margin-left:10px;}
.filp{float:right;margin-right:10px; width:670px; text-align:right;}
.search_true{background:url(/images/user/btn_user_search.gif) no-repeat;width:57px;height:19px; border:none;}
.tis{margin:15px 0;}
.inner_content{background:url("/images/user/user_zhannei_shou1.gif") no-repeat scroll 0 0 transparent; width:746px;height:631px;padding: 0px 0 0 10px; text-aligh:center;}
.td1{}
.td2{margin-left:15px; width:60px;  text-aligh:right;}
.nav_list{margin:0;padding:0;width:450px;padding:0 0 0 10px;position:absolute ;}
.nav_list li{width:103px;height:27px;float:left;background:url("/images/user/user_zhannei_shou1_04.gif") no-repeat;margin:2px 0 0 5px;line-height:27px; color:#4FAF03;font-weight:bold; text-align:center;}
.nav_list li.current{width:103px;height:27px;float:left;background:url("/images/user/user_zhannei_shou1_02.gif") no-repeat;margin:2px 0 0 5px;line-height:27px; color:#FFF;font-weight:bold; text-align:center;}
.nav_list li.current a{color:#FFF;}
.nav_list li a{color:#4FAF03;}
table{margin:0px 0 0 30px;padding-top:20px;}
table tr th{color:#4FAF03; border-bottom:1px solid #4FAF03;}
.fleft {float:left;}

</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content">
    <div class="message">
        <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
            <span id="newgoals"><?=$configs['marquee_message']; ?></span>
        </marquee>
    </div>
    <div class="tis"><img src="/images/user/user_zhannei.gif"></div>
     <ul class="nav_list">
        <li class="current"><a href="/message/list">收件箱</a></li>
        <li><a href="/message/send">发件箱</a> </li>
        <li><a href="/message/save">草稿箱 </a></li>
        <li><a href="/message/write">写邮件</a></li>
    </ul>
    <div class="inner_content">
        <p style="padding:50px 0 0 10px;width:650px; text-align:left;border-bottom:1px dashed #CCCCCC;">
         发件人：<?=$info['username']?>
        </p>
        <p style="margin:10px 0 0 10px;width:650px; text-align:left;border-bottom:1px dashed #CCCCCC;">
         标   题：<?=$info['title']?>
        </p>
        <p style="margin:10px 0 0 10px;width:650px; text-align:left;">
         内   容：<?=$info['content']?>
        </p>
        <br /><br /><br />
        <p style="marign-top:20px;height:30px;line-height:30px;text-align:center;">
            <a href="/message/list"><img src="/images/user/icon_15.gif"></a> &nbsp;
            <a href="/message/del?msg_id=<?=$msgId?>"><img src="/images/user/icon_16.gif"></a>
        </p>
        <form method="post" action="">
        <div style="padding:0;width:650px;margin:0 auto;">

            <h5 style="color:#4FAF03;text-align:center;">快速回复</h5>
            <p>收件人：<input type="text" value="<?=$info['username']?>" name="receiver" gtbfieldid="138"></p>
            <p>标 &nbsp; 题：<input type="text" value="Re:<?=$info['title']?>" name="title" gtbfieldid="139"> (最长20个字符)</p>
            <p><span class="fleft"> 内 &nbsp; 容：</span><textarea style="display: block; float: left;" cols="70" rows="7" name="content"></textarea> </p>
            <div class="clearfloat"></div>
            <div style="text-align:left;margin-top:10px;margin-left:20px;">

            <input type="submit" style="background: url(/images/user/icon_10.gif) repeat scroll 0% 0% transparent; width: 65px; height: 27px; border: 0px none;" value=" " name="send">
            <input type="reset" style="background: url(/images/user/icon_12.gif) repeat scroll 0% 0% transparent; width: 65px; height: 27px; border: 0px none;" value=" " name="">
            </div>
        </div>
        </form>

    </div>


   </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>