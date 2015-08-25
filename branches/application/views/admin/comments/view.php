<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>

<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#98caef" style="margin-top: 10px;">
    <tbody><tr style="background: none repeat scroll 0% 0% rgb(236, 248, 255);"><th align="center" colspan="6">详细信息 [<a href="/admin/comments/edit?cid=<?=$row['cid']?>">编辑</a>]</th></tr>
    <tr><td width="100"><b>ID</b></td>
    <td><?=$row['cid']?></td><td width="100"><b>应用名称</b></td><td><?=$row['app']?> </td><td width="100"><b>引用评论ID</b></td><td><?=$row['quote_id']?></td></tr>
    <tr>
      <td><b>作者</b></td><td><?=$row['username']?></td>
      <td><strong>作者IP</strong></td>
      <td><?=$row['author_ip']?></td>
      <td><b>发布时间</b></td>
      <td><?=date ('Y-m-d',$row['post_time'])?></td>
    </tr>
    <tr>
      <td><b>匿名</b></td><td><?php if ($row['anonymous']=='0') echo '匿名';?></td>
      <td><b>审核时间</b></td><td><?=date ('Y-m-d',$row['audite_date']);?></td><td></td><td></td></tr>
    <tr>
      <td><strong>引用评论</strong></td><td colspan="5"><span class="u0"><?=$row['quote'] ?></span></td>
      </tr>
    <tr>
      <td><strong>评论内容</strong></td><td colspan="5"><?=$row['content']?></td></tr>
    </tbody>
</table>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>