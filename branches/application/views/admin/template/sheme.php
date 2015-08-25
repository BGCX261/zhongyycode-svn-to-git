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
  发送状态：
      <select name="status" >
            <option value="-1"> 全部</option>
            <option value="0" <?=Str::selected('0', $status);?>>未发送</option>
            <option value="1" <?=Str::selected('1', $status);?>>发送失败</option>
            <option value="2" <?=Str::selected('2', $status);?>>已发送</option>

        </select>
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />

  插入时间:<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;

  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <th align="left">用户名</th>
    <th align="left">用户邮箱</th>
    <th align="left">邮件模板名</th>
    <th align="left">插入时间</th>
    <th>状态</th>
    <th>邮件参数</th>
    <th >操作</th>
 </tr>
 <? foreach ($pagination as $item) {
    switch($item['status']) {
        case 0:
            $status = '<font color="blue">未发送</font>';break;
        case 1:
            $status = '<font color="red">发送失败</font>';break;
        case 2:
            $status = '<font color="green">已发送</font>';break;
        default:
            $status = '<font color="red">发送失败</font>';break;

    }
 ?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['id']?>" /></td>
    <td align="left"><a href="/admin/user/list?username=<?=$item['uname']?>"><?=Str::highlight($item['uname'], $username);?></a></td>
    <td align="left"><?=$item['email']?></td>
    <td align="left"><a href="/admin/template/email?name=<?=$item['email_template']?>" title="查看该模版信息"><?=$item['email_template']?></a></td>
    <td align="left"><?=$item['input_date']?></td>
    <td><?php echo $status?></td>
    <td><?=$item['parameter']?></td>
    <td  width="10%" align="center">

    <a href="/admin/template/shemedel?id=<?=$item['id']?>" class="delete" title="删除该屏蔽信息"><img src="/images/icon/trash.gif"  alt="删除该屏蔽信息"/></a>

  </tr>
  <? } ?>
</table>
<br/>
<?php echo $pagination->render('pagination/digg');?>
<br />

<input type="button" value="删除"  onclick="del();"/>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function del(app){
     $("#list").attr('action', '/admin/template/shemedel').attr('method', 'get').submit();
     $("#list").attr('action', '').attr('method', 'get');
}
$(document).ready(function() {
    $('.date').datepicker({yearRange:'-5:5'});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>