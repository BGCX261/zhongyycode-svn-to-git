<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>

<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#98caef" style="margin-top: 10px;">
    <tbody><tr style="background: none repeat scroll 0% 0% rgb(236, 248, 255);"><th align="center" colspan="6">详细信息 [<a href="/admin/point/edit?id=<?=$row['id']?>">编辑</a>]</th></tr>
    <tr><td width="100"><b>ID</b></td>
    <td><?=$row['id']?></td><td width="100"><b>用户名</b></td><td><?=$row['uname']?> </td><td width="100"><b>积分</b></td><td><?=$row['points']?></td></tr>
    <tr>
      <td><b>任务标题</b></td><td><?=$row['title']?></td>
      <td><strong>URL</strong></td>
      <td><?=$row['url']?></td>
      <td><b>审核状态</b></td>
      <td><?=$row['status']?></td>
    </tr>
    <tr>
      <td><b>提交时间</b></td><td><?=$row['submit_date']?></td>
      <td><b>审核时间</b></td><td><?=$row['audite_date'];?></td><td></td><td></td></tr>
    <tr>
      <td><strong>任务描述</strong></td><td colspan="5"><span class="u0"><?=$row['description'] ?></span></td>
      </tr>
    <tr>
      <td><strong>审核评语</strong></td><td colspan="5"><?=$row['audite_memo']?></td></tr>
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