<?=$this->render('header.php');?>
<form id="form1" name="form1" method="post" action="/admin/link/set">
<div class="content_div">
    <table class="tablegrid" width="100%" cellspacing="0" cellpadding="0" border="0">
       <tr>
            <td>名称</td>
            <td align="left"><input name="link_name" type="text"  class="txt" id="title" size="100" value="<?=isset($this->editRow['link_name']) ? $this->editRow['link_name'] : '';?>"/></td>
        </tr>
        </tr>
        <tr>
            <td>url地址</td>
            <td align="left"><input name="link_url" type="text"  class="txt" id="title" size="100" value="<?=isset($this->editRow['link_url']) ? $this->editRow['link_url'] : '';?>"/></td>
        </tr>
    </table>
</div>
<div class="btn_div">
    <input type="hidden" name="link_id" value="<?=isset($this->editRow['link_id']) ? $this->editRow['link_id'] : '';?>" />
    <input class="button" type="submit" value="<?=!isset($this->editRow['link_id']) ? '链接添加'  : '保存编辑' ?> " name="submit"/>
    <input class="button" type="button" onclick="history.go(-1)" value="返回上一页" name="return"/>
</div>
</form>
<?=$this->render('footer.php');?>