<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iMeeLee.com 网站管理后台</title>
<style type="text/css">
html {height:100%; border-right:1px solid #B5CFD9; background:#F2F9FD url(/images/admin/bg_menu.gif) repeat-x;}
body {height:100%; margin:0; color:#555; font:12px "Lucida Grande", Verdana, Lucida, Helvetica, Arial, sans-serif; border-right:6px solid #DEEFFA;}
a:link, a:visited {color:#06A; text-decoration:none;}
a:hover {text-decoration:underline;}
#main {height:95%;}
#menu {margin:0; padding:10px 0; list-style:none;}
#menu li {display:none;}
#menu li a:link, #menu li a:visited {display:block; padding:0 10px 0 30px; color:#666; margin:2px 0; background:url(/images/admin/menu_ls.gif) 16px 9px no-repeat; height:24px; line-height:24px;}
#menu li a:hover {background:#EAF4FB url(/images/admin/menu_ls_c.gif) 16px 9px no-repeat; text-decoration:none; color:#F60;}
#menu li.selected a:link, #menu li.selected a:visited {background:#DEEFFA url(/images/admin/menu_ls_c.gif) 16px 9px no-repeat; text-decoration:none; color:#06A;}
#menu li.selected a:hover {color:#F60;}
#footer {height:5%; border-top:1px dashed #DDD; font:10px Arial; padding:8px;}
</style>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript">
$().ready(function() {
    $('#menu > li.' + $('#menu > li:first').attr('class')).show();
    $('#menu > li').click(function(){
        $('#menu > li.selected').removeClass('selected');
        $(this).addClass('selected');
        $(parent.topFrame.document).find('#innerinfobar > div.quicklnk').html('管理后台 &raquo; ' + $(parent.topFrame.document).find('#tabs > li.selected > a').text() + ' &raquo; ' + $(this).find('a:first').text());
    });
});
</script>
</head>
<body>
<div id="main">
  <ul id="menu">
  <? foreach ($menu as $item) { ?>
    <li class="<?=$item['class']?>"><a href="<?=$item['url']?>" target="<?=isset($item['target']) ? $item['target'] : 'mainFrame'?>" title="<?=isset($item['title']) ? $item['title'] : $item['text']?>"><?=$item['text']?></a></li>
  <? } ?>
  </ul>
</div>

</body>

</html>