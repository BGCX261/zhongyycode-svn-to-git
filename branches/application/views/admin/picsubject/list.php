<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>

<form method="get" id="list">
<fieldset>
  <legend>专题搜索</legend>
  专题名称: <input type="text" name="keyword" size="30" value="<?=$keyword?>" />
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />
    <input type="checkbox" name="is_top" value="1" onclick="this.form.submit();" <? if ($is_top) { echo 'checked="checked"'; } ?> /> 推荐
    <input type="checkbox" name="is_share" value="1" onclick="this.form.submit();" <? if ($is_share) { echo 'checked="checked"'; } ?> /> 分享
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <td>ID</td>
    <td align="left">专题名称</td>
    <td>所属用户</td>
    <td>添加时间</td>
    <td>点击数</td>
    <td>评论</td>
    <td>心情(赞/鄙视)</td>
    <td>推荐</td>
    <td>分享</td>
    <td >操作</td>
 </tr>
 <? foreach ($pagination as $item) { ?>
  <tr>
    <td align="left"><input type="checkbox" name="sid[]" value="<?=$item['sid']?>" /></td>
    <td><?=$item['sid']?></td>
    <td align="left"><a href="/picsubject/<?=$item['sid']?>.html" title="查看专题" target="_blank"><?=$item['title']?></a></td>

    <td><?=$item['username']?></td>
    <td><?=date('Y-m-d H:i:s', $item['add_time'])?></td>
    <td><?=$item['click']?></td>
    <td><?=$item['comment']?></td>
    <td><font color="green"><?=$item['support']?></font>/<font color="red"><?=$item['oppose']?></font></td>
    <td><img src="/images/<?=$item['is_top']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['sid']?>, 'is_top');" /></td>
    <td><img src="/images/<?=$item['is_share']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['sid']?>, 'is_share');" /></td>
    <td  width="10%" align="center">
    <a href="/picsubject/<?=$item['sid']?>.html" title="查看专题" target="_blank" ><img src="/images/icon/view.gif" /></a>
    <a href="/admin/picsubject/edit?sid=<?=$item['sid']?>" title="编辑专题"><img src="/images/icon/edit.gif"  alt="编辑相册"/></a>
    <a href="/admin/picsubject/del?sid=<?=$item['sid']?>" title="删除专题"><img src="/images/icon/delete.gif"  alt="编辑相册"/></a>
  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>
<br />
<input type="button" value="批量删除"  onclick="delPic();"/>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function delPic(){
     $("#list").attr('action', '/admin/picsubject/del').attr('method', 'post').submit();
}

function setStat(obj, id, type) {
    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/admin/picsubject/setStat', {'sid': id, 'val': val, 'type': type});
}

$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="sid[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>