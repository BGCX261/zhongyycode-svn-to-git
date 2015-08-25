<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<div class="dataedit">
<form name="ruleAdd" id="ruleAdd" action="" method="post" class="allowKeySubmit">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <th width="100" align="right">资源名称</th>
    <td width="8"></td>
    <td align="left"><input type="text" name="res_name" size="20" /> <font color="red">*</font> <font color="gray">字符限制：英文字母+数字，2~20 个字符</font></td>
  </tr>
  <tr>
    <th align="right">资源说明</th>
    <td></td>
    <td align="left"><input type="text" name="res_desc" size="20" /> <font color="red">*</font>  <font color="gray">字符限制：2~80 个字符</font></td>
  </tr>
  <tr>
    <th align="right" valign="top">权限列表</th>
    <td></td>
    <td align="left"><? foreach ($privileges as $priv_name => $priv_desc) { ?>
      <div style="width:120px; float:left;"><input type="checkbox" name="privileges[]" value="<?=$priv_name?>" /> <?=$priv_name?> (<?=$priv_desc?>)</div>
      <? } ?></td>
  </tr>
  <tr>
    <th align="right">&nbsp;</th>
    <td></td>
    <td align="left"><input type="submit" name="submit" value=" 提 交 " />
    <input type="button" name="cancel" value=" 取 消 " /></td>
  </tr>
</table>
</form>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>