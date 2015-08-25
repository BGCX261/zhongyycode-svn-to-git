<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:0;padding-left:85px;width:660px;}
.bj_A {background:url("/images/user/user_banjia_A_bg_2.gif") no-repeat scroll 0 0 transparent;height:639px;padding-left:67px;padding-top:127px;}
.user_banjia {margin-top:10px;position:relative;}
input{border:0px;}
.bj_A p {margin-top:5px;}
.tcent {text-align:center;}
p {line-height:20px;}
.fright{float:right;}
.user_banjia .user_banjia_btn {left:36px;position:absolute;top:5px;padding-left:25px;width:300px;height:30px;line-height:30px; text-align:left;color:#FFF;}
.user_banjia .user_banjia_btn a {color:#FFF;font-weight:bold}

</style>

<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="content">
        <div class="zxxx">
            <marquee scrolldelay="150" onmouseout="this.start();" onmouseover="this.stop();" behavior="scroll" direction="left" aligh="left">
                <?=$configs['marquee_message']?>
            </marquee>
        </div>
        <div><img src="/images/user/user_banjia_top_2.gif"></div>
        <div class="user_banjia_btn"><a href="move_item.php">&nbsp;</a> <a style="margin-left: 10px;" href="move_item_hist.php">&nbsp;</a></div>
        <div class="user_banjia bj_A">
            <form name="moveitem_form" id="moveitem_form" method="post" action="" enctype="multipart/form-data">
                <p>使用帮助：<a target="_blank" class="ahuang" href="/help?k=12">[查看]</a>
                <span style="margin-left: 50px;" class="green">注：csv文件上线为10M</span></p>
                <br><br>
                <p>上传csv文件</p>

                <p>选择文件：
                <input type="file" style="border: 1px solid rgb(204, 204, 204); height: 22px; line-height: 22px; color: rgb(87, 109, 7);" name="upload_file" id="upload_file">
                </p>
                <p style="margin-right: 100px; margin-top: 2px;" class="huang fright">注：文件大小上限为10M
                </p>
                <br><br><br>

                <p class=" clear tcent">
                <input type="submit" style="background: url(/images/user/user_dianpu_btn.gif) repeat scroll 0% 0% transparent; width: 84px; height: 27px;border:none;" id="sbm_album" value=" " name="sbm_album">
                </p>
                <p class="huang">上传完毕后，请点击上面【历史记录】按钮查看！</p>
                </form>
                <div style="margin-top: 20px;"></div>
                <div class="user_banjia_btn"><a href="/shopmove">店铺搬家</a> <a style="margin-left: 60px;color:#4FAF03" href="/shopmove/list">历史记录</a></div>

           </div>

    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>