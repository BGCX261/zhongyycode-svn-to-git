<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#art_list li{margin:12px 2px 2px 10px;background:url(/images/icon_right.gif)  0 5px no-repeat; padding-left:10px;border-bottom :1px #FE8B20 dashed;padding-bottom:10px; }
#art_list li a{font-size:14px; font-weight:bold;color:#83C74C}
#art_list li p{color:#000;margin-top:5px;}
.page_list{float:right;}
.title a{color:#83C74C;}
.title a:hover{color:#FE8B20;}
</style>

<div id="body">
    <div id="side">
        <div class="mod_user_info_1">
            <div class="hd"></div>
            <div class="bd"> <span class="avatar"> <a class="pic" href="/books/<?=$userInfo->username; ?>"> <img src="<?php echo (!empty($userInfo->avatar)) ? $userInfo->avatar : '/images/album/no_avatar.png'; ?>" border="0" alt="" title="" /> </a> </span> <span class="info"> <strong class="name"><?=$userInfo->username; ?></strong>
               <p><?php echo (!empty($userInfo->field->sign)) ? $userInfo->field->sign : '这家伙好懒,什么也没留下'; ?></p>
                </span> </div>
            <div class="ft"></div>
        </div>

        <div class="button"> <a class="book_home" href="/book">图书首页</a> <a class="book_manage" href="/book/article/list">图书管理</a> </div>
        <div class="directory">
            <div class="hd"> <span class="title">
                <h2>我的目录</h2>
                <strong>MY DIRECTORY</strong> </span> </div>
            <div class="bd">
                <script type="text/javascript">
                    d = new dTree('d');
                    d.add(0, -1, '我的图书馆');
                     <? foreach ($categories as $item) { ?>
                    d.add(<?=$item['cate_id']?>, <?=$item['parent_id']?>, '<?=$item['cate_name']?>(<?=$item['art_num']?>)', '/book/user/list?cate_id=<?=$item['cate_id']?>&username=<?=urlencode($userInfo->username)?>', '<?=$item['cate_name']?>');
                    <? } ?>
                    document.write(d);
                </script>
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
                    <?php foreach ($tags as $tag) {?>
                    <li><a href="/book/search?tags=<?=urlencode($tag)?>"><?=$tag?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="ft"></div>
        </div>
    </div>
    <div id="main">
        <div class="title_lists new_article">
            <div class="title">
                <h2><span class="icon"></span>当前位置: <?=$cateInfo['cate_name']?></h2>
                <sup><a href="/book">返回图书馆</a></sup> </div>

                <ul id="art_list">
                     <?php foreach ($results as $item) { ?>
                    <li>
                        <a href="/articles/<?=$item['article_id']?>.html"><?=Str::strip_html($item['title'])?></a>
                            &nbsp; &nbsp;&nbsp;<span class="time"><?=date('Y-m-d', $item['post_date']);?></span>
                            &nbsp;&nbsp;&nbsp; <span>阅读:<?=$item['views']?></span>
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