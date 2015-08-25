<?=$this->render('header.php');?>
<style type="text/css">
.sort {cursor:pointer;}
</style>
<form action="">
<fieldset>
<legend>用户搜索</legend>
<input type="text" name="keyword" size=50 value=""/>
<select name="role">
<option value="0">选择角色</option>
<? foreach ($this->roles as $role) { ?>
<option value="<?=$role['role_id']?>" <?=($role['role_id'] == $this->roleId) ? 'selected' : ''?>><?=$role['mod_desc']?> -> <?=$role['role_desc']?></option>
<? } ?>
</select>
<input type="submit" value="搜索" />
</fieldset>

<table width="100%" class="tablegrid">
<tr>
<th id="uid" class="sort">用户ID</th>
<th id="username" class="sort">用户名</th>
<th id="email" class="sort">邮件地址</th>
<th id="reg_time" class="sort">注册时间</th>
<th id="reg_time" class="sort">上次登录时间</th>
<th id="reg_time" class="sort">上次登录ip</th>
<th>操作</th>
</tr>
<? foreach ($this->paginator as $user) { ?>
<tr>
<td><?=$user['uid']?></td>
<td><a href="/admin/user/info/uid/<?=$user['uid']?>" title="查看用户详情"><?=$user['username']?></a></td>
<td><?=$user['email']?></td>
<td><?=date('Y-m-d H:i', $user['reg_time'])?></td>
<td><?=date('Y-m-d H:i', $user['last_time'])?></td>
<td><?=$user['last_ip']?></td>
<td>
<a href="" title="编辑基本信息"><img src="/public/images/icon/edit.gif" /></a>
<a href="/admin/user/pass/uid/<?=$user['uid']?>" title="修改密码"><img src="/public/images/icon/set.gif" /></a>
<a href="/admin/user/role/uid/<?=$user['uid']?>" title="角色指派"><img src="/public/images/icon/group.gif" /></a>
<a href="" title="账户信息"><img src="/public/images/icon/account.gif" /></a>
</td>
</tr>
<? } ?>
</table>
</form>

<script type="text/javascript">
$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});
    $('th.sort').attr('title', '点击排序');
    $('th.sort').click(function(){
        $('#sort').val($(this).attr('id'));
        $("form:first").submit();
    })
    $('select[name=search_type]').val('<?=$searchType?>');
});
</script>
<?=$this->render('footer.php');?>