<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
#use_fee{display:none;}
</style>

<form method="post" id="upgrade_fee">

<input type="hidden" name="uid" value="<?=$userInfo['uid']?>" />
<table cellspacing="5">
    <tbody>
    <tr><td><b>用户名：</b></td><td><?=$userInfo['username']?> </td></tr>
    <tr><td><b>当前级别：</b></td><td><?=$userInfo['group']['group_name']?></td></tr>
    <tr><td><b>注册时间：</b></td><td><?=date('Y-m-d', $userInfo['reg_time'])?></td></tr>
    <tr><td><b>到期时间：</b></td><td><?=date('Y-m-d', $userInfo['expire_time'])?></td></tr>
    <tr><td><b>升级到：</b></td><td>
    <select name="group" >
        <?php foreach ($group as $item) {
            if ($item['id'] != 1) {
        ?>
            <option value="<?php echo  $item['id']?>" <?=Str::selected($userInfo['rank'], $item['id']);?>> <?=$item['group_name']?>：<?=$item['max_space']?></option>
        <?php } }?>
    </select>
    </td></tr>
     <tr><td><b>付款方式：</b></td><td>
    <select name="status" >
        <option value="0" > 月付</option>
        <option value="1" > 年付</option>
    </select>
    </td></tr>
    <tr><td><b>交易号：</b></td><td><input type="text" size="50" value="" name="trade_no" class="text" gtbfieldid="46" /></td></tr>
    <tr><td><b>续期时间：</b></td><td><input type="text" size="50" value="" name="time" class="text" gtbfieldid="46" /></td></tr>
    <tr id="use_fee"><td><b>需要费用：</b></td><td><input type="text" size="50" value="" name="use_fee" class="text" gtbfieldid="46" disabled />(<font color="red">这里不需要填写</font>) </td></tr>



    <tr><td colspan="2">
        <input type="button" onclick="fee();" value="计算费用" class="button">
        <input type="submit" value="提交" class="button"> <input type="reset" value="重置" class="button">

        <input type="button" onclick="javascript:location.href='/admin/user/list';" value="返回" class="button">
    </td></tr>
</tbody></table>


</form>
<table  class="tablegrid" width="100%" style="text-align:center;">
    <tr>
        <td>订单号<br />优惠券</td>
        <td>升级到</td>
        <td>续期时间</td>
        <td>费用</td>
        <td>记录保存时间<br>提交(取消)时间</td>
        <td>状态</td>
        <td>到期时间</td>
        <td>操作者</td>
        <td>操作</td>
    </tr>
    <?php foreach ($orderInfo as $upgrade) {
        switch($upgrade['status']){
            case 0:
                $status='<font color="red">未提交</font>';
                break;
            case 1:
                $status='<font color="green">提交</font>';
                break;
            case 2:
                $status='取消';
                break;
        }
        if ($upgrade['month'] % 12 == 0) {
            $type = '年';
        } else {
             $type = '月';
        }
        if ($upgrade['fee_type'] == 'year') {
            $type = '年';
        }
        if ($upgrade['fee_type'] == 'month') {
            $type = '月';
        }
        if($upgrade['time'] == 0) {
            $upgrade['time'] = $upgrade['month'];
            if ($type == '年') {
                $upgrade['time'] = $upgrade['month'] / 12;
            }
        }
    ?>
        <tr>
            <td><?=$upgrade['orderno']?><br /><?=$upgrade['couponcode']?></td>
            <td><?=$upgrade['group_name']?></td>
            <td><?=$upgrade['time']?> <?=$type?></td>
            <td><?=$upgrade['fee']?></td>
            <td><?=$upgrade['save_time']?><br><?=$upgrade['submit_time']?></td>
            <td><?=$status?></td>
            <td><?=(!empty($upgrade['will_exceed'])) ? date('Y-m-d',strtotime($upgrade['will_exceed'])) : '';?></td>
            <td><?=$upgrade['operator']?></td>
            <td>
        <?php
                if (Auth::getInstance()->isAllow('order.edit')) {
                if ($upgrade['status'] == 0){ ?>
                <form action="/admin/user/pay" method="post">
                    <input type="hidden" name="upgrade_id" value="<?=$upgrade['id']?>" />
                    <input type="submit" name="upgrade_submit" value="提交" class="btn" />
                    <input type="button" name="upgrade_cancel" onclick="cancel(<?=$upgrade['id']?>, <?=$upgrade['uid']?>);" value="取消" class="btn" />
                </form>

        <?php }} ?>

            </td>
        </tr>

    <?php } ?>
</table>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function fee()
{
    var uid = $('input[name=uid]').val();
    var status = $('select[name=status]').val();
    var group = $('select[name=group]').val();
    var time = $('input[name=time]').val();
    if (time == '') {
        alert('请输入续期时间');
        return false;
    }
    $.getJSON("/admin/user/fee", { "uid": uid, "status": status, "time": time, 'group': group }, function(data){
        $('input[name=use_fee]').val(data.price);
        $('#use_fee').show();
    });
}
<?php if (Auth::getInstance()->isAllow('order.edit')) { ?>
function cancel(id, uid)
{
    if (confirm('确认要取消该订单吗？')) {
        location.href='/admin/user/cancel?id=' + id + '&uid=' + uid;
    }

}
<?php }?>
$(document).ready(function() {
    $('#upgrade_fee').submit(function(){
        var time = $('input[name=time]').val();
        if (time == '') {
           alert('请输入续期时间');
            return false;
        }
    });

});
</script>