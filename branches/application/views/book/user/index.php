<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.title_lists ul.new{list-style:disc inside none;}
.title_lists .new li{float:left;width:320px;list-style:disc inside none;margin:5px 0 0 15px;border-bottom :1px #FE8B20 dashed;padding-bottom:2px;}
.title_lists .new li span.time{width:100px;float:rihgt;margin-left:220px;position:absolute;}
.directory .bd {padding-top:10px;}
</style>
<div id="body">
    <div id="side">

        <div class="mod_user_info_1">
            <div class="hd"></div>
            <div class="bd"> <span class="avatar"> <a class="pic" href="/books/<?=$userInfo->username?>"> <img src="<?php echo (!empty($userInfo->avatar)) ? $userInfo->avatar : '/images/album/no_avatar.png'; ?>" border="0" alt="<?=$userInfo->username?>"  /> </a> </span> <span class="info"> <strong class="name"><?=$userInfo->username?></strong>
                <p> <?=(!empty($userInfo->field->sign)) ? $userInfo->field->sign : '这家伙好懒，什么也没留下';?> </p>
                </span> </div>
            <div class="ft"></div>
        </div>

        <div class="button"> <a class="book_home" href="/book">图书馆首页</a> <a class="book_manage" href="/book/article/list">图书管理</a> </div>
        <div class="directory">
            <div class="hd"> <span class="title">
                <h2>我的图书馆</h2></span>
                </div>
            <div class="bd">
                <script type="text/javascript">
                    d = new dTree('d');

                    d.add(0, -1, '图书馆');
                    <? foreach ($categories as $item) { ?>
                    d.add(<?=$item['cate_id']?>, <?=$item['parent_id']?>, '<?=$item['cate_name']?>(<?=$item['art_num']?>)', '/book/user/list?cate_id=<?=$item['cate_id']?>&username=<?=urlencode($userInfo->username)?>', '<?=$item['cate_name']?>');
                    <? } ?>
                    document.write(d);
                    </script>
                    <div class="clearfloat"></div>
            </div>
            <div class="ft"></div>
        </div>
        <a href="#" class="ad"> <img src="/images/album/banner/banner3.png" alt="" title="" border="0" /> </a>
        <div class="hot_tags">
            <div class="hd"> <span class="title">
                <h2>热门标签</h2>
                <strong>HOT TAGS</strong> </span> </div>
            <div class="bd">
                <ul class="tags_lists">
                    <?php foreach ($tags as $tag) { ?>
                    <li><a href="/book/search?tags=<?=urlencode($tag)?>"><?=$tag?></a></li>
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
                <h2><span class="icon"></span>最新文章</h2>
                <sup>+New Article</sup> </div>
                <br/>
                <ul class="new">
                    <?php foreach ($new_list as $item) { ?>
                    <li><span class="time"><?=date('Y-m-d', $item->post_date);?></span><a href="/articles/<?=$item->article_id;?>.html"><?=Str::slice($item->title, 20, '...');?></a></li>
                    <?php } ?>
                </ul>
                    <div class="clearfloat"></div>

        </div>
        <a href="#" class="ad1"> <img src="/images/album/banner/banner7.png" alt="" title="" border="0" /> </a>
        <div class="title_lists popular_article">
            <div class="title">
                <h2><span class="icon"></span>热门文章</h2>
                <sup>+Popular Article</sup> </div>
                <br/>
                <ul class="new">
                    <?php foreach ($hot_list as $item) { ?>
                    <li><span class="time"><?=date('Y-m-d', $item->post_date);?></span><a href="/articles/<?=$item->article_id;?>.html"><?=Str::slice($item->title, 20, '...');?></a></li>
                    <?php } ?>
                </ul>
                <div class="clearfloat"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
$().ready(function(){
    d.openAll();
});
</script>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>