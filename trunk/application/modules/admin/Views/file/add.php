<?=$this->render('header.php') ?>
<div class="dataedit">
<form name="fileupload" id="fileupload" action="" method="post" class="allowKeySubmit" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="tableedit">
 <tr>
    <th align="right">所属分类</th>
    <td></td>
    <td><select name="cate_id">
    <? foreach ($this->categories as $cate) { ?>
    <option value="<?=$cate['cate_id']?>" title="<?=$cate['description']?>" <?=$this->html()->selected($this->cateId, $cate['cate_id'])?>><?=$cate['cate_name']?></option>
    <? } ?>
    </select>
    <font color="red">*</font></td>
  </tr>
  <tr>
    <th width="100" align="right">选择文件</th>
    <td width="5"></td>
    <td><input type="file" name="file" size="25" />
    <font color="red">*</font></td>
  </tr>
  <tr>
    <th align="right">文件描述</th>
    <td></td>
    <td><input type="text" name="description" size="80" maxlength="250" /></td>
  </tr>
  <tr>
    <th width="100" align="right">&nbsp;</th>
    <td width="5"></td>
    <td><input type="button" name="save" value=" 保 存 " onclick="this.form.submit();" />
      <input type="reset" name="reset" value=" 重 置 " />
      <input type="button" name="cancel" value=" 取 消 " onclick="history.back();" /></td>
  </tr>
</table>
</form>
</div>
<?=$this->render('footer.php') ?>