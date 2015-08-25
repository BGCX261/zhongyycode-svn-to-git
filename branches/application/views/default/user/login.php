<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#innmain{width:950px; margin:0 auto;}
.login_page {background:url("/images/album/login_page_bg.gif") no-repeat scroll 0 0 transparent;height:419px;
padding-left:480px;padding-top:155px;width:470px;}
.login_page table tr td {height:30px;line-height:30px;padding-top:10px;}
.fltd {background:url("/images/album/icon_1.gif") no-repeat 2px 20px transparent;width:90px;padding-left:20px;}
input.ainpunt{line-height:16px;border:1px solid #4EAF00; height:16px;margin:0;padding:0;}
</style>
<div id="innmain">
    <div class="container login_page">
    <form method="post" action="" class="denglukuang" name="login" id="userlogin">
       <table>
       <tr>
        <td class="fltd">用 户 名：</td>
        <td>
         <input type="text"  value="请输入用户名" name="username"  onfocus="if (this.value == '请输入用户名') {this.value = '';}" onblur="if (this.value == '') {this.value = '请输入用户名';}" class="ainpunt" />
        </td>
       </tr>
       <tr>
        <td class="fltd">密 &nbsp; &nbsp; 码：</td>
        <td><input type="password" value="" name="password"  class="ainpunt" /></td>
       </tr>
       <tr>
        <td style=""></td>
        <td>
        <input type="submit" name="login" style="background:url(/images/album/icon_btn_dl.gif);border:0; width:83px; height:27px;" value=" " />
        &nbsp;<a href="/user/forget">忘记密码</a>
        </td>
        <td class="imgtd"></td>
       </tr>
       </table>
       </form>
    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer2.php'); ?>
<script type="text/javascript">
$(document).ready(function() {

    $('#userlogin').submit(function(){
        var username = $('input[name=username]').val();
        if (username == '' || username == '请输入用户名') {
            alert('请输入用户名');
            return false;
        }
        var password = $('input[name=password]').val();
        if (password == '' || password == '请输入密码') {
            alert('请输入密码');
            return false;
        }
    });
});
</script>
