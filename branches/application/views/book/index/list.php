<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#art_list li{margin:12px 2px 2px 10px;background:url(/images/icon_right.gif)  0 5px no-repeat; padding-left:10px;border-bottom :1px #FE8B20 dashed;padding-bottom:10px; }
#art_list li a{font-size:14px; font-weight:bold;color:#83C74C}
#art_list li p{color:#000;margin-top:5px;padding-left:10px;}
.page_list{float:right;}
.title a{color:#83C74C;}
.title a:hover{color:#FE8B20;}
</style>

<div id="body">
    <div id="side">
        <?php if ($auth) { ?>
        <div class="mod_user_info_1">
            <div class="hd"></div>
            <div class="bd"> <span class="avatar"> <a class="pic" href="/books/<?=$auth['username']?>"> <img src="<?php echo (!empty($auth['avatar'])) ? $auth['avatar'] : '/images/album/no_avatar.png'; ?>" border="0" alt="<?=$auth['username']?>"  /> </a> </span> <span class="info"> <strong class="name"><a href="/books/<?=$auth['username']?>"> <?=$auth['username']?></a></strong>
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
        <?php if ($auth){?>
        <div class="directory">
            <div class="hd"> <span class="title">
                <h2>我的目录</h2>
                <strong>MY DIRECTORY</strong> </span> </div>
            <div class="bd">
                <script type="text/javascript">
                    d = new dTree('d');
                    d.add(0, -1, '我的图书馆');
                    <?php foreach ($categories as $item) { ?>
                    d.add(<?=$item['cate_id']?>, <?=$item['parent_id']?>, '<?=$item['cate_name']?>(<?=$item['art_num']?>)', '/book/user/list?cate_id=<?=$item['cate_id']?>&username=<?=urlencode($auth['username'])?>', '<?=$item['cate_name']?>');
                    <? } ?>
                    document.write(d);
                </script>
            </div>
            <div class="ft"></div>
        </div>
        <?php } ?>
        <a href="#" class="ad"> <img src="/images/album/banner/banner3.png" alt="" title="" border="0" /> </a>
        <div class="hot_tags">
            <div class="hd"> <span class="title">
                <h2>热门标签</h2>
                <strong>HOT TAGS</strong> </span> </div>
            <div class="bd">
                <ul class="tags_lists">
                    <?php foreach ($tags as $tag) {?>
                    <li><a href="/book/search?tags=<?=urlencode($tag['tag_name'])?>"><?=$tag['tag_name']?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="ft"></div>
        </div>
    </div>
    <div id="main">
        <div class="title_lists new_article">
            <div class="title">
                <h2><span class="icon"></span>当前位置: <?=$position?></h2>
                <sup><a href="/book">返回图书馆</a></sup> </div>

                <ul id="art_list">
                     <?php foreach ($results as $item) { ?>
                    <li>
                        <a href="/articles/<?=$item['article_id']?>.html" style="font-size:14px;color:#2862AC;"><?=Str::strip_html($item['title'])?></a>
                            &nbsp; &nbsp;&nbsp;<span class="time"><?=date('Y-m-d', $item['post_date']);?></span>
                            &nbsp;&nbsp;&nbsp; <span>阅读:<?=$item['views']?></span>
                            &nbsp;&nbsp;&nbsp; <span>分类:<?=$item['cate_name']?></span>
                            &nbsp;&nbsp;&nbsp; <span>作者:<a  style="font-size:12px;color:#2862AC;" href="/books/<?=$item['username']?>"><?=$item['username']?></a></span>
                        <p><?=Str::slice(Str::strip_html($item['content']), 100, '..')?><p>
                    </li>
                    <?php }?>
                </ul>
             <div class="page_list"> <?php echo $pagination->render('pagination/digg');?></div>
        </div>


    </div>
</div>
<script type="text/javascript">
$().ready(function(){
    d.openAll();
});
</script>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>