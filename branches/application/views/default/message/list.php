<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:740px; float:left;}
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
    <div class="inner_content"style="padding:50px 0 0 10px;text-align:left;">

        <table cellpadding="10" width="650" cellspacing="0" border="0">
        <tr>
            <th width="100">收件人</th>
            <th width="100">发件人</th>
            <th width="200">标题</th>
            <th width="120">时间</th>
            <th width="100">操作</th>
        </tr>
        <?php foreach ($pagination as $item) { ?>
        <tr>
            <td width="100"><!--input type="checkbox" /--><?php echo $item['send_username']?><!--img src="/images/user/icon_14.gif" /--></td>
            <td width="100"><?php echo $item['username']?></td>
            <td width="200"><a href="/message/view?msg_id=<?=$item['msg_id']?>"><?php echo $item['title']?></a></td>
            <td width="150"><?php echo date('Y-m-d H:i:s', $item['msg_time']);?></td>
            <td><?php echo ($item['unread'] == 1) ? '<font color="green">未阅读</font>' : '<font color="red">已阅读</font>'?></td>
        </tr>
        <?php } ?>
        </table>
            <?php echo $pagination->render('pagination/digg');?>
    </div>
   </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>