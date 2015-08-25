<?=$this->render('header.php');//显示模版?>

<form id="form1" name="form1" method="post" action="<?=$this->url(array('module' => 'admin', 'controller' => 'article', 'action' => 'edit'), '', true)?>">
<div class="content_div">
	<table class="tablegrid" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td width="100">所属分类</td>
			<td width="900" align="left">
				<select name="select" id="select">
					<option>時事資訊</option>
					<option>內部資訊</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>标题</td>
			<td align="left"><input type="text" name="news_title"  class="txt" id="news_title"  value="<?php echo $this->row['news_title']?>"/></td>
		</tr>
		<tr>
			<td>简介</td>
			<td align="left"><textarea name="news_desc" id="news_desc"  class="txt" cols="45" rows="5"></textarea></td>
		</tr>
		<tr>
			<td>內容</td>
			<td align="left">
                <? $this->fckeditor->Create();?>
			</td>
		</tr>
		<tr>
			<td>錄入時間</td>
			<td align="left"><input type="text"  class="txt" name="posttime" id="posttime"  value="<?php echo date('Y-m-d H:i:s'); ?>"/></td>
		</tr>
		<tr>
			<td  class="del_td">錄入作者</td>
			<td align="left" class="del_td"><input type="text"  class="txt"  name="author" id="author"  value="regulusyun"/></td>
		</tr>
	</table>


</div>
<div class="btn_div">
	<input class="button" type="submit" value=" 保存编辑 " name="submit"/>
	<input class="button" type="button" onclick="history.go(-1)" value="返回上一页" name="return"/>
</div>
</form>
<?=$this->render('footer.php');?>