<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.container{width:950px;margin:0 auto;}
.helpleft {background:url("/images/album/help_left.gif") no-repeat scroll 0 0 transparent;height:781px;width:205px;float:left;}
.helpleft ul {margin-left:15px;margin-top:0px;padding-top:50px;}
.helpleft .old {background:url("/images/user/help_icon_2.gif") no-repeat scroll 0 0 transparent;font-weight:bold;}
.helpleft ul li {height:24px;line-height:24px;margin-top:10px;padding-left:10px;text-align:center;width:115px;}
.helpleft .old a {color:#4FAF03;}

.helpright {background:url("/images/user/help_right.gif") no-repeat scroll 0 0 transparent;height:701px;padding-left:25px; padding-top:80px;width:720px;float:right}
.helpleft .now {background:url("/images/user/help_icon_1.gif") no-repeat scroll 0 0 transparent;font-weight:bold;}
.helpleft .now a{color:#FFF}
.helpleft .now a:hover{color:#FF7800}
</style>
<script type="text/javascript" src="js/button_css.js"></script>
<div class="container">

        <div class="helpleft">
        <ul>
        <?php
            foreach ($menu as $item) {
                if($item['id']==$k) {
                    $class='class="now"';
                } else {
                    $class='class="old"';
                }
                echo '<li '.$class.'><a href="/help?k='.$item['id'].'">'.$item['cname'].'</a></li>';
            }
        ?>
        </ul>
        </div>
        <div class="helpright">
           <div style="width:650px; height:550px; overflow:auto;">
           <!---正文 开始--->
            <?=$rows['content']?>
            <!---正文 结束--->
            </div>
        </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer2.php'); ?>