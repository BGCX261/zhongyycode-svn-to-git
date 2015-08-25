<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<form name="privileges" id="privileges" action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablegrid">
  <tr>
    <th align="left">名称</th>
    <th align="left">说明</th>
    <? if (Auth::getInstance()->hasAllow(array('privilege.add', 'privilege.edit', 'privilege.delete'))) { ?><th align="center">操作</th><? } ?>
  </tr>
  <? foreach ($privilege as $priv_name => $priv_desc) { ?>
  <tr>
    <td align="left"><?=$priv_name?></td>
    <td align="left"><?=$priv_desc?></td>
    <? if (Auth::getInstance()->hasAllow(array('privilege.add', 'privilege.edit', 'privilege.delete'))) { ?><td align="center">
    <? if (Auth::getInstance()->isAllow('privilege.edit')) { ?><a href="javascript:setEdit('<?=$priv_name?>', '<?=$priv_desc?>');" title="编辑"><img src="/images/icon/edit.gif" /></a><? } ?>
    <? if (Auth::getInstance()->isAllow('privilege.delete')) { ?><a href="/admin/privilege/del?priv_name=<?=$priv_name?>" class="delete" title="删除"><img src="/images/icon/trash.gif" /></a><? } ?>
    </td><? } ?>
  </tr>
  <? } ?>
  <? if (Auth::getInstance()->hasAllow(array('privilege.add', 'privilege.edit'))) { ?>
  <tr>
    <td align="left"><input type="text" name="new_priv_name" id="new_priv_name" size="20" maxlength="20" /> <font color="red">*</font></td>
    <td align="left"><input type="text" name="priv_desc" id="priv_desc" size="50" maxlength="80" /> <font color="red">*</font></td>
    <td align="center">
    <? if (Auth::getInstance()->isAllow('privilege.add')) { ?><input type="submit" name="add" id="add" value="添加" onclick="this.form.action='/admin/privilege/add'" /><? } ?>
    <? if (Auth::getInstance()->isAllow('privilege.edit')) { ?><input type="submit" name="edit" id="edit" value="修改" disabled="disabled" onclick="this.form.action='/admin/privilege/edit'" /><? } ?>
    <input type="hidden" name="priv_name" />
  </tr>
  <? } ?>
</table>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<? if (Auth::getInstance()->isAllow('privilege.edit')) { ?>
<script type="text/javascript" language="javascript">
function setEdit(priv_name, priv_desc) {
    var form = document.privileges;
    form.new_priv_name.value = priv_name;
    form.priv_desc.value = priv_desc;
    form.priv_name.value = priv_name;
    form.new_priv_name.focus();
    form.edit.disabled = false;
}
</script>
<? } ?>