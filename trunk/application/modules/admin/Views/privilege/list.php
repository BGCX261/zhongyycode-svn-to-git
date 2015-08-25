<?=$this->render('header.php'); ?>
<form name="privileges" id="privileges" action="<?=$this->url(array('module' => 'admin', 'controller' => 'privilege', 'action' => 'add'), '', true);?>" method="post"><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablegrid" style="margin:5px;">
  <tr>
    <th align="left">名称</th>
    <th align="left">说明</th>
    <th align="center">操作</th>
  </tr>
  <? foreach ($this->privileges as $priv_name => $priv_desc) { ?>
  <tr>
    <td align="left"><?=$priv_name?></td>
    <td align="left"><?=$priv_desc?></td>
    <td align="center">
    <a href="javascript:setEdit('<?=$priv_name?>', '<?=$priv_desc?>');" title="编辑"><img src="/public/images/icon/edit.gif" /></a>
    <a href="<?=$this->url(array('module' => 'admin', 'controller' => 'privilege', 'action' => 'del', 'priv_name' => $priv_name), '', true);?>" class="delete" title="删除"><img src="/public/images/icon/trash.gif" /></a>
    </td>
  </tr>
  <? } ?>
  <tr>
    <td align="left"><input type="text" name="new_priv_name" id="new_priv_name" size="20" maxlength="20" /> <font color="red">*</font></td>
    <td align="left"><input type="text" name="priv_desc" id="priv_desc" size="50" maxlength="80" /> <font color="red">*</font></td>
    <td align="center">
    <input type="submit" name="add" id="add" value="添加"  />
    <input type="submit" name="edit" id="edit" value="修改" disabled="disabled" onclick="this.form.action='<?=$this->url(array('module' => 'admin', 'controller' => 'privilege', 'action' => 'edit'), '', true);?>'" />
    <input type="hidden" name="priv_name" />
  </tr>

</table>
</form>
<?=$this->render('footer.php'); ?>

<script type="text/javascript" language="javascript">
function setEdit(priv_name, priv_desc) {
    var form = document.privileges;
    form.new_priv_name.value = priv_name;
    form.priv_desc.value = priv_desc;
    form.priv_name.value = priv_name;
	form.new_priv_name.focus();
    form.edit.disabled = false;
}

$("form").submit(function(){
    if ($("input[name=new_priv_name]").val() == '') {
        alert('请输入权限名称');
        return false;
    }
});
</script>
