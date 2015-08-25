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
.sjCheng {clear:both;padding-bottom:50px;padding-top:100px;text-align:center;}
.sjTop {float:right;padding-top:20px;}
.sjTop span {color:#FF7601;}
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
                   <div class="user_xiaofei">

                        <?php echo $result;?>

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