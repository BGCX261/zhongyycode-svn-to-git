<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.forget {background:url("/images/user/forget_bg.gif") no-repeat scroll 0 0 transparent;height:573px;position:relative;width:950px;margin:0 auto;}
 .reg_table {position:absolute; top:100px; left:410px; width:420px;margin:40px 0 0 130px;}
.reg_ok {background:url("/images/album/btn_regok.gif") no-repeat scroll 0 0 transparent;height:30px;left:580px;
position:absolute;top:420px;width:84px;border:0;}
.reg_table td {padding-top:10px;}

.fltd {background:url("/images/album/icon_1.gif") no-repeat scroll 0 10px transparent;line-height:30px;text-align:right;vertical-align:top;width:75px;}
.forget form {left:455px;position:absolute;top:165px;width:420px;}
.forget_btn {background:url("/images/album/btn_forget.gif") no-repeat scroll 0 0 transparent;height:27px;width:160px;border:none;}

tr, th, td {text-align:center;}
</style>

<SCRIPT LANGUAGE=javascript RUNAT=Server>
function isEmail(strEmail) {
if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
return true;
else
alert("邮件地址格式不正确！");
}
</SCRIPT>

<div class="container forget">
<form action="" method="post" id="resetpass">
   <table>
   <tr>
    <td class="fltd">用 户 名：</td>
    <td><?php echo $info->username;?></td>
   </tr>
   <tr>
    <td class="fltd">新 密 码：</td>
    <td><input type="password" name="password" class="ainpunt" /></td>
   </tr>
   <tr>
    <td class="fltd">重复输入：</td>
    <td>
    <input type="password" name="passconfirm" class="ainpunt" />
    </td>
   </tr>
   <tr>
    <td></td>
    <td><input name="Submit" type="submit" id="Submit" value=" " style="background:url(/images/user/icon_27.gif); width:70px; height:23px;border:0;" /></td>
   </tr>
   </table>
   </form>
</div>
<script language="javascript" type="text/javascript">

$().ready(function(){

    $('#resetpass').submit(function(){
        var password = $('input[name=password]');

        if (password.val() == '' || password.val().length < 6) {
            alert('请输入至少六位的新密码');
            password.focus();
            return false;
        }
        var passconfirm = $('input[name=passconfirm]');
        if (passconfirm.val() == '') {
            alert('请重复输入新密码');
            passconfirm.focus();
            return false;
        }
        if (passconfirm.val() != password.val())
        {
            alert('两次输入的新密码不正确。请检查');
            return false;
        }

    });

});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer2.php'); ?>