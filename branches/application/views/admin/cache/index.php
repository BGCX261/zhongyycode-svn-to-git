<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<fieldset>
    <legend>静态文件</legend>
    <input type="button" value="更新首页" onclick="location.href='/admin/cache/clean?cid=1'"/>
    <input type="button" value="更新公共社区" onclick="location.href='/admin/cache/clean?cid=2'"/>
    <input type="button" value="更新图书馆" onclick="location.href='/admin/cache/clean?cid=3'"/>
    <input type="button" value="更新文件缓存" onclick="location.href='/admin/cache/clean?cid=4'"/>
</fieldset>


<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>