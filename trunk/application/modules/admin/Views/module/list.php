<?=$this->render('header.php');?>
<form name="modules" id="modules" action="" method="post">
<table width="100%"border="0" cellspacing="0" cellpadding="0" class="tablegrid" style="margin-left:10px;">
  <tr>
    <th align="left">名称</th>
    <th align="left">说明</th>
    <th align="center">操作</th>
  </tr>
  <? foreach ($this->modules as $mod_name => $mod_desc) { ?>
  <tr>
    <td align="left"><?=$mod_name?></td>
    <td align="left"><?=$mod_desc?></td>
    <td align="center">
    <a href="<?=$this->url(array('controller' => 'role', 'action' => 'list', 'mod_name' => $mod_name))?>" title="角色管理"><img src="/images/icon/group.gif" /></a>
    <a href="<?=$this->url(array('controller' => 'rule', 'action' => 'list', 'mod_name' => $mod_name))?>" title="规则设定"><img src="/images/icon/cog.gif" /></a>
    <a href="<?=$this->url(array('controller' => 'acl', 'action' => 'assign', 'mod_name' => $mod_name))?>" title="权限指派"><img src="/images/icon/group_go.gif" />
    <a href="javascript:setEdit('<?=$mod_name?>', '<?=$mod_desc?>');" title="编辑模块"><img src="/images/icon/edit.gif" /></a>
    <a href="<?=$this->url(array('action' => 'del', 'mod_name' => $mod_name))?>" class="delete" title="删除模块"><img src="/images/icon/trash.gif" /></a>
    </td>
  </tr>
  <? } ?>
  <tr>
    <td align="left"><input type="text" name="new_mod_name" id="new_mod_name" size="20" maxlength="20" /> <font color="red">*</font></td>
    <td align="left"><input type="text" name="mod_desc" id="mod_desc" size="50" maxlength="80" /> <font color="red">*</font></td>
    <td align="center">
    <input type="submit" name="add" id="add" value="添加" onclick="this.form.action='<?=$this->url(array('action' => 'add'))?>'" />
    <input type="submit" name="edit" id="edit" value="修改" disabled disabled="disabled" onclick="this.form.action='<?=$this->url(array('action' => 'edit'))?>'" />
    <input type="hidden" name="mod_name" />
    </td>
  </tr>

</table>
</form>


<script type="text/javascript" language="javascript">
function setEdit(mod_name, mod_desc) {
    var form = document.modules;
    form.new_mod_name.value = mod_name;
    form.mod_desc.value = mod_desc;
    form.mod_name.value = mod_name;
    form.new_mod_name.focus();
    form.edit.disabled = false;
    form.add.disabled = "disabled";
}
$("form").submit(function(){
    if ($("input[name=new_mod_name]").val() == '') {
        alert('请输入模块名称');
        return false;
    }
});

</script>
<?=$this->render('footer.php');?>