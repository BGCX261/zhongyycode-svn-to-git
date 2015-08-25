<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.form.min.js"></script>
<form method="get">
<fieldset>
  <legend>相册搜索</legend>
  相册名: <input type="text" name="keyword" size="30" value="<?=$keyword?>" />
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>
</form>
<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <td>ID</td>
    <td align="left">相册名</td>
    <td>所属用户名</td>
    <td>图片数量</td>
    <td>创建时间</td>
    <td>显示</td>
    <td >操作</td>
 </tr>
 <? foreach ($pagination as $item) { ?>
  <tr>
    <td align="left"><input type="checkbox" name="cate_id[]" value="<?=$item['cate_id']?>" /></td>
    <td><?=$item['cate_id']?></td>
    <td align="left"><a href="/admin/pics/list?cate_id=<?=$item['cate_id']?>" title="查看该相册下的图片"><?=$item['cate_name']?></a>
    </td>
    <td><?php echo $item['username']?></td>
    <td><?=$item['img_num']?></td>
    <td><?=date('Y-m-d H:i:s', $item['create_date'])?></td>
    <td><img src="/images/<?=$item['is_show']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['cate_id']?>, 'is_show');" /></td>
    <td  width="10%" align="center">
    <a href="<?=$item['cate_id']?>" title="查看相册"><img src="/images/icon/view.gif" /></a>
    <a href="/article/category/cate_id/<?=$item['cate_id']?>" title="编辑相册"><img src="/images/icon/edit.gif"  alt="编辑相册"/></a>
  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">

function cateDel(id) {
    if (confirm('确认要删除该分类吗？')) {
        $.get('/article/cateDel', {cate_id : id}, function(text){
            if (text == 'succeed') {
                alert('分类删除成功！');
                location.replace('/article/category');
            } else {
                alert(text);
            }
        })
    }
}
$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});



    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="cate_id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>