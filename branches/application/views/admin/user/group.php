<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.form.min.js"></script>
<form method="get" id="list">


<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th>组号</th>
    <th align="left">组名</th>
    <th align="left">空间大小(M)</th>
    <th align="left">年费用</th>
    <th align="left">月费用</th>
    <th >操作</th>
 </tr>
 <?php foreach ($pagination as $item) {?>
  <tr>
    <td><?=$item['id']?></td>
    <td align="left"><a href="/admin/user/list?rank=<?=$item['id']?>" title="查看该用户组下的用户"><?=$item['group_name']?></a></td>
    <td align="left"><?=$item['max_space']?></td>
    <td><?php echo $item['fee_year']?></td>
    <td><?php echo $item['fee_month']?></td>
    <td  width="10%" align="center">
    <a href="<?=$item['id']?>" title="查看用户"><img src="/images/icon/view.gif" /></a>
    <a href="/article/category/cate_id/<?=$item['id']?>" title="编辑用户"><img src="/images/icon/edit.gif"  alt="编辑用户"/></a>
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

$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>