<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<div id="body">
<div id="main"> <a href="#" class="ad"> <img src="/images/album/banner/banner6.png" width="685" height="90" alt="" title="" border="0" /> </a>
    <form action="/book/search" style="margin:0;padding:0;">
    <div style="margin:0;padding:0;">请输入关健字：<input type="text" name="keyword" value="" size="80"/>&nbsp;&nbsp; <input type="submit" class="botton"  value=" 查 询 "/></div>
    </form>
    <div class="title_lists hot_article">
        <div class="title">
            <h2><span class="icon"></span><a href="/book/index/list?position=is_hot" title="查看更多" style="color:#83C74C">热门文章</a></h2>
            <sup><a href="/book/index/list?position=is_hot" title="查看更多" style="color:#83C74C">+Popular Article</a></sup>
        </div>
        <?php if (!empty($hot_list)) { ?>
        <div class="heading">

                <a href="/articles/<?=$hot_list[0]['article_id']?>.html" class="pic"><img src="<?=(!empty($hot_list[0]['thumb'])) ?  $thumb->create($hot_list[0]['thumb'], 92,92) : '/images/album/img/no_avatar.png';?>" alt="" border="0" /></a>
            <strong><a href="/articles/<?=$hot_list[0]['article_id']?>.html" title="<?=$hot_list[0]['title']?>"><?=Str::slice($hot_list[0]['title'], 26, '...');?></a></strong>
            <p> <?= Str::slice(Str::strip_html($hot_list[0]['content']), 110, '...')?> </p>
        </div>
        <ul class="lists">
            <?php foreach ($hot_list as $key => $item) { if ($key > 0) { ?>
            <li><a class="article_title" href="/articles/<?=$item['article_id']?>.html"><?=Str::slice($item['title'], 40, '...');?></a><a class="writer" href="/books/<?=urlencode($item['username']);?>"><?=$item['username'];?></a></li>
           <?php }} ?>
        </ul>
        <?php } ?>
    </div>
    <div class="title_lists new_article">
        <div class="title">
            <h2><span class="icon"></span><a href="/book/index/list?position=is_new" title="查看更多" style="color:#83C74C">最新文章</a></h2>
            <sup><a href="/book/index/list?position=is_new" title="查看更多" style="color:#83C74C">+New Article</a></sup>
        </div>
        <?php if (!empty($new_list)) { ?>
        <div class="heading"> <a href="/articles/<?=$new_list[0]['article_id']?>.html" class="pic"><img src="<?=(!empty($new_list[0]['thumb'])) ?  $thumb->create($new_list[0]['thumb'], 92,92) : '/images/album/img/no_avatar.png';?>" alt="" border="0" /></a> <strong><a href="/articles/<?=$new_list[0]['article_id']?>.html" title="<?=$new_list[0]['title']?>"><?=Str::slice($new_list[0]['title'], 26, '...');?></a></strong>
            <p> <?= (Str::slice(Str::strip_html($new_list[0]['content']), 110, '...'))?> </p>
        </div>
        <ul class="lists">
            <?php foreach ($new_list as $key => $item) { if ($key > 0) { ?>
            <li><a class="article_title" href="/articles/<?=$item['article_id']?>.html"><?=Str::slice(Str::strip_html($item['title']), 40, '...');?></a><a class="writer" href="/books/<?=urlencode($item['username']);?>"><?=Str::strip_html($item['username']);?></a></li>
           <?php }} ?>
        </ul>
        <?php } ?>
    </div>
    <a href="#" class="ad1"> <img src="/images/album/banner/banner7.png" width="685" height="90" alt="" title="" border="0" /> </a>
    <div class="title_lists recommended_article">
        <div class="title">
            <h2><span class="icon"></span><a href="/book/index/list?position=is_recommend" title="查看更多" style="color:#83C74C">美文推荐</a></h2>
            <sup><a href="/book/index/list?position=is_recommend" title="查看更多" style="color:#83C74C">+Recommended Article</a></sup> </div>
            <?php if (!empty($recommends)) { ?>
            <div class="heading">
                <a href="/articles/<?=$recommends[0]['article_id']?>.html" class="pic"><img src="<?=(!empty($recommends[0]['thumb'])) ?  $thumb->create($recommends[0]['thumb'], 92,92) : '/images/album/img/no_avatar.png';?>" alt="" border="0" /></a>
                <strong><a href="/articles/<?=$recommends[0]['article_id']?>.html" title="<?=$recommends[0]['title']?>"><?=Str::slice($recommends[0]['title'], 26, '...');?></a></strong>
                <p> <?=Str::slice(Str::strip_html($recommends[0]['content']), 110, '...')?> </p>
            </div>
            <ul class="lists">
                <?php foreach ($recommends as $key => $item) { if ($key > 0) { ?>
                <li><a class="article_title" href="/articles/<?=$item['article_id']?>.html"><?=Str::slice(Str::strip_html($item['title']), 40, '...');?></a><a class="writer" href="/books/<?=urlencode($item['username']);?>"><?=$item['username'];?></a></li>
               <?php }} ?>
            </ul>
            <?php } ?>
    </div>
    <div class="title_lists hot_comments">
        <div class="title">
            <h2><span class="icon"></span><a href="/book/index/list" title="查看更多" style="color:#83C74C">精彩评论</a></h2>
            <sup><a href="/book/index/list" title="查看更多" style="color:#83C74C">+Hot Comments</a></sup> </div>
            <?php if (!empty($comments)) { ?>
            <ul class="lists">
             <?php foreach ($comments as $key => $item) {  ?>
                <li><a class="article_title" href="/articles/<?=$item['item_id']?>.html"><?=Str::slice(Str::strip_html($item['content']), 40, '...');?></a><?php if (!empty($item['username'])) {?><a class="writer" href="/books/<?=urlencode($item['username']);?>"><?=$item['username'];?></a> <?php } else {?><a class="writer" href="/articles/<?=$item['item_id']?>.html">匿名</a><?php }?></li>
               <?php } ?>
            </ul>
            <?php }?>
    </div>
