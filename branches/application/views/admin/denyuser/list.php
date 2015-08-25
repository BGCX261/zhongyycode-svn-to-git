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
  用户组:<select name="rank">
        <option value="-1">全部</option>
        <?php foreach ($group as $item) { ?>
            <option value="<?=$item['id']?>" <?=Str::selected($rank, $item['id'])?>> <?=$item['group_name'];?></option>
        <?php }?>
        </select>
  用户状态：
      <select name="status" >
            <option value="-1"> 全部</option>
            <option value="approved" <?=Str::selected('approved', $status);?>> 通过</option>
            <option value="overtime" <?=Str::selected('overtime', $status);?>> 过期</option>
            <option value="disapproval" <?=Str::selected('disapproval', $status);?>> 冻结</option>
            <option value="forbid" <?=Str::selected('forbid', $status);?>> 禁止</option>
        </select>
 屏蔽状态：
      <select name="d_status" >
            <option value="-1"> 全部</option>
            <option value="0" <?=Str::selected('0', $d_status);?>> 解屏</option>
            <option value="1" <?=Str::selected('1', $d_status);?>> 需屏</option>
            <option value="2" <?=Str::selected('2', $d_status);?>> 已屏</option>
            <option value="4" <?=Str::selected('4', $d_status);?>> vip开</option>
        </select>
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />

  屏蔽时间:<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;

  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <th>ID</th>
    <th align="left">用户名</th>
    <th align="left">用户组</th>
    <th align="left">过期时间</th>
    <th align="left">屏蔽时间</th>
    <th>状态</th>
    <th align="left">屏蔽状态</th>
    <th>存储目录</th>
    <th >操作</th>
 </tr>
 <? foreach ($pagination as $item) {
    switch($item['user_status']) {
        case 'approved':$user_status = '<font color="blue">通过</font>';break;
        case 'overtime':$user_status = '<font color="red">过期</font>';break;
        case 'disapproval':$user_status = '<font color="green">冻结</font>';break;
        case 'forbid':$user_status = '<font color="red">禁止</font>';break;
        default:$user_status = '<font color="red">禁止</font>';break;
    }
    switch($item['status']) {
        case 0: $status = '<font color="blue">解屏</font>';break;
        case 1: $status = '<font color="red">需屏</font>';break;
        case 2: $status = '<font color="green">已屏</font>';break;
        case 4: $status = '<font color="green">vip开</font>';break;
    }
 ?>
  <tr>
    <td align="left"><input type="checkbox" name="id[]" value="<?=$item['id']?>" /></td>
    <td><?=$item['uid']?></td>
    <td align="left"><a href="/admin/user/view?uid=<?=$item['uid']?>"><?=Str::highlight($item['username'], $username);?></a></td>
    <td align="left"><a href="/admin/denyuser/list?rank=<?=$item['rank']?>" title="查看该用户组下的用户"><?=$group_list[$item['rank']]?></a></td>
    <td align="left"><?php echo date('Y-m-d',$item['expire_time'])?></td>
    <td align="left"><?php echo $item['deny_date']?></td>
    <td><?=$user_status?></td>
    <td><?=$status?></td>
    <td><?=$item['save_dir']?></td>
    <td  width="10%" align="center">

    <a href="/admin/denyuser/delete?id=<?=$item['id']?>" class="delete" title="删除该屏蔽信息"><img src="/images/icon/trash.gif"  alt="删除该屏蔽信息"/></a>

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
     $("#list").attr('action', '/admin/denyuser/delete').attr('method', 'get').submit();
     $("#list").attr('action', '').attr('method', 'get');
}
$(document).ready(function() {
    $('.date').datepicker({yearRange:'-5:5'});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>