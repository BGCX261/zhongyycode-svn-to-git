<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.container{width:950px;margin:0 auto;}
div.TagsClouds {background-color:#F5F5F5;border:1px solid #EEEEEE;padding:1.5em;}
ul.tags_list{margin:0;padding:0;}
ul.tags_list li{float:left;width:130px; margin: 5px}
span.username{font-weight:bold;font-size:18px;}
span.username a{color:#6B9F1F}
</style>

<div class="container">
    <div class="TagsClouds">
        <div class="user"><span class="username"><a href="/u/<?=urlencode($userInfo->username)?>"><?=$userInfo->username?></a></span> 的标签<?=(!empty($tag)) ? '&nbsp;/&nbsp;'. $tag : '';?></div>
        <ul class="tags_list">
            <?php foreach ($pagination as $item) {?>
            <li>
                <p><a href="/<?=$item['id']?>.html"><img src="http://<?=$item['disk_domain'] . '.wal8.com/'. $thumb->create($item['img_dir']. '/'. $item['picname'], 130, 130); ?>" /></a></p>
                <p><a href="/<?=$item['id']?>.html"><?=Str::slice($item['custom_name'], 15, '...')?></a></p>
            </li>
            <?php } ?>
        </ul>
        <div class="clearfloat"></div>
    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
