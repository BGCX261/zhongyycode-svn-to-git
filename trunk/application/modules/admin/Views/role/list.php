<?=$this->render('header.php');?>
<form name="roles" id="roles" action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablegrid">
  <tr>
    <th align="left">角色组名称</th>
    <th align="left">定义</th>
    <th align="center">等级</th>
    <th align="center">游客</th>
    <th align="center">默认</th>
    <th align="center">操作</th>
  </tr>
  <? foreach ($this->roles as $role) { ?>
  <tr>
    <td><?=$role['role_name']?></td>
    <td><?=$role['role_desc']?></td>
    <td align="center"><?=$role['role_level']?></td>
    <td align="center"><img src="/images/icon/<?=$role['is_guest'] ? 'yes' : 'no';?>.gif" /></td>
    <td align="center"><img src="/images/icon/<?=$role['is_default'] ? 'yes' : 'no';?>.gif" /></td>
    <td align="center">
    <a href="<?=$this->url(array('controller' => 'acl', 'action' => 'assign', 'role_id' => $role['role_id']))?>" title="权限指派"><img src="/images/icon/group_go.gif" /></a>
    <a href="javascript:setEdit('<?=$role['role_id']?>', '<?=$role['role_name']?>', '<?=$role['role_desc']?>', '<?=$role['role_level']?>', '<?=$role['is_guest']?>', '<?=$role['is_default']?>');" title="编辑"><img src="/images/icon/edit.gif" /></a>
    <a href="<?=$this->url(array('action' => 'del', 'role_id' => $role['role_id']))?>" class="delete" title="删除"><img src="/images/icon/trash.gif" /></a>
    </td>
  </tr>
  <? } ?>

  <tr>
    <td align="left"><input type="text" name="role_name" id="role_name" size="20" maxlength="20" /> <font color="red">*</font></td>
    <td align="left"><input type="text" name="role_desc" id="role_desc" size="50" maxlength="80" /> <font color="red">*</font></td>
    <td align="center"><input type="text" name="role_level" id="role_level" size="3" maxlength="3" value="0" /></td>
    <td align="center"><input type="checkbox" name="is_guest" id="is_guest" value="1" /></td>
    <td align="center"><input type="checkbox" name="is_default" id="is_default" value="1" /></td>
    <td align="center">
    <input type="hidden" name="modName" value="<?=$this->modName;?>" />
    <input type="submit" name="add" id="add" value="添加" onclick="this.form.action='<?=$this->url(array('action' => 'add'))?>'" />
    <input type="submit" name="edit" id="edit" value="修改" disabled="disabled" onclick="this.form.action='<?=$this->url(array('action' => 'edit'))?>'" />
    <input type="button" name="button" value="取消" onclick="location.href='http://www.yunphp.cn/admin/role/list/mod_name/admin';">
    <input type="hidden" name="role_id" /></td>
  </tr>

</table>
</form>


<script type="text/javascript" language="javascript">
var form = document.roles;
form.is_guest.onclick = function(){
    form.is_default.disabled = this.checked;
};
form.is_default.onclick = function(){
    form.is_guest.disabled = this.checked;
};
form.onsubmit = function(){
    if (form.is_guest.checked && form.is_default.checked) {
        alert('不能同时设定为游客及默认角色!');
        return false;
    } else if (form.is_guest.checked && !confirm('您选择了设定为游客角色，请确认是否要替换掉原有的游客角色？')) {
        return false;
    } else if (form.is_default.checked && !confirm('您选择了设定为默认角色，请确认是否要替换掉原有的默认角色？')) {
        return false;
    }
    return true;
};

function setEdit(role_id, role_name, role_desc, role_level, is_guest, is_default) {
    form.role_id.value = role_id;
    form.role_name.value = role_name;
    form.role_desc.value = role_desc;
    form.role_level.value = role_level;
    form.is_default.disabled = form.is_guest.checked = is_guest == 1 ? true : false;
    form.is_guest.disabled = form.is_default.checked = is_default == 1 ? true : false;
    form.edit.disabled = false;
    form.add.disabled = "disabled";
}

</script>

<?=$this->render('footer.php');?>