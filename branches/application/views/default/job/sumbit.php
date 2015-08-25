<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:;padding-left:85px;width:660px;}
#content{width:750px; float:left;}
.user_mianfei {background:url("/images/user/user_mianfei_bg.gif") no-repeat scroll 0 0 transparent;height:520px;line-height20px;margin-top:10px;padding-left:20px;padding-right:50px;padding-top:20px;line-height:20px;}
.tcent {text-align:center;}
.bj_job {background:url("/images/user/user_job_bg.gif") no-repeat scroll 0 0 transparent;height:639px;padding-left:67px;padding-top:127px;}
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
        <div class="user_banjia bj_job">
            <form name="form1" id="form1" method="post" action="">
            <p>使用帮助：<a target="_blank" class="ahuang" href="/help?k=13">[查看]</a>
            <span style="margin-left: 50px;" class="green">注：请勿盗用其他会员劳动成果！</span></p>
            <br><br>
            <p><span style="display: inline-table; width: 60px; float: left;">发帖 ID ：</span>
            <input type="text" style="border: 1px solid rgb(204, 204, 204); width: 522px; height: 22px; line-height: 22px;" id="job_title" name="job_title" gtbfieldid="16"></p><br>
            <p><span style="display: inline-table; width: 60px; float: left;">帖子地址：</span>
            <input type="text" style="border: 1px solid rgb(204, 204, 204); width: 522px; height: 22px; line-height: 22px;" id="job_url" name="job_url" gtbfieldid="17"></p><br>
            <!--p><span style="display: inline-table; width: 60px; text-align: right;">描&nbsp;&nbsp;&nbsp;&nbsp;述 ： </span>
            <textarea style="border: 1px solid rgb(204, 204, 204);" cols="63" rows="6" name="job_description" id="job_description"></textarea> </p-->
            <br>
            <p class="tcent">
            <input type="submit"  style="background: url(/images/user/user_banjia_tijiao.gif) repeat scroll 0% 0% transparent; width: 64px; height: 27px;border:none;" id="sbm_album" value=" " name="sbm_album">&nbsp; &nbsp;

            </p></form>

       </div>

   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#form1').submit(function(){
            var job_title = $('#job_title');
            if (job_title.val() == '') {
                alert('发贴ID不能为空');
                job_title.focus();
                return false;
            }

            var job_url = $('#job_url');
            if (job_url.val() == '') {
                alert('帖子地址不能为空');
                job_url.focus();
                return false;
            }

        });
    });
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>