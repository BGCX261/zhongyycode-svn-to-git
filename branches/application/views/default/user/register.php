<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.reg {background:url("/images/album/reg_bg.gif") no-repeat scroll 0 0 transparent;height:573px;position:relative;width:950px;margin:0 auto;}
 .reg_table {position:absolute; top:100px; left:410px; width:420px;}
.reg_ok {background:url("/images/album/btn_regok.gif") no-repeat scroll 0 0 transparent;height:30px;left:580px;
position:absolute;top:420px;width:84px;border:0;}
.reg_table td {padding-top:10px;}

.ltd {background:url("/images/album/icon_1.gif") no-repeat scroll 0 20px transparent;line-height:30px;text-align:right;vertical-align:top;width:75px;}
</style>

<div class="container reg">
<form action="" method="post" name="reg_form" id="reg_form">
    <table class="reg_table">
    <tr>
    <td class="ltd">用&nbsp;户&nbsp;名：</td>
    <td class="rtd">
    <input class="ainpunt" name="username" id="user" type="text" />
    <p><em id="user_error" style="display:">2-10个字符,一旦注册成功不能修改</em></p></td>
    </tr>
    <tr>
    <td class="ltd"><span class="">设置密码：</span></td>
    <td class="rtd">
    <input class="ainpunt" name="password" id="pass" type="password" />
    <p><em id="pass_error" style="display:">密码长度6-20位，请牢记</em></p>
    </td>
    </tr>
    <tr>
    <td class="ltd">确认密码：</td>
    <td class="rtd">
    <input class="ainpunt" name="confpass" id="confpass" type="password" />
    <p>
    <em id="pwconfirm_info" style="display:">请再次输入您的密码</em>
    </p>
    </td>
    </tr>
    <tr>
    <td class="ltd">电子邮箱：</td>
    <td class="rtd">
    <input class="ainpunt" name="email" id="email" type="text"  maxlength="50"/>
    <p><em id="emailinfo">请填写有效Email地址</em></p>
    </td>
    </tr>
    <tr>
    <td class="ltd">验&nbsp;证&nbsp;码：</td>
    <td class="rtd">
    <input class="binpunt" type="text" name="captcha" id="captcha" size=10 style="vertical-align:bottom;HEIGHT: 20px">
    <img id="captchaImg" src="<?php echo URL::base().'captcha/default'; ?>" height="30" width="130" align="absmiddle" onclick="getCaptchaImg();" /> &nbsp;
    <a href="javascript:getCaptchaImg();" >看不清，换一张</a>
    <p><em id="captcha_error" ></em></p>
    </td>
    <tr>
    <td colspan="2">点击下方注册按钮，我们将认为您已阅读并同意遵守 <a href="/about?k=3" target="_blank"><font color="#FF0000">外链吧服务条款</font></a></td>
    </tr>
    </tr>
    </table>
    <input type="submit" name="register" value=""  class="reg_ok"/>
 </form>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer2.php'); ?>
<script language="javascript" type="text/javascript">
function getCaptchaImg()
{
    $('#captchaImg').attr('src', '<?php echo URL::base().'captcha/default'; ?>?s='+Math.random());
}
function checkusername(value)
{
    $.get('/user/hasuser',{'username' : value},function(data){
        if (data != '') {
         $('#user_error').html(data).css('color', 'red');
        }else {
            if(value.length < 2 || value.length > 10) {
                $('#user_error').html('用户密码不能为空并且不能少于6个字符和超过20个字符！').css('color', 'red');
            } else {
                $('#user_error').html('输入正确').css('color', 'green');
            }
        }
    });

}
function checkemail(value)
{

    $.get('/user/checkemail',{'email' : value},function(data){

        if (data != '') {
         $('#emailinfo').html(data).css('color', 'red');
        } else {
            $('#emailinfo').html('输入正确').css('color', 'green');
        }
    });

}
$().ready(function(){

    $("input[name=username]").blur( function() {
        checkusername($(this).val());


    });
    $("input[name=email]").blur( function() {
        if ($(this).val().search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1) {
            checkemail($(this).val());
        } else {
            alert('你输入的邮箱地址格式不正确');
        }

    });

    $("input[name=confpass]").blur( function() {
        var confpass = $('input[name=confpass]');
        var pass = $('input[name=password]');
        if(confpass.val() != pass.val() ){
            $('#pwconfirm_info').html('两次输入的密码不一致').css('color', 'red');

            return false;
        } else {
            $('#pwconfirm_info').html('输入正确').css('color', 'green');
        }
    });
    $("input[name=password]").blur( function() {
        var pass = $('input[name=password]');
        if(pass.val() == '' || pass.val().length < 6 || pass.val().length > 20){
            $('#pass_error').html('用户密码不能为空并且不能少于6个字符和超过20个字符！').css('color', 'red');
            return false;
        } else {
            $('#pass_error').html('输入正确').css('color', 'green');
        }
    });

    $('#captcha').blur( function() {
        var captcha = $('#captcha');
        if(captcha.val() == '' ){
            $('#captcha_error').html('请重新输入验证码').css('color', 'red');
            return false;
        } else {
            $('#captcha_error').html('');
        }
    });
     //关闭链接
    $('.close a').click(function(){$(this).hide().parent().next().hide()});
    $('#reg_form').submit(function(){
        var user = $('input[name=username]');
        if(user.val() == '' || user.val().length < 2 || user.val().length > 10){
            $('#user_error').html('用户名不能为空并且不能少于2个字符和超过10个字符！').css('color', 'red');
            user.focus();
            return false;
        }

        var pass = $('input[name=password]');
        if(pass.val() == '' || pass.val().length < 6 || pass.val().length > 20){
            $('#pass_error').html('用户密码不能为空并且不能少于6个字符和超过20个字符！').css('color', 'red');
            pass.focus();
            return false;
        }

        var confpass = $('input[name=confpass]');
        if(confpass.val() != pass.val() ){
            $('#pwconfirm_info').html('两次输入的密码不一致').css('color', 'red');
            confpass.focus();
            return false;
        }

        var email = $('input[name=email]');
        if(email.val() == '' ){
            $('#emailinfo').html('您的邮箱有误或为空，请重新输入！').css('color', 'red');
            email.focus();
            return false;
        }

        var captcha = $('#captcha');
        if( captcha.val() == '' ){
            $('#captcha_error').html('请重新输入验证码！').css('color', 'red');
            captcha.focus();
            return false;
        }

    });

});
</script>