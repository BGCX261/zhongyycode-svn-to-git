<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>
<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#98caef" style="margin-top: 10px;">
    <tbody>
        <tr style="background: none repeat scroll 0% 0% rgb(236, 248, 255);">
        <th align="center" colspan="6">详细信息 [<a href="/admin/template/edit?id=<?=$row['id']?>">编辑</a>]</th>
        </tr>
        <tr>
            <td width="100"><b>ID</b></td>
            <td><?=$row['id']?></td><td width="100"><b>邮件模板名</b></td><td><?=$row['name']?> </td><td width="100"><b>邮件主题</b></td><td><?=$row['subject']?></td>
        </tr>
    <tr>
      <td><b>发件人</b></td><td><?=$row['sender']?></td>
      <td><strong>发件人邮箱</strong></td>
      <td><?=$row['sender_email']?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><b>匿名</b></td><td><?php if (@$row['anonymous']=='0') echo '匿名';?></td>
      <td><b>审核时间</b></td><td><?=date ('Y-m-d',$row['audite_date']);?></td><td></td><td></td></tr>
    <tr>
      <td><strong>专题内容</strong></td><td colspan="5"><span class="u0"><?=$row['template'] ?></span></td>
      </tr>
    </tbody>
</table>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

});
</script>