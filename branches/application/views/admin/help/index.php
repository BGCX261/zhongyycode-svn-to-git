<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>

<form method="post" action="/admin/disk/<?php echo (empty($info)) ? 'add' : 'edit';?>" id="list">
<fieldset>
  <legend>信息列表</legend>
<div align="center">
<?php echo $pagination->render('pagination/digg');?>
</div>
<table class="tablegrid" width="100%" >
 <tr>
    <th>ID</th>
    <th align="left">所属目录</th>
    <th align="left">文档标题</th>
    <th align="left">文档名</th>
    <th align="left">用户名</th>
    <th align="left">添加时间</th>
    <th align="left">公告</th>
    <th align="left">问题</th>
    <th >操作</th>
 </tr>
 <?php foreach ($pagination as $item) {?>
  <tr>

    <td><?=$item['id']?></td>
    <td align="left"><?=($item['cid'] == 1)? '帮助' : '关于'?></td>
    <td align="left"><?=$item['cname']?></td>
    <td><?php echo $item['title']?></td>
    <td><?php echo $auth['username']?></td>
    <td width="170"><?php echo $item['addtime']?></td>
    <td><img src="/images/<?=$item['is_notice']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['id']?>, 'is_notice');" /></td>
    <td><img src="/images/<?=$item['is_question']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['id']?>, 'is_question');" /></td>
    <td align="center">

    <a href="/admin/help/edit?id=<?=$item['id']?>" title="编辑"><img src="/images/icon/edit.gif"  alt="编辑"/></a>
    <a href="/admin/help/view?id=<?=$item['id']?>" title="详细" ><img src="/images/icon/view.gif"  alt="详细"/></a>
    <a href="/admin/help/del?id=<?=$item['id']?>" class="delete" title="删除"><img src="/images/icon/delete.gif" /></a>
    </td>
  </tr>
  <? } ?>
</table>
<br />
</fieldset>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function edit(){
     $("#list").attr('action', '/admin/disk/edit').attr('method', 'post').submit();
}
function setStat(obj, id, type) {
    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/admin/help/setstat', {'id': id, 'val': val, 'type': type});
}
$(document).ready(function() {
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>