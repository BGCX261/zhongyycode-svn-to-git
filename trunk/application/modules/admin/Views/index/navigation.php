<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站管理后台</title>
<style type="text/css">
body {margin:0; color:#333; font:12px "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif; background:url(/images/admin/bg_top.gif) repeat-x;}
a:link, a:visited {color:#06A;  text-decoration:none;}
a:hover {text-decoration:underline;}
img {border:none;}
#container {}
#logo {width:159px; float:left; clear:left; height:90px; overflow:hidden;   /*background:url(/images/admin/logo.gif) 15px 13px no-repeat;*/}
#main {float:right; clear:right; width:100%; text-align:left; margin:0 0 0 -159px;}
#innermain {margin:0 0 0 159px;}
#userinfo {position:absolute; top:18px; right:18px;}
#nav {height:54px; overflow:hidden; border-bottom:5px solid #09C;}
#tabs {margin:12px 0 0 0; padding:0; list-style:none;}
#tabs li {float:left; height:42px; line-height:42px;}
#tabs li a:link, #tabs li a:visited {color:#639BB0; font-size:14px; font-weight:bold; display:block; padding:5px 14px 0 14px; background:url(/images/admin/nav_sep.gif) center right no-repeat;}
#tabs li a:hover {color:#08D; text-decoration:none;}
#tabs li.selected {background:url(/images/admin/bg_nav.gif) repeat-x;}
#tabs li.selected a:link, #tabs li.selected a:visited {color:#FFF; background:url(/images/admin/bg_nav_round.gif) top right no-repeat;}
#tabs li.selected a:hover {}
#infobar {border-left:1px solid #B5CFD9; height:30px; margin:0px;}
#innerinfobar {background:#F2F9FD; border-style:solid; border-color:#FFF; border-width:2px 0 2px 1px; line-height:26px; padding:0 10px 0 10px;}
#infobar .quicklnk {color:#666; width:500px; float:left; clear:left;}
#infobar a:link, #infobar a:visited {color:#666; text-decoration:none;}
#infobar a:hover {text-decoration:underline; color:#F60;}
#infobar .ctrlbtn {width:80px; float:right; clear:right; padding:2px 8px 0 0; text-align:right;}
</style>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.2.6.min.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.cookie.min.js"></script>
<script type="text/javascript" language="javascript">
function switchTab(className) {
    $('#tabs > li.selected').removeClass('selected');
    $('#tabs > li > a.' + className).parent().addClass('selected');
    $(parent.leftFrame.document).find('#menu > li').hide();
    $(parent.leftFrame.document).find('#menu > li.' + className).show();
}
function restoreTab() {
    switchTab($('#tabs > li:first').find('a').attr('class'));
    var href = $(parent.leftFrame.document).find('#menu > li.selected > a:first').attr('href');
    if (href) {
        parent.mainFrame.location = href;
}
}
$(document).ready(function() {
    $('#tabs > li').click(function(){switchTab($(this).find('a').attr('class'));});
    restoreTab();
});
</script>
</head>
<body>
<div id="container">
  <div id="logo"></div>
  <div id="main">
    <div id="innermain">
      <div id="nav">
        <ul id="tabs">
        <? foreach ($this->navigation as $item) { ?>
          <li><a href="javascript:void(0);" class="<?=$item['class']?>" title="<?=isset($item['title']) ? $item['title'] : $item['text']?>"><?=$item['text']?></a></li>
        <? } ?>
        </ul>
      </div>
      <div id="infobar">
        <div id="innerinfobar">
          <div class="quicklnk"></div>
          <div class="ctrlbtn">
          <a href="javascript:void(0);" onclick="parent.mainFrame.history.back();" title="返回上一页"><img src="/images/admin/back.gif" alt="" width="20" height="21" /></a>&nbsp;
          <a href="javascript:void(0);" onclick="parent.mainFrame.location.reload();" title="刷新页面"><img src="/images/admin/reload.gif" alt="" width="20" height="21" /></a></div>
        </div>
      </div>
    </div><div id="userinfo"><span><a href="/" title="点击前往网站首页" target="_blank">首页</a></span>&nbsp;&nbsp;<span><a href="<?=$this->url(array('module' => 'ask', 'controller' => 'index', 'action' => 'index'), '', true)?>" title="点击前往网站首页" target="_blank">问答</a></span>&nbsp;&nbsp;您好, <a href="/member/profile" target="mainFrame" title="修改个人资料"><?=$this->auths->username?></a> [ <a href="<?=$this->url(array('controller' => 'user', 'action' => 'logout'), '', true)?>" title="退出管理后台" target="_parent">退出</a> ]</div>
  </div>

</div>
</body>
</html>