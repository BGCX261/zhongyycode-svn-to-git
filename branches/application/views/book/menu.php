<style type="text/css">
#side{width:135px; float:left;background:url("/images/user/user_0left_bg.gif") no-repeat scroll 0 0 transparent;
color:#4FAF03;height:1000px;padding:25px 50px 0 12px ;}
p{color:#4FAF03;line-height:25px;}
#side .user_head{padding:2px;height:105px; text-align:center;}
#side .user_name{line-height:25px; text-align:center; color:#4FAF03;}
.progressBar {background:url("/images/user/bg_bar.gif") no-repeat scroll 0 0 transparent;height:10px;position:relative;
width:55px;}
.progressBar span {background:url("/images/user/bar.gif") no-repeat scroll 0 0 transparent;display:block;height:6px;
left:2px;overflow:hidden;position:absolute;text-indent:-8000px;top:2px;width:51px;}
.progressBar em {background:url("/images/user/bg_cover.gif") repeat-x scroll 0 0 transparent;display:block;
height:6px;position:absolute;top:0;width:51px;}
#side .menu {padding-top:80px;overflow:hidden;margin-left:5px;}
#side .menu ul li {height:35px;line-height:15px;}
#side .menu ul li a{color:#4FAF03;}
#side .menu ul li a:hover{color:#FF7800;}
</style>
<div id="side">
    <div class="side_up">
        <p class="user_head" style=""><a href="/user"><img src="<?=(!empty($auth['avatar'])) ? $auth['avatar']: '/images/album/no_avatar.png';?>"  width="92" height="92"/></a></p>
        <p class="user_name"><a href="/user"><?php echo $auth['username'];?></a></p>
        <p>账户类型：<?php echo $auth['group']['group_name'];?></p>
        <p>图 片 数 ：<?php echo $auth['count_img'];?></p>
        <?php if ($auth['rank'] == 25 || $auth['rank'] == 1) {?>
        <p>积 分 数 ：<?=$auth['points']?></p>
        <?php } ?>
        <p>注册日期：<?php echo date('Y-m-d',$auth['reg_time']);?></p>
        <p>到期日期：<?php echo date('Y-m-d',$auth['expire_time']);?></a></p>
        <p>空间大小：<?php echo ($auth['group']['max_space'] + $auth['gift']) ."M";?></p>
        <p>已用空间：<?php echo round($auth['use_space'] / 1024 / 1024,2);?>M</a>&nbsp;<a href="/user" title="刷新缓存" style="color:red">刷新</a></p>
        <p class="progressBar" style="float:left;"><span style="padding-left:0px;"><em style="left:<?php  echo ($auth['use_space'] / 1024 / 1024 / ($auth['group']['max_space'] + $auth['gift']))* 51 ?>px"></em></span>
        <div class="user_txt" style="margin-left:70px;"><?php  echo round(($auth['use_space'] / 1024 / 1024 / ($auth['group']['max_space'] + $auth['gift']))* 100) ?>%</div></p>
    </div>
     <div class="menu">
        <ul>
            <li><img src="/images/user/menu_01.gif" /> <a href="/pay/upgrade">付费中心</a></li>
            <li><img src="/images/user/menu_09.gif" /> <a href="/pay/finance">付费记录</a></li>
            <?php if ($auth['rank'] == 25 || $auth['rank'] == 1) {?>
            <li><img src="/images/user/menu_02.gif"> <a href="/job">积分任务</a></li>
            <?php }?>
            <li><img src="/images/user/menu_03.gif" /> <a href="/upload/add">上传图片</a></li>
            <li><img src="/images/user/menu_04.gif" /> <a href="/category/list">查看图片</a></li>
            <li><img src="/images/user/menu_05.gif" /> <a href="/movehome">产品搬家</a></li>
            <li><img src="/images/user/menu_06.gif" /> <a href="/shopmove">店铺搬家</a></li>
            <li><img src="/images/user/menu_07.gif" /> <a href="/user/profile">设置资料</a></li>
            <li><img src="/images/user/menu_08.gif" /> <a href="/message/list">站 内 信</a></li>
            <li><img src="/images/user/menu_subject_list.gif" /> <a href="/picsubject/list">专题列表</a></li>
            <li><img src="/images/user/menu_book_list.gif" /> <a href="/book/article/list">图书管理</a></li>
            <li><img src="/images/user/menu_10.gif" /> <a href="http://count.wal8.com" target="_blank">店铺统计</a></li>
            <li><img src="/images/user/menu_12.gif" style="padding-left:9px;" /> <a href="/about?k=6" target="_top">联系客服</a></li>
            <li><img src="/images/user/menu_11.gif" /> <a href="/user/logout" target="_top">退出</a></li>
        </ul>
    </div>
</div>