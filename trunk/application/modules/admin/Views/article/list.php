<?=$this->render('header.php');?>
<div class="content_div">
    <table class="tablegrid" width="100%" cellspacing="0" cellpadding="0" border="0"  >
        <tr>
            <th align="left">文章ID</th>
            <th align="left">标题</th>
            <th align="left">录入时间</th>
            <th align="left">点击数</th>
            <th align="left">评论数</th>
            <th align="left">操作</th>
        </tr>
        <? if (count($this->paginator) < 0) { ?>
            <tr>
            <td align="center" colspan="6" height="50"><span class="warning">未找到录入记录</span></td>
            </tr>
        <? } else {?>

        <?php foreach($this->paginator as $row) { ?>
        <tr>
            <td align="left"><?= $row['art_id']?></td>
            <td align="left"><?= trim_right(substr($row['title'],0, 100)) ?></td>

            <td align="left"><?= date('Y-m-d H:i:s', $row['save_time'])?></td>
            <td align="left"><?= $row['clicks']?></td>
            <td align="left"><?= $row['comments']?></td>
            <td align="left">
                <a href="http://www.yunphp.cn/article/<?=$row['art_id']?>.html" target="_blank">查看</a>|
                <a href="<?=$this->url(array('module' => 'admin', 'controller' => 'article', 'action' => 'edit','art_id' => $row['art_id']), '', true); ?>">编辑</a>|
                <a href="<?=$this->url(array('module' => 'admin', 'controller' => 'article', 'action' => 'del','art_id' => $row['art_id']), '', true); ?>" class="delete">删除</a>
            </td>
        </tr>
        <?php }} ?>
    </table>
</div>

<?=$this->paginationControl($this->paginator, 'Elastic', 'page.php'); ?>
<?=$this->render('footer.php');?>