</div>
<div id="side">
     <script  language="javascript" src="/js/book"></script>

    <!--div class="tips"style="margin-top:5px;">
        <ul class="lists">
            <li><a  href="#">下载"外链吧快捷访问工具"</a></li>
            <li><a  href="#">安装"文章收藏插件"</a></li>
            <li><a  href="#">下载"文章下载备份工具"</a></li>
        </ul>
    </div-->
    <a class="ad2" href="#"> <img src="/images/album/banner/banner8.png" alt="" title="" border="0" /> </a>
    <div class="mod_folding_2 news_tags">
        <div class="hd">
            <div class="news_title">
                <h2>站内公告</h2>
                <sup>BULLETIN</sup> </div>
        </div>
        <div class="bd">
            <ul class="news_lists">
                <?php  foreach($notice as $item) {?>
                <li><a href="/<?=($item['cid'] == 1) ? 'help' : 'about';?>?k=<?=$item['id']?>" target="_blank"><?=$item['cname']?></a></li>
                <?php } ?>
            </ul>
            <div class="fold">
                <div class="tags_title">
                    <h2>热门标签</h2>
                    <sup>HOTTAGS</sup> </div>
            </div>
            <ul class="tags_lists">
                <?php foreach ($tags as $tag) { ?>
                <li><a href="/book/search?tags=<?=urlencode($tag['tag_name'])?>"><?=$tag['tag_name']?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="ft"></div>
    </div>
    <a class="ad3" href="/user/register"> <img src="/images/album/banner/banner3.png" alt="" title="" border="0" /> </a>
    <div class="faq">
        <div class="hd"> <span class="title">
            <h2>常见问题</h2>
            <strong>QUESTIONS</strong> </span> </div>
        <div class="bd">
            <ul class="lists">
                <?php  foreach($question as $item) {?>
                <li><a href="/<?=($item['cid'] == 1) ? 'help' : 'about';?>?k=<?=$item['id']?>" target="_blank"><?=$item['cname']?></a></li>
                <?php } ?>
            </ul>
            <a href="/help" class="more" target="_blank">更多</a> </div>
        <div class="ft"></div>
    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>