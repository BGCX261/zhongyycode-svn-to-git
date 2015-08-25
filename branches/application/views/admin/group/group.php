<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<form method="post" action="/admin/group/<?php echo (empty($info)) ? 'add' : 'edit';?>" id="list">
<fieldset>
  <legend><?php echo (empty($info)) ? '添 加' : '编辑';?>用户组</legend>
  组名: <input type="text" name="group_name" size="20" value="<?php echo @$info['group_name']?>" />
  空间大小: <input type="text" name="max_space" size="5" value="<?php echo @$info['max_space']?>" />
  年费用: <input type="text" name="fee_year" size="5" value="<?php echo @$info['fee_year']?>" />
  月费用: <input type="text" name="fee_month" size="5" value="<?php echo @$info['fee_month']?>" />
  目录限制: <input type="text" name="dir_limit" size="5" value="<?php echo @$info['dir_limit']?>" />
  单文件限制: <input type="text" name="max_limit" size="5" value="<?php echo @$info['max_limit']?>" />
       <input type="hidden" name="id" size="30" value="<?php echo @$info['id']?>" />
       <input type="submit" name ="" value="<?php echo (empty($info)) ? '添 加' : '编辑';?>" />
       <?php echo (!empty($info)) ? '<a href="/admin/group/group">添 加</a>' : '';?>
</fieldset>
<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th>组号</th>
    <th align="left">组名</th>
    <th align="left">空间大小(M)</th>
    <th align="left">年费用</th>
    <th align="left">月费用</th>
    <th align="left">目录限制</th>
    <th align="left">单文件限制</th>
    <th >操作</th>
 </tr>
 <? foreach ($pagination as $item) {

 ?>
  <tr>
    <td><?=$item['id']?></td>
    <td align="left"><a href="/admin/user/list?rank=<?=$item['id']?>" title="查看该用户组下的用户"><?=$item['group_name']?></a></td>
    <td align="left"><?=$item['max_space']?>M</td>
    <td align="left"><?php echo $item['fee_year']?>元</td>
    <td align="left"><?php echo $item['fee_month']?>元</td>
    <td align="left"><?php echo $item['dir_limit']?>M</td>
    <td align="left"><?php echo $item['max_limit']?>K</td>

    <td  align="center">
    <a href="/admin/user/list?rank=<?=$item['id']?>" title="查看用户"><img src="/images/icon/view.gif" /></a>
    <a href="/admin/group/group?id=<?=$item['id']?>" title="编辑会员组"><img src="/images/icon/edit.gif"  alt="编辑会员组"/></a>
    <a href="/admin/group/del?id=<?=$item['id']?>" class="delete" title="删除会员组"><img src="/images/icon/delete.gif"  alt="删除会员组"/></a>
  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>
<br />

</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function delPic(){
     $("#list").attr('action', '/admin/pics/delPic').attr('method', 'post').submit();
}

$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>