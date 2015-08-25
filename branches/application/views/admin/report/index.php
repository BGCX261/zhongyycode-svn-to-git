<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}

#content {background:#ECF5FC; border:#0099CC 1px solid; width:500px; padding:3px 5px; position:absolute; display:none;}
#content .h {border-bottom:1px dashed #0099CC; width:100%; text-align:right; margin:5px 0;}
#content .c {}
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
    <th>应用名称</th>
    <th align="left">举报来源</th>
    <th align="left">举报内容</th>
    <th align="left">添加时间</th>
    <th >操作</th>
 </tr>
 <?php foreach ($pagination as $item) {?>
  <tr>

    <td><?=$item['id']?></td>
    <td align="left"><a href="/<?=($item['app'] == 'pic')? '' : 'articles/'?><?=$item['item_id']?>.html" title="查看" target="_blank"><?=$item['item_id']?></a></td>
    <td align="left"><?=($item['app'] == 'pic')? '图片' : '图书馆'?></td>
    <td align="left"><a href="javascript:" onclick="showContent(this);" title="<?=$item['content']?>"><?=Str::slice($item['content'], 60, '..')?></a></td>
    <td><?=date('Y-m-d H:i:s',$item['add_time'])?></td>
    <td align="center">
    <a href="/admin/report/del?id=<?=$item['id']?>" class="delete" title="删除"><img src="/images/icon/trash.gif" /></a>
    </td>
  </tr>
  <? } ?>
</table>
<br />
</fieldset>
</form>

<div id="content">
<div class="h"><a href="javascript:" onclick="$('#content').hide();">关闭</a></div>
<div class="c"></div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function showContent(obj)
{
    $('#content > .c').html(obj.title);
    $('#content').css('left', $(obj).offset().left - 100);
    $('#content').css('top', $(obj).offset().top);
    $('#content').show();
}
$(document).ready(function() {

});
</script>