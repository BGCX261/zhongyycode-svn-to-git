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
                            <th class="tr_hd"><span class="icon"></span>序号</th>
                            <th>文章名称</th>
                            <th>创建日期</th>
                            <th>状态</th>
                            <th class="tr_ft">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $item) { ?>
                        <tr>
                            <td class="td_hd"><span class="icon"></span><?=$item['article_id']?></td>
                            <td class="td_content"><a href="/book/article/edit?aid=<?=$item['article_id']?>" title="查看 <?=$item['title']?>"><?=$item['title']?></a></td>
                            <td><?=date('Y-m-d H:i:s', $item['post_date'])?></td>
                            <td>阅读：<?=$item['views']?>&nbsp;/&nbsp;评论：<?=$item['comments']?></td>
                            <td class="td_ft">
                               <a href="/book/article/recycle?aid=<?=$item['article_id']?>&recycle=0" title="移到图书列表">还原</a>
                               <a href="/book/article/del?aid=<?=$item['article_id']?>" title="删除图书">删除</a>
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

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>