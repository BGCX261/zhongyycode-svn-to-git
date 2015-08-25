<?=$this->render('header.php') ?>
<form method="post" action="" name="fileCateList">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablegrid">
  <tr>
    <th>名称</th>
    <th align="left">路径</th>
    <th align="left">描述</th>
    <th align="center">上传</th>
    <th align="center">删除</th>
    <th align="center">文件数</th>
  <th align="center">操作</th>
  </tr>
  <?
    $basepath = rtrim(str_replace(array(WEB_DIR, '\\'), array('', '/'), $this->fileBasePath), '/') . '/';
    if (empty($this->categories)) { ?>
  <tr>
    <td colspan="" align="left" height="40"><span class="warning">未找到文件分类数据</span></td>
  </tr>
  <?
    } else {
        foreach ($this->categories as $cate) {
  ?>
  <tr>
    <td><?=$cate['cate_name']?></td>
    <td align="left"><?=$basepath . $cate['filepath']?></td>
    <td align="left"><?=$cate['description']?></td>
    <td align="center"><img src="/images/<?=$cate['allow_upload'] ? 'yes' : 'no'?>.gif" alt="<?=$cate['allow_upload'] ? '允许' : '禁止'?>" /></td>
    <td align="center"><img src="/images/<?=$cate['allow_delete'] ? 'yes' : 'no'?>.gif" alt="<?=$cate['allow_delete'] ? '允许' : '禁止'?>" /></td>
    <td align="center"><?=$cate['file_count']?></td>

    <td align="center">
    <a href="javascript:setEdit('<?=implode("', '", $cate)?>');" title="编辑"><img src="/public/images/icon/application_edit.gif" /></a>
    <a href="<?=$this->url(array('action' => 'cateClean', 'id' => $cate['cate_id']))?>" onclick="return confirm('确定要清除该分类下的所有文件吗？')" title="清除分类下的所有文件"><img src="/public/images/icon/lightning_delete.gif" /></a>
    <a href="<?=$this->url(array('action' => 'cateDel', 'id' => $cate['cate_id']))?>" class="delete" title="删除"><img src="/public/images/icon/trash.gif" /></a>
    </td>
  </tr>
  <?
        }
    }
  ?>
  <tr>
    <td><input type="text" name="cate_name" size="20" maxlength="50" /> <font color="red">*</font></td>
    <td align="left"><?=$basepath?><input type="text" name="filepath" size="15" maxlength="100" /> <font color="red">*</font></td>
    <td align="left"><input type="text" name="description" size="40" maxlength="255" /></td>
    <td align="center"><input type="checkbox" name="allow_upload" value="1" checked="checked" /></td>
    <td align="center"><input type="checkbox" name="allow_delete" value="1" checked="checked" /></td>
    <td align="center">&nbsp;</td>
    <td align="center">
    <input type="submit" name="add" id="add" value="添加" onclick="this.form.action='<?=$this->url(array('action' => 'cateadd'))?>'" />
    <input type="submit" name="edit" id="edit" value="修改" disabled="disabled" onclick="this.form.action='<?=$this->url(array('action' => 'cateEdit'))?>'" />
    <input type="hidden" name="cate_id" /></td>
  </tr>
</table>
</form>
<?=$this->render('footer.php') ?>
<script language="javascript" type="text/javascript">
function setEdit(id, name, path, desc, upd, del, count) {
    var form = document.fileCateList;
    form.cate_id.value = id;
    form.cate_name.value = name;
    form.filepath.value = path;
    form.description.value = desc;
    form.allow_upload.checked = (upd == 1) ? true : false;
    form.allow_delete.checked = (del == 1) ? true : false;
    form.edit.disabled = false;
}
</script>
