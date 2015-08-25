<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.title_lists ul.new{list-style:disc inside none;}
.title_lists .new li{list-style:disc inside none;margin:5px 0 0 15px;}
.title_lists .new li span.time{width:100px;float:rihgt;margin-left:220px;position:absolute;}
.directory .bd {padding-top:10px;}
.title_lists h2 a{color:#83C74C;}
#art_list li{margin:12px 2px 12px 10px; height:15px;background:url(/images/icon_right.gif)  0 5px no-repeat; padding-left:10px;border-bottom :1px #FE8B20 dashed;padding-bottom:10px;}
#art_list li a{font-size:14px; font-weight:bold;color:#83C74C}
#art_list li p{color:#000;}
#art_list li .time{float:right;width:140px;text-align:left;}
.highlight{color:#F00;}
a.search_title{font-weight:bold;font-size:14px; float:left;width:460px;}
</style>
<div id="body">
    <div id="side">
        <?php if ($auth) { ?>
        <div class="mod_user_info_1">
            <div class="hd"></div>
            <div class="bd"> <span class="avatar"> <a class="pic" href="/books/<?=$auth['username']?>"> <img src="<?php echo (!empty($userInfo->avatar)) ? $userInfo->avatar : '/images/album/no_avatar.png'; ?>" border="0" alt="<?=$auth['username']?>"  /> </a> </span> <span class="info"> <strong class="name"><a  href="/books/<?=$auth['username']?>"> <?=$auth['username']?></a></strong>
                <p> <?=(!empty($auth_field['sign'])) ? $auth_field['sign'] : '这家伙好懒，什么也没留下';?> </p>
                </span> </div>
            <div class="ft"></div>
        </div>

        <div class="button"> <a class="book_home" href="/book">图书馆首页</a> <a class="book_manage" href="/book/article/list">图书管理</a> </div>
       <?php } else { ?>
        <div class="mod_user_login_1">
            <form action="/user/login?forward=<?=urlencode($_SERVER['REQUEST_URI']);?>" id="login" method="post">
            <div class="hd"></div>
            <div class="bd">
                <label class="user_name"> <span> 用户名<br />
                <sup>USER NAME</sup> </span>
                <input name="username" type="text" />
                </label>
                <label class="password"> <span> 密　码<br />
                <sup>PASSWORD</sup> </span>
                <input name="password" type="password" />
                </label>
                <span class="user_button">
                <input class="login" name="" value="用户登录" type="submit" />
                <input class="find_password" name="" value="找回密码" type="button" onclick="location.href='/user/forget'"/>
                </span> </div>
            <div class="ft"></div>
            </form>
        </div>
        <?php } ?>

        <a href="#" class="ad"> <img src="/images/album/banner/banner3.png" alt="" title="" border="0" /> </a>
        <div class="hot_tags">
            <div class="hd"> <span class="title">
                <h2>热门标签</h2>
                <strong>HOT TAGS</strong> </span> </div>
            <div class="bd">
                <ul class="tags_lists">
                    <?php foreach ($tags as $tag) { ?>
                    <li><a href="/book/search?tags=<?=urlencode($tag['tag_name'])?>"><?=$tag['tag_name']?></a></li>
                    <?php } ?>
                </ul>
                <div class="clearfloat"></div>
            </div>
            <div class="ft"></div>
        </div>
    </div>
    <div id="main">
        <div class="title_lists new_article">
            <div class="title">
                <h2><span class="icon"></span>当前位置： <a href="/book" > 图书馆</a> » <?php if (!empty($searchTag)) { ?> 标签搜索 <font color="red"><?=$searchTag?></font> <? } else { ?> 搜索 <font color="red"><?=$keyword?></font> <?php }?></h2>
                <sup>+Search Article</sup> </div>
                <a href="#" class="ad1"> <img src="/images/album/banner/banner7.png" alt="" title="" border="0" /> </a>
                <ul id="art_list">
                    <?php foreach ($results as $item) { ?>
                    <li><a href="/articles/<?=$item['article_id']?>.html" class="search_title"><?=Str::highlight($item['title'], $keyword);?></a>
                       <span class="time"><?=date('Y-m-d', $item['post_date']);?>&nbsp;&nbsp;&nbsp;阅读:<?=$item['views']?></span>

                    </li>
                    <?php } ?>
                </ul>
            <div class="clearfloat"></div>
            <?=$pagination->render('pagination/digg');?>
        </div>


    </div>
</div>
<script type="text/javascript">
$().ready(function(){

});
</script>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>