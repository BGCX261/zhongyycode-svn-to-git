<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<form method="get" id="list">

<table class="tablegrid" width="100%" style="text-align:left;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <th>评论id</th>
    <th align="left">评论内容</th>
    <th align="left">评论者</th>
    <th align="left">应用名称</th>
    <th align="left">评论时间</th>
    <th align="left">评论IP</th>
    <th align="left">显示</th>
    <th align="left">置顶</th>
    <th >操作</th>
 </tr>
 <?php foreach ($results as $item) {?>
  <tr>
    <td align="left"><input type="checkbox" name="cid[]" value="<?=$item['cid']?>" /></td>
    <td><?=$item['cid']?></td>
    <td align="left"><a href="/articles/<?=$item['item_id']?>.html" title="查看评论" target="_blank"><?=$item['content']?></a></td>
    <td align="left"><?php if(empty($item['username'])) { ?> 匿名 <?php } else { ?><a href="/admin/article/list?uid=<?=$item['uid']?>" title="查看该用户下的图书"><?=$item['username']?><?php } ?></td>
    <td><?=$arr_app[$item['app']]?></td>
    <td><?=date('Y-m-d H:i', $item['post_time']);?></td>
    <td><?=$item['author_ip']?></td>
    <td><img src="/images/<?=$item['is_show']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['cid']?>, 'is_show');" /></td>
    <td><img src="/images/<?=$item['is_top']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['cid']?>, 'is_top');" /></td>
    <td>
    <a href="/admin/comments/view?cid=<?=$item['cid']?>" title="查看详细"><img src="/images/icon/view.gif" /></a>
    <a href="/admin/comments/edit/?cid=<?=$item['cid']?>" title="编辑文章"><img src="/images/icon/edit.gif"  alt="编辑文章"/></a>  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>
<br />
<input type="button" value="批量删除"  onclick="delPic();"/>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function delPic(){
     $("#list").attr('action', '/admin/comments/delbook').attr('method', 'post').submit();
}


function setStat(obj, id, type) {
    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/admin/comments/setstat', {'cid': id, 'val': val, 'type': type});
}
$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="cid[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>