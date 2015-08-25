<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
.page{float:right; text-align:right;margin-top:10px;}
</style>

<form method="get" id="list">
<fieldset>
  <legend>搜索</legend>
  文件名: <input type="text" name="keyword" size="30" value="<?=$keyword?>" />
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />
  状态:<select name="status">
        <option value="-1">全部</option>
        <option value="0" <?=Str::selected($status, 0)?>>排队中</option>
        <option value="1" <?=Str::selected($status, 1)?>>已完成</option>
        <option value="2" <?=Str::selected($status, 2)?>>空间不足,部分完成</option>
        <option value="3" <?=Str::selected($status, 3)?>>图片地址不符合搬家规则</option>
        <option value="4" <?=Str::selected($status, 4)?>>正在搬家</option>
        <option value="5" <?=Str::selected($status, 5)?>>图片已经下载完</option>
      </select>
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <td>ID</td>
    <td align="left">文件名</td>
    <td align="left">大小</td>
    <td align="left">新文件</td>
    <td align="left">用户</td>
    <td>上传时间</td>
    <td>状态</td>
    <td>操作</td>
 </tr>
 <? foreach ($pagination as $item) {
        switch($item['status']) {
            case 0:$status='排队中...'; break;
            case 1:$status='已完成'; break;
            case 2:$status =' 空间不足,部分完成';break;
            case 3:$status ='图片地址不符合搬家规则';break;
            case 4:$status='正在搬家...';break;
            case 5:$status='图片已经下载完...';break;
        }

    ?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['id']?>" /></td>
    <td><?=$item['id']?></td>
    <td align="left"><a href="/src_csv/<?=$item['uid']?>/<?=$item['src_file']?>" title="<?=$item['csv_file']?>" target="_blank"><?=Str::slice($item['csv_file'], 30, '..')?></a></td>
    <td align="left"><?=round($item['freesize']/ 1024) ?>KB</td>
    <td><a href="/dest_csv/<?=$item['uid']?>/<?=$item['dest_file']?>" title="<?=$item['dest_file']?>" target="_blank"><?php echo $item['dest_file']?></a></td>
    <td align="left"><a href="/admin/user/view?uid=<?=$item['uid']?>" ><?=$item['uname']?></a></td>
    <td><?=$item['upload_time']?></td>
    <td><font color="green"><?=$status?></font></td>


    <td  width="10%" align="center">
    <a href="/admin/csvfile/list?sid=<?=$item['id']?>" title="查看该文件下的图片" ><img src="/images/icon/view.gif" /></a>
    <a href="/admin/csvfile/del?sid=<?=$item['id']?>" title="删除" ><img src="/images/icon/trash.gif" /></a>

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