<?=$this->render('header.php');?>
<form id="form1" name="form1" method="post" action="">
<div class="content_div">
    <table class="tablegrid" width="100%" cellspacing="0" cellpadding="0" border="0"  >
        <tr>
            <th align="left">链接ID</th>
            <th align="left">链接名称</th>
            <th align="left">链接地址</th>
            <th align="left">錄入時間</th>
            <th align="left">操作</th>
        </tr>
        <? foreach($this->rows as $row) {?>
        <tr>
            <td align="left"><?= $row['link_id']?></td>
            <td align="left"><?= trim_right(substr($row['link_name'],0, 100)) ?></td>
            <td align="left"><?= $row['link_url']?></td>

            <td align="left"><?= date('Y-m-d H:i:s', $row['save_time'])?></td>

            <td align="left">
                <a href="<?= $row['link_url']?>" target="_blank">查看</a>|
                <a href="<?=$this->url(array('module' => 'admin', 'controller' => 'link', 'action' => 'set','link_id' => $row['link_id']), '', true); ?>">编辑</a>|<span class="delete">
                <a href="<?=$this->url(array('module' => 'admin', 'controller' => 'link', 'action' => 'del','link_id' => $row['link_id']), '', true); ?>">删除</a></span>
            </td>
        </tr>
        <? } ?>
    </table>
</div>
<div class="btn_div">
    <input class="button" type="submit" value=" 保存编辑 " name="submit"/>
    <input class="button" type="button" onclick="history.go(-1)" value="返回上一页" name="return"/>
</div>
</form>
<?=$this->render('footer.php');?>
