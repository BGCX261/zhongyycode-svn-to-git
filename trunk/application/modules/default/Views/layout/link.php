<div class="cate-title">鏈接</div>
<div class="cate-content">
<ul>
<?php foreach($this->linkList as $link) { ?>
<li><a href="<?=$link['link_url']?>" target="_blank"><?=$link['link_name']?></a></li>
<? }?>
</ul>
</div>