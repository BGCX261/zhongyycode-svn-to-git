<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#art_list li{margin:12px 2px 2px 10px;}
#art_list li a{font-size:14px; font-weight:bold;}
#art_list li p{color:#000;}
.page_list{float:right;}

</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="main">
        <div class="mod_book_manage">
            <div class="hd">
                <h2><span class="icon"></span>图书管理</h2>
            </div>
           <?php include(dirname(__FILE__).'/bookmenu.php'); ?>
            <div class="bd">
                <table class="book_lists" border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="tr_hd" width="70"><span class="icon"></span>序号</th>
                            <th>文章名称</th>
                            <th>图书分类</th>
                            <th>创建日期</th>
                            <th>状态</th>
                            <th>推荐</th>
                            <th class="tr_ft">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagination as $key => $item) { ?>
                        <tr>
                            <td class="td_hd"><span class="icon"></span><?=$key + 1?></td>
                            <td width="200"><a href="/articles/<?=$item['article_id']?>.html" title="查看 <?=$item['title']?>" target="_blank"><?=Str::slice($item['title'], 20,'...');?></a></td>
                            <td width="70"><a href="/book/article/list?cate_id=<?=$item['cate_id']?>" title="查看<?=$item['cate_name']?>下的图书 "><?=isset($item['cate_name']) ? $item['cate_name'] : '我的图书馆'?></a></td>
                            <td><?=date('Y-m-d H:i:s', $item['post_date'])?></td>
                            <td>阅读：<?=$item['views']?>&nbsp;/&nbsp;评论：<?=$item['comments']?></td>
                            <td><img src="/images/<?=$item['channel_top']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['article_id']?>, 'channel_top');" /></td>
                            <td class="td_ft">
                               <a href="/book/article/edit?aid=<?=$item['article_id']?>" title="编辑内容">编辑</a>
                               <a href="/book/article/recycle?aid=<?=$item['article_id']?>&recycle=1" title="移到回收站">删除</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="page_list"> <?php echo $pagination->render('pagination/digg');?></div>
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">


function setStat(obj, id, type) {
    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/book/article/setStat', {'article_id': id, 'val': val, 'type': type});
}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>