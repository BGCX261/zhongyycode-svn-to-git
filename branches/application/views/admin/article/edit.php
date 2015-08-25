<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<fieldset>
<form method="POST" id="list" action="/admin/article/edit?id=<?=$article_id?>">
  <legend>图书信息修改</legend>
  <table class="tablegrid" width="100%" style="text-align:center;">
    <tr>
      <td width="9%">标题：</td>
      <td colspan="5"><input name="title" value="<?=$listInfo['title']?>"  size="80"/> </td>
      <td width="19%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
      <td>分类名称：</td>
      <td width="14%"><select name="cate_id" id="select">
      <?php
         foreach ($type as $key => $item) {?>
        <option value="<?=$item['cate_id']?>" <?=(@$cateInfo['parent_id'] == $item['cate_id'])?'selected':''?>>
        <? if ($item['parent_id'] > 0) {
            echo preg_replace(array('/0;\d+;/', '/\d+/', '/;/'), array('', '', '&nbsp; &nbsp; '), $item['path']);
            echo '|--';
        } ?> <?=$item['cate_name']?></option>
        <?php } ?>
      </select></td>
      <td width="9%">置顶：</td>
      <td width="13%"><select name="channel_top" >
        <option value="0" <?php if ($listInfo['channel_top']=='0') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['0']?></option>
        <option value="1" <?php if ($listInfo['channel_top']=='1') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['1']?></option>
      </select></td>
      <td width="12%">首页置顶：</td>
      <td width="24%"><select name="index_top" >
        <option value="0" <?php if ($listInfo['index_top']=='0') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['0']?></option>
        <option value="1" <?php if ($listInfo['index_top']=='1') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['1']?></option>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>美文推荐：</td>
      <td>
     <select name="index_recommend" >
          <option value="0"  <?php if ($listInfo['index_recommend']=='0') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['0']?></option>
          <option value="1"  <?php if ($listInfo['index_recommend']=='1') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['1']?></option>
      </select>      </td>
      <td>是否显示：</td>
      <td><select name="is_show" >
        <option value="0" <?php if ($listInfo['is_show']=='0') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['0']?></option>
        <option value="1" <?php if ($listInfo['is_show']=='1') {?> selected="selected" <?php } ?> ><?=$arr_yesOrNo['1']?></option>
      </select></td>
      <td>允许评论：</td>
      <td><select name="allow_comment" >
        <option value="0" <?php if ($listInfo['allow_comment']=='0') {?> selected="selected" <?php } ?>  ><?=$arr_yesOrNo['0']?></option>
        <option value="1" <?php if ($listInfo['allow_comment']=='1') {?> selected="selected" <?php } ?>  ><?=$arr_yesOrNo['1']?></option>
      </select></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="5">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td>摘要：</td>
      <td colspan="5"> <?php echo Editor::create('XH', array('name' => 'excerpt', 'value' =>$listInfo['excerpt'], 'width' => '650'));?> </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>内容：</td>
      <td colspan="5"> <?php echo Editor::create('XH', array('name' => 'content', 'value' =>$listInfo['content'], 'width' => '650'));?> </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="5"><input type="submit" name="button" id="button" value="修改" /><input type="button" onclick="javascript:history.back()" value="返回" class="button"></td>
      <td>&nbsp;</td>
    </tr>

  </table>
</form>
</fieldset>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>