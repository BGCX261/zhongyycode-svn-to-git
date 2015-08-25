<?=$this->render('header.php') ?>
<div class="dataedit">
<form method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <? foreach ($this->rolesGroup as $modName => $roles) { ?>
  <tr>
	<th width="120" align="right"><?=$this->modules[$modName]?></th>
	<td width="5"></td>
	<td align="left"><select name="roles[<?=$modName?>]">
	<?
	if (isset($this->userRoles[$modName])) {
		$userRole = $this->userRoles[$modName];
	} else {
		$userRole = current($roles);
	}
	foreach ($roles as $role) {
	?>
	  <option value="<?=$role['role_id']?>" <?=$this->html()->selected($userRole['role_id'], $role['role_id'])?>><?=$role['role_name']?> (<?=$role['role_desc']?>)</option>
	<? } ?>
	</select>
	</td>
  </tr>
  <? } ?>
  <tr>
	<th width="120" align="right">&nbsp;</th>
	<td width="5"></td>
	<td height="30" align="left"><input type="submit" name="saveRole" value=" 保存 " />
	  <input type="reset" name="resetRole" value=" 重置 " />
	  <input type="button" name="return" value=" 返回 " onclick="history.back();" /></td>
  </tr>
</table>
</form>
</div>
<?=$this->render('footer.php') ?>