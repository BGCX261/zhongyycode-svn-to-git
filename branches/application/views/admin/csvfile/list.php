<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
.page{float:right; text-align:right;margin-top:10px;}
</style>

<form method="get" id="list">
<fieldset>
  <legend>搜索</legend>
  状态:<select name="status">
        <option value="-1">全部</option>
        <option value="0" <?=Str::selected($status, 0)?>>未下载</option>
        <option value="1" <?=Str::selected($status, 1)?>>已下载</option>
        <option value="2" <?=Str::selected($status, 2)?>>下载失败</option>
      </select>
    <input type="hidden" name="sid" value="<?=$sid?>" />
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <td>ID</td>
    <td align="left">图片地址</td>
    <td align="left">图片ID</td>
    <td align="left">状态</td>
    <td>上传时间</td>
    <td>下载时间</td>

 </tr>
 <? foreach ($pagination as $item) {

    switch($item['status']) {
            case 0:$status='未下载'; break;
            case 1:$status='已下载'; break;
            case 2:$status ='下载失败';break;

        }
    ?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['sid']?>" /></td>
    <td><?=$item['sid']?></td>
    <td align="left"><a href="<?=$item['url']?>" title="<?=$item['url']?>" target="_blank"><?=Str::slice($item['url'], 30, '..')?></a></td>

    <td><a href="/<?=$item['img_id']?>.html" title="查看该图片" target="_blank"><?php echo $item['img_id']?></td>
    <td><font color="green"><?=$status?></font></td>
    <td><?=date('Y-m-d H:i:s', $item['add_time'])?></td>
    <td><?=date('Y-m-d H:i:s', $item['complete_time'])?></td>





  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>


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