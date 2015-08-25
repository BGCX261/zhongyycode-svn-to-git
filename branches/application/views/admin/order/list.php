<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />
<style type="text/css">
label {display:inline;}
</style>
<form method="get" action="" id="search">
<fieldset>
  <legend>查询订单</legend>
  订单号: <input type="text" name="orderno" size="20" value="<?=$orderno?>" />
  交易号: <input type="text" name="trade_no" size="10" value="<?=$trade_no?>" />
  订单状态：
    <select name="status">
        <option value="1" <?=Str::selected('1', $status);?>>付款</option>
        <option value="0" <?=Str::selected('0', $status);?>>创建</option>
        <option value="2" <?=Str::selected('2', $status);?>>取消</option>
    </select>
  <select name="group_id">
        <option value="-1">全部</option>
        <?php foreach ($groups as $item) { ?>
        <option value="<?=$item['id']?>" <?=Str::selected($item['id'], $group_id);?>><?=$item['group_name']?></option>
        <?php } ?>
    </select>
  用户名: <input type="text" name="username" size="10" value="<?=$username?>" />

  操作时间：<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;

   <input type="submit" name ="" value=" 查 询 " />

</fieldset>
<table class="tablegrid" width="100%" style="text-align:left;">
 <tr>
    <th>序号</th>
    <th>订单号<br />交易号</th>
    <th align="left">优惠券</th>
    <th align="left">会员名</th>
    <th align="left">消费前<br />消费后</th>
    <th align="left">方式<br />类型</th>
    <th align="left">金额</th>
    <th align="left">注册时间<br/>操作时间<br/>生效时间<br/>到期时间</th>
    <th align="left">操作员</th>
 </tr>
 <?php
    $sum = 0;
    foreach ($pagination as $key => $item) {
        switch($item['consume_type']){
            case 0:$consume_type="淘宝";break;
            case 1:$consume_type="网站";break;
            case 2:$consume_type="代理"; break;
        }
        $sum += $item['fee'];
 ?>
  <tr>
    <td><?=$key+1?></td>
    <td align="left"><?=$item['orderno']?><br /><?=$item['trade_no']?></td>
    <td align="left"><?=$item['couponcode']?></td>
    <td align="left"><?=$item['username']?></td>
    <td align="left"><?=$group_list[$item['current_group']]?><br /><font color="green"><?=$group_list[$item['dest_group']]?></font></td>
    <td align="left"><?=($item['current_group'] == $item['dest_group']) ? '<font color="blue">续费</font>' : '<font color="red">升级</font>'?><br /><?=$consume_type?></td>
    <td align="left"><?=$item['fee']?></td>
    <td align="left"><?=date('Y-m-d H:i:s', $item['reg_time'])?><br /><font color="blue"><?=$item['save_time']?></font><br /><?=$item['submit_time']?><br /><font color="red"><?=$item['will_exceed']?></font></td>
    <td align="left"><?=$item['operator']?></td>


  </tr>
  <? } ?>
</table>
<div style>
当前页已付订单总金额：<font color="red"><?=$sum?></font>元,已付款订单总金额：<font color="red"><?=$calculate2?></font>元,订单总金额：<font color="red"><?=$calculate?></font>元
<?php echo $pagination->render('pagination/digg');?>
</div>
<br />

</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function delPic(){
     $("#search").attr('action', '/admin/pics/delPic').attr('method', 'post').submit();
}

$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});
    $('.date').datepicker({yearRange:'-5:5'});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>