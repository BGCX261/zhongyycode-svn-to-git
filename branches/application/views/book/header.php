<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($pageTitle)) { echo $pageTitle . '_';}?>外链吧</title>
<meta name="keywords" content="<?=(!empty($keywords))? $keywords  : '淘宝相册|免费相册|外链免费相册|淘宝图片空间|淘宝免费相册|淘宝外链相册|免费可外链相册|图片外链网站';?>" />
<meta name="description" content="<?=(!empty($description))? $description  : '专业淘宝相册,外贸相册,提供稳定的淘宝图片存储空间，支持相册批量上传、批量贴图。中国唯一的彻底免费的淘宝免费相册。';?>">
<?php echo $script.$css; ?>
</head>
<body>
<?php if ($configs['show_top']) { echo $configs['tmp_message_top']; } ?>
<div id="header">
    <div class="hd">
        <ul class="nav">
            <?php if (!$auth) { ?>
            <li><a href="/user/register">注册</a> | </li>
            <li><a href="/user/login">登陆</a> | </li>
            <?php } else { ?>
             <li>欢迎你，<a href="/user"><?php echo $auth['username']?></a> | </li>
             <li><a href="/user/logout">退出</a> | </li>
            <?php } ?>
            <li><a href="#">设为首页</a> | </li>
            <li><a href="#">加入收藏</a> | </li>
            <li class="ft"><a href="/help">帮助</a></li>
        </ul>
    </div>
    <div class="bd">
        <h1><a href="/">外链吧，永久免费！</a></h1>
        <a class="banner" href="#">
            <img src="/images/album/banner/banner.png" border="0" alt="" title="" />
        </a>
    </div>
</div>
<div id="nav">
    <div class="nav_lists">
        <ul class="lists">
            <li><a class="default" href="/">首页</a></li>
            <li><a class="nav_book_current" href="/book">图书馆</a></li>
            <li><a class="nav_public<?=($controller=='pic') ? '_s' : '';?>" href="/pic">公共社区</a></li>
            <li><a class="user_center" href="/user">用户中心</a></li>
        </ul>
    </div>
</div>