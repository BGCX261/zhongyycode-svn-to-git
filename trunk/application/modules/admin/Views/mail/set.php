<? $this->render('header') ?>

<form method="POST">
<table class="tablegrid" width="100%">
<tr><td><b>邮件服务器：</b></td><td><input type="text" name="host" size="100" value="<?=$mail->host?>"/></td></tr>
<tr><td><b>用户名：</b></td><td><input type="text" name="username" size="50" value="<?=$mail->config->username?>"/></td></tr>
<tr><td><b>密码：</b></td><td><input type="text" name="password" size="50" value="<?=$mail->config->password?>"/></td></tr>
<tr><td colspan="2"><input type="submit" value="保存" /></td></tr>
</table>
</form>

<? $this->render('footer') ?>