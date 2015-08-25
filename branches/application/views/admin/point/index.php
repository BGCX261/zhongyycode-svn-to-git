<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />
<style type="text/css">
label {display:inline;}
</style>

<form method="get" id="list">

<fieldset>
  <legend>搜索</legend>
  核审状态:<select name="status">
            <option value="-1">选择全部</option>
            <option value="0" <?=Str::selected($status, '0')?>>未审</option>
            <option value="1" <?=Str::selected($status, '1')?>>已审</option>
            <option value="2" <?=Str::selected($status, '2')?>>每月系统扣分</option>
        </select>
    发帖ID: <input type="text" name="title" size="20" value="<?=$title?>" />
   用户名: <input type="text" name="uname" size="20" value="<?=$uname?>" />
   时间类型:
    <select name="time_type">
        <option value="submit_date" <?=Str::selected('submit_date', $time_type);?>>提交任务时间</option>
        <option value="audite_date" <?=Str::selected('audite_date', $time_type);?>>审核时间</option>
    </select>
    <input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;
  &nbsp;

      <input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <th align="left">用户名</th>
    <th align="left">提交时间</th>
    <th align="left">发帖ID</th>
    <th align="left">帖子地址</th>
    <th>核审状态</th>
    <th>核审时间</th>

    <th>积分</th>
    <th>审核评语</th>
    <th >操作</th>
 </tr>
 <? foreach ($pagination as $item) {
    switch ($item['status']){
            case 0:$status="<font color='red'>未审</font>";break;
            case 1:$status="<font color='green'>已审</font>";break;
            case 2:$status="每月系统扣分";break;
    }
?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['id']?>"  id="checkbox_<?=$item['id']?>"/><?=$item['id']?></td>
    <td align="left"><a href="/admin/point?uname=<?=$item['uname']?>" ><?=$item['uname']?></a>
    </td>
    <td align="left"><?php echo date('Y-m-d H:i:s',strtotime ($item['submit_date']))?></td>
    <td align="left"><?=Str::slice($item['title'], 20, '...')?></td>
    <td align="left"><a href="<?=$item['url']?>" target="_blank"><?=Str::slice($item['url'], 20, '...')?></a></td>
    <td ><?php echo $status?></td>
    <td align="left"><?php echo (!empty($item['audite_date'])) ? date('Y-m-d H:i:s',strtotime ($item['audite_date'])) : ''?></td>
    <td align="left">
      <?php if ($item['status'] > 0) { echo '<font color="red">' .$item['points'] . '</font>';} else { ?>
      <input name="points[<?=$item['id']?>]" type="radio" value="0" checked/>0
      <input name="points[<?=$item['id']?>]" type="radio" value="1" />1
      <input name="points[<?=$item['id']?>]" type="radio" value="2" />2
     <?php } ?>
    </td>
    <td align="left">
        <?php if ($item['status'] > 0) { echo $item['audite_memo'];} else { ?>
        <select name="audite_memo[<?=$item['id']?>]">
            <option value="8">感谢您完成积分任务</option>
            <option value="1" <?=Str::selected('帖子已失效', $item['audite_memo']);?>>帖子已失效</option>
            <option value="2" <?=Str::selected('找不到您的回答', $item['audite_memo']);?>>找不到您的回答</option>
            <option value="3" <?=Str::selected('发贴地址错误', $item['audite_memo']);?>>发贴地址错误</option>
            <option value="4" <?=Str::selected('发帖ID', $item['audite_memo']);?>>发帖ID错误</option>
            <option value="5" <?=Str::selected('评论或贴吧不得分', $item['audite_memo']);?>>评论或贴吧不得分</option>
            <option value="6" <?=Str::selected('帖子不符合发帖规则', $item['audite_memo']);?>>帖子不符合发帖规则</option>
            <option value="7" <?=Str::selected('请采纳答案后提交', $item['audite_memo']);?>>请采纳答案后提交</option>
            <option value="0" <?=Str::selected('请勿重复提交', $item['audite_memo']);?>>请勿重复提交</option>
        </select>

        <?php } ?>
    </td>
    <td  align="center">
    <?php if ($item['status'] == 0) {?><a href="javascript:accept(<?=$item['id']?>);" title="点击审核当前行"><img src="/images/icon/accept.gif"  alt="点击审核当前行"/></a><?php } ?>
    <a href="/admin/point/view?id=<?=$item['id']?>" title="查看"><img src="/images/icon/view.gif"  alt="查看"/></a>
    <a href="/admin/point/edit?id=<?=$item['id']?>" title="编辑"><img src="/images/icon/edit.gif"  alt="编辑"/></a>
  </tr>
  <? } ?>
</table>

<br />
<input type="button" value="批量删除"  onclick="delAll();"/>
<input type="button" value="批量审核"  onclick="verifyAll();"/>

</form>
<div style="text-align:right;margin:5px;">
<?php echo $pagination->render('pagination/digg');?>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function accept(id)
{
   $('#checkbox_' + id).attr('checked', 'checked');
   $("#list").attr('action', '/admin/point/verify').attr('method', 'post').submit();
   $("#list").attr('action', '').attr('method', 'get');
}
function delAll(){
    if (confirm('确认要删除吗？')) {
         $("#list").attr('action', '/admin/point/del').attr('method', 'post').submit();
         $("#list").attr('action', '').attr('method', 'get');
     }
}
function verifyAll(){
    if (confirm('确认要批量审核吗？')) {
        if ($('select[name=audite_memo]').val() < 0) {
            alert('请选择审核评语');
            return false;
        }
         $("#list").attr('action', '/admin/point/verify').attr('method', 'post').submit();
         $("#list").attr('action', '').attr('method', 'get');
     }
}

$(document).ready(function() {
    $('select[name=status]').change(function(){$("form:first").submit();});

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
    $('.date').datepicker({yearRange:'-5:5'});
});
</script>
