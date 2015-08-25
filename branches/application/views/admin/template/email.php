<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<form method="get" id="list">
<fieldset>
  <legend>信息搜索</legend>
  邮件模板名: <input type="text" name="name" size="30" value="<?=$keyname;?>" />
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <td>ID</td>
    <td align="left">邮件模板名</td>
    <td align="left">邮件主题</td>
    <td align="left">发件人</td>
    <td align="left">件人发邮箱</td>

    <td >操作</td>
 </tr>
 <? foreach ($pagination as $item) { ?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['id']?>" /></td>
    <td><?=$item['id']?></td>
    <td align="left"><?=$item['name']?></td>
    <td align="left"><?=$item['subject']?></td>
    <td align="left"><?=$item['sender']?></td>
    <td  width="15%" align="left"><?=$item['sender_email']?></td>

    <td align="center">
    <a href="/admin/template/view?id=<?=$item['id']?>" title="详细信息" ><img src="/images/icon/view.gif" /></a>
    <a href="/admin/template/edit?id=<?=$item['id']?>" title="编辑" ><img src="/images/icon/edit.gif" /></a>
    </td>
  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>
<br />
<input type="button" value="批量删除"  onclick="del();"/>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function del(){
     $("#list").attr('action', '/admin/template/del').attr('method', 'post').submit();
}



$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>