<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />
<style type="text/css">
label {display:inline;}
.page{float:right; text-align:right;margin-top:10px;}
</style>

<form method="get" id="list">
<fieldset>
  <legend>图片搜索</legend>
  图片名: <input type="text" name="keyword" size="30" value="<?=$keyword?>" />
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />
    <input type="checkbox" name="is_top" value="1" onclick="this.form.submit();" <? if ($is_top) { echo 'checked="checked"'; } ?> /> 美图推荐
    <input type="checkbox" name="is_share" value="1" onclick="this.form.submit();" <? if ($is_share) { echo 'checked="checked"'; } ?> /> 分享
    <input type="checkbox" name="is_flash" value="1" onclick="this.form.submit();" <? if ($is_flash) { echo 'checked="checked"'; } ?> /> 图片滚动
    上传时间：<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <td>ID</td>
    <td align="left">图片名</td>
    <td align="left">大小</td>
    <td>所属用户</td>
    <td>添加时间</td>
    <td>心情(赞/鄙视)</td>
    <td>存储目录</td>
    <td>美图推荐</td>
    <td>分享</td>
    <td>图片滚动</td>
    <td >操作</td>
 </tr>
 <? foreach ($pagination as $item) { ?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['id']?>" /></td>
    <td><?=$item['id']?></td>
    <td align="left"><a href="/<?=$item['disk_name'] . '/'. $item['picname']?>" title="查看图片" target="_blank"><?=Str::slice($item['custom_name'], 30, '..')?></a></td>
    <td align="left"><?=round($item['filesize']/ 1024) ?>KB</td>
    <td><a href="/admin/user/view?uid=<?=$item['userid']?>" title="查看用户资料"><?php echo $item['username']?></a></td>
    <td><?php echo date('Y-m-d H:i:s', $item['uploadtime'])?></td>
    <td><font color="green"><?=$item['support']?></font>/<font color="red"><?=$item['oppose']?></font></td>
    <td><?php echo $item['disk_name']?></td>
    <td><img src="/images/<?=$item['is_top']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['id']?>, 'is_top');" /></td>
    <td><img src="/images/<?=$item['is_share']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['id']?>, 'is_share');" /></td>
    <td><img src="/images/<?=$item['is_flash']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['id']?>, 'is_flash');" /></td>
    <td  width="10%" align="center">
    <a href="/<?=$item['id']?>.html" title="查看" target="_blank"><img src="/images/icon/view.gif" /></a>

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
     $("#list").attr('action', '/admin/pics/delPic').attr('method', 'post').submit();
}

function setStat(obj, id, type) {
    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/admin/pics/setStat', {'pid': id, 'val': val, 'type': type});
}

$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});
    $('.date').datepicker({yearRange:'-5:5'});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>