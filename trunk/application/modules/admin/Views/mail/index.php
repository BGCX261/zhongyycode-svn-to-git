<?=$this->render('header.php'); ?>
<form method="POST" enctype="multipart/form-data">
<div style="margin:10px;">邮件列表文件：<input type="file" name="email" size="60"/></div>
<div style="margin:10px;">发送内容文件：<input type="file" name="content" size="60"/></div>
<div style="margin:10px;">邮件标题：<input type="text" name="title" size="60"/> <input type="submit" value="发送" /></div>
</form>
<?=$this->render('footer.php'); ?>