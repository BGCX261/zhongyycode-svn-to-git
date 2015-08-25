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
.forget form table td {height:40px;}
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
<form action="" method="post" name="sendmail" id="sendmail" >
   <?php if (!empty($note)) { echo $note; } else { ?>
   <table>
   <tr>
    <td class="fltd">用 户 名：</td>
    <td><input type="text" class="ainpunt" name="user"/></td>
   </tr>
   <tr>
    <td class="fltd">电子邮箱：</td>
    <td>
    <input type="text" class="ainpunt" name="email" onblur=isEmail(this.value) />
    </td>
   </tr>
   <tr>
    <td></td>
    <td><input class="forget_btn" type="submit" value=''></td>
   </tr>
   </table>
    <?php } ?>
   </form>
</div>
<script language="javascript" type="text/javascript">

$().ready(function(){

    $('#sendmail').submit(function(){
        var user = $('input[name=user]');
        if (user.val() == '') {
            alert('请输入你的用户名');
            user.focus();
            return false;
        }
        var email = $('input[name=email]');
        if (email.val() == '') {
            alert('请输入你的邮箱');
            user.focus();
            return false;
        }
    });

});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer2.php'); ?>
