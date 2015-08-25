<?=$this->render('header.php'); ?>
<form action="" method="POST">
<input type="hidden" name="uid" value="<?=$this->info['uid']?>"/>
<table cellspacing="5">
    <tr><td><b>用户名：</b></td><td><?=$this->info['username']?></td></tr>
    <tr><td><b>用户密码：</b></td><td><input type="text" name="password" value=""/> (不输入表示不改变原有密码)</td></tr>
    <tr><td><b>再次输入用户密码：</b></td><td><input type="text" name="confirmPwd" value=""/></td></tr>
    <tr><td colspan="2"><input type="submit" value="提交"/> <input type="reset" value="重置" /></td></tr>
</table>
</form>
<?=$this->render('footer.php'); ?>