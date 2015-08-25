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
.td1{padding-left:5px; width:60px; border:1px solid #F00;}
.td2{margin-left:15px; width:60px; border:1px solid #F00; text-aligh:right;}
.nav_list{margin:0;padding:0;width:450px;padding:0 0 0 10px;position:absolute ;}
.nav_list li{width:103px;height:27px;float:left;background:url("/images/user/user_zhannei_shou1_04.gif") no-repeat;margin:2px 0 0 5px;line-height:27px; color:#4FAF03;font-weight:bold; text-align:center;}
.nav_list li.current{width:103px;height:27px;float:left;background:url("/images/user/user_zhannei_shou1_02.gif") no-repeat;margin:2px 0 0 5px;line-height:27px; color:#FFF;font-weight:bold; text-align:center;}
.nav_list li.current a{color:#FFF;}
.nav_list li a{color:#4FAF03;}
 h5 {color:#4FAF03;text-align:center;font-size:14px;}
 .user_zhannei_cao2 .btn {clear:both;text-align:center;}
.user_zhannei_cao2 p {margin-top:5px;}
.write_msg{text-align:left;margin:10px 0 0 20px;}

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
        <li><a href="/message/list">收件箱</a></li>
        <li><a href="/message/send">发件箱</a> </li>
        <li><a href="/message/save">草稿箱 </a></li>
        <li class="current"><a href="/message/write">写邮件</a></li>
    </ul>
    <div class="inner_content">
        <form method="post" action="" id="add_messages">
            <div class="write_msg">
                <br /><br />
                <h5>写邮件</h5>
                <br/>
                <p>收件人：<input type="text" value="<?=$rece?>" name="receiver">&nbsp;&nbsp;&nbsp;
                <a href="/message/write?rece=admin">写给管理员</a></p>
                <p>标 &nbsp; 题：<input type="text" value="" name="title"> (最长20个字符)</p>
                <p>内 &nbsp; 容：<textarea cols="60" rows="5" name="content"></textarea> </p>
                <p class="btn">
                <input type="hidden" value="" name="eid">
                <input type="hidden" value="0" name="status">
                <br />
                <input type="submit" style="background: url(/images/user/icon_10.gif) repeat scroll 0% 0% transparent; width: 65px; height: 27px; border: 0px none;" value=" " name="send">
                <input type="submit" name="save" value="存草稿" class="botton"   onclick="setStatus();" />
                <input type="reset" style="background: url(/images/user/icon_12.gif) repeat scroll 0% 0% transparent; width: 65px; height: 27px; border: 0px none;" value=" " name="">
                </p>
            </div>
            </form>
    </div>


   </div>
</div>
<script type="text/javascript">
function setStatus() {
    $('input[name=status]').val(1);

}
$(document).ready(function(){
    $('#add_messages').submit(function(){
        if ($('input[name=title]').val() == '') {
            alert('请输入标题');
            return false;
        }
    });
});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>