<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.form.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/jquery.inplace.min.js"></script>
<form method="get" id="list">
<fieldset>
  <legend>搜索</legend>
  核审状态:<select name="status">
            <option value="">请选择</option>
            <option value="0" <?=Str::selected($status, '0')?>>未审</option>
            <option value="1" <?=Str::selected($status, '1')?>>已审</option>
            <option value="2" <?=Str::selected($status, '2')?>>每月系统扣分</option>
        </select>
  用户名: <input type="text" name="uname" size="20" value="<?=$uname?>" />
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <th>ID</th>
    <th align="left">用户名</th>
    <th align="left">提交时间</th>
    <th align="left">任务标题</th>
    <th align="left">审核时间</th>
    <th>积分</th>
    <th>核审状态</th>
    <th >操作</th>
 </tr>
 <? foreach ($results as $item) {  ?>
<?
    switch ($item['status']){
            case 0:
                $status="未审";
            break;
            case 1:
                $status="已审";
            break;
            case 2:
                $status="每月系统扣分";
            break;

    }
?>

  <tr>
    <td align="left"><input type="checkbox" name="uid[]" value="<?=$item['id']?>" /></td>
    <td><?=$item['id']?></td>
    <td align="left" id="<?=$item['id']?>" class="edit1" title="点击编辑"><?=$item['uname']?>
    </td>
    <td align="left"><?php echo date('Y-m-d',strtotime ($item['submit_date']))?></td>
    <td id="<?=$item['id']?>" class="edit2" title="点击编辑"><a href="<?=$item['url']?>" target="_blank"><?=$item['title']?></a></td>
    <td><?php echo date('Y-m-d',strtotime ($item['audite_date']))?></td>
    <td id="<?=$item['id']?>" class="edit3" title="点击编辑"><?php echo $item['points']?></td>
    <td ><?php echo $status?></td>

    <td  width="10%" align="center">
    <a href="/admin/point/view?id=<?=$item['id']?>" title="查看"><img src="/images/icon/view.gif"  alt="查看"/></a>
    <a href="/admin/point/edit?id=<?=$item['id']?>" title="编辑"><img src="/images/icon/edit.gif"  alt="编辑"/></a>
  </tr>
  <? } ?>
</table>

<?php echo $pagination->render('pagination/digg');?>
<br />
<input type="button" value="删除信息"  onclick="indexTop('del');"/>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
// 设置明星用户
function indexTop(app){
    if (confirm('确认要删除吗？')) {
     $("#list").attr('action', '/admin/point/delinfo?app='+app).attr('method', 'post').submit();
     $("#list").attr('action', '').attr('method', 'get');
     }
}
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
        $(':checkbox[name="uid[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>

<script type="text/javascript">
$(document).ready(function () {
    $(".edit1").editInPlace({
        url: "/admin/point/attrEdit?name='uname'",
        update_value: "uname",
        element_id: "id",
        saving_image: "/images/indicator.gif",
        value_required: "true",
        bg_over: "#EDF6FC",
        bg_out: "#FFFFFF",
        default_text: ""
    });
    $('select').change(function(){$("form:first").attr('method', 'get').attr('action', '/admin/point').submit();});

     $(".edit2").editInPlace({
        url: "/admin/point/attrEdit?name='title'",
        update_value: "title",
        element_id: "id",
        saving_image: "/images/indicator.gif",
        value_required: "true",
        bg_over: "#EDF6FC",
        bg_out: "#FFFFFF",
        default_text: ""
    });

    $(".edit3").editInPlace({
        url: "/admin/point/attrEdit?name='points'",
        update_value: "points",
        element_id: "id",
        saving_image: "/images/indicator.gif",
        value_required: "true",
        bg_over: "#EDF6FC",
        bg_out: "#FFFFFF",
        default_text: ""
    });


    //$('select').change(function(){$("form:first").attr('method', 'get').attr('action', '/admin/point').submit();});
});
</script>