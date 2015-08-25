<?=$this->render('header.php');?>
<script type="text/javascript" src="/scripts/mcdropdown/jquery.bgiframe.js"></script>
<script type="text/javascript" src="/scripts/mcdropdown/jquery.mcdropdown.min.js"></script>
<script type="text/javascript" src="/editors/fckeditor/fckeditor.js"></script> <!--载入fckeditor类-->
<link type="text/css" href="/scripts/mcdropdown/jquery.mcdropdown.css" rel="stylesheet" media="all" />
<script type="text/javascript" language="javascript">
$().ready(function() {
    $("#category").mcDropdown("#categorymenu");
});
</script>

<form id="form1" name="form1" method="post" action="<?=!isset($this->editRow['art_id']) ? $this->url(array('module' => 'admin', 'controller' => 'article', 'action' => 'add'), '', true) : $this->url(array('module' => 'admin', 'controller' => 'article', 'action' => 'edit'), '', true)?>">
<div class="content_div">
    <table class="tablegrid" width="100%" cellspacing="0" cellpadding="0" border="0">
       <tr>
            <td>标题</td>
            <td align="left"><input name="title" type="text"  class="txt" id="title" size="100" value="<?=isset($this->editRow['title']) ? $this->editRow['title'] : '';?>"/></td>
        </tr>
        </tr>
        <tr>
            <td width="100">所属分类</td>
            <td width="900" align="left">
                <input type="text" name="cate_id" id="category" value="<?=isset($this->editRow['cate_id']) ? $this->editRow['cate_id'] : '';?>" />
                <ul id="categorymenu" class="mcdropdown_menu">
                <?= $this->treeRow;?>
                </ul>
            </td>
        </tr>
       <tr>
            <td>摘要</td>
            <td align="left">
                <?=$this->EditorXH(array('name' => 'brief', 'value' => isset($this->editRow['brief']) ? $this->editRow['brief'] : '', 'height' => '200', 'width' => '80%', 'uploadUrl' => 'http://www.yunphp.cn/admin/article/xhupload'));?>
            </td>
        </tr>
        <tr>
            <td>內容</td>
            <td align="left">
                <?=$this->Fck()->Create();?>
            </td>
        </tr>
    </table>
</div>
<div class="btn_div">
    <input type="hidden" name="art_id" value="<?=isset($this->editRow['art_id']) ? $this->editRow['art_id'] : '';?>" />
    <input class="button" type="submit" value="<?=!isset($this->editRow['art_id']) ? '添加文章'  : '保存编辑' ?> " name="submit"/>
    <input class="button" type="button" onclick="history.go(-1)" value="返回上一页" name="return"/>
</div>
</form>
<?=$this->render('footer.php');?>