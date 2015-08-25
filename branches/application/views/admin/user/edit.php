<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.form.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />

<form method="post" id="list">

<input type="hidden" name="uid" value="<?=$userInfo['uid']?>" />
<table cellspacing="5">
    <tbody>
    <tr><td><b>用户名：</b></td><td><?=$userInfo['username']?>
    <?php if(Auth::getInstance()->isAllow(array('user.reset'))){ ?>
       <img src="/images/icon/lightbulb.gif" onclick="show();"/>&nbsp;&nbsp;<span id="show_password" style="display:none;"><?=base64_decode($userInfo['password'])?> </span>
    <?php } ?></td></tr>


    <tr><td><b>用户邮箱：</b></td><td><input type="text" size="50" value="<?=$userInfo['email']?>" name="email" class="text" gtbfieldid="46"></td></tr>
    <tr><td><b>用户组：</b></td><td>
    <select name="group" >
        <?php foreach ($group as $item) {?>
            <option value="<?php echo  $item['id']?>" <?=Str::selected($userInfo['rank'], $item['id']);?>> <?=$item['group_name']?></option>
        <?php } ?>
    </select>
    </td></tr>
     <tr><td><b>状态：</b></td><td>
    <select name="status" >
        <option value="approved" <?=Str::selected('approved', $userInfo['status']);?>> 通过</option>
        <option value="overtime" <?=Str::selected('overtime', $userInfo['status']);?>> 过期</option>
        <option value="disapproval" <?=Str::selected('disapproval', $userInfo['status']);?>> 冻结</option>
        <option value="forbid" <?=Str::selected('forbid', $userInfo['status']);?>> 禁止</option>
    </select>
    </td></tr>
    <tr><td><b>新密码：</b></td><td><input type="text" size="50" value="" name="password" class="text" gtbfieldid="46" /></td></tr>
    <tr><td><b>到期时间：</b></td><td><input type="text" size="50" value="<?=date('Y-m-d', $userInfo['expire_time'])?>" name="expire_time" class="date"  gtbfieldid="46"></td></tr>
    <tr><td><b>用户备注:</b></td><td><textarea cols="100" rows="5" name="memo"><?=$userInfo['memo']?></textarea></td></tr>


    <tr><td colspan="2"><input type="submit" value="提交" class="button"> <input type="reset" value="重置" class="button"> <input type="button" onclick="javascript:history.back()" value="返回" class="button"></td></tr>
</tbody></table>


</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function show()
{
    $('#show_password').show();
}
$(document).ready(function() {
        $('.date').datepicker({yearRange:'-5:5'});
});
</script>