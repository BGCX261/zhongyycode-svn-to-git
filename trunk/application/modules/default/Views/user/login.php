<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-cn" xml:lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->pageTitle?>--</title>
<link href="/styles/global.css" rel="stylesheet" type="text/css" media="all" /> <!-- 通用样式 -->
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.2.6.min.js"></script>
<style type="text/css">
body {-x-system-font:none;color:#000000;font-family:Arial,Tahoma,Verdana;font-size:12px;font-size-adjust:none;font-stretch:normal;font-style:normal;font-variant:normal;
font-weight:normal;line-height:160%;
margin:0;padding:0;text-align:center;}
a img {border:medium none;}
form, table, input, select, textarea {-x-system-font:none;color:#000000;font-family:Arial,Tahoma,Verdana;font-size:12px;font-size-adjust:none;font-stretch:normal;font-style:normal;font-variant:normal;font-weight:normal;line-height:normal;margin:0;}h1, h2, h3, h4, h5, h6 {
margin:0;padding:0;}
h1 {font-size:20px;}h2 {font-size:18px;}h3 {font-size:16px;}h4 {font-size:14px;}h5 {font-size:12px;}h6 {font-size:10px;}
small {font-size:11px;}
textarea {overflow:auto;}
fieldset {border:1px solid #DEEFFA;display:block;margin:5px 0 10px;padding:5px 10px;}
fieldset legend {color:#FF6600;font-size:12px;font-weight:bold;padding:0 5px;}
a {color:#0066CC;text-decoration:none;}
a:hover {color:#FF3300;text-decoration:underline;}
.highlight {background:#FFFF00 none repeat scroll 0 0;color:#EE0000;}
.clearfloat {clear:both;display:block;float:none;height:0;overflow:hidden;}
input.text {background:#FAFAFF none repeat scroll 0 0;border:1px solid #A8BED3;color:#333333;padding:3px;}
input.texthover {background:#FFFFFF none repeat scroll 0 0;border-color:#FFAA99;}
input.button {background:#DEEFFA none repeat scroll 0 0;border:1px solid #A8BED3;color:#333333;cursor:pointer;height:23px;line-height:22px;margin-right:1px;padding:1px 4px 3px;
}
input.buttonhover {background:#FF6600 none repeat scroll 0 0;border-color:#666666;color:#FFFFFF;}
textarea {background:#FAFAFF none repeat scroll 0 0;border:1px solid #A8BED3;color:#333333;overflow:auto;padding:2px 1px;}
textarea.textareahover {background:#FFFFFF none repeat scroll 0 0;border-color:#FFAA99;}
select {border:1px solid #A8BED3;color:#333333;}
.pagination {clear:both;color:#333333;}
.pagination a {background:#FFFFFF none repeat scroll 0 0;border:1px solid #DDDDDD;color:#0066EE;padding:2px 7px;text-decoration:none;}
.pagination a:hover {background:#FF3300 none repeat scroll 0 0;color:#FFFFFF;text-decoration:none;}
.pagination .pageCurrentItem {color:#FF3300;font-weight:bold;padding:2px 7px;}
</style>
</head>

<body>
<div id="wrapper">
<div id="innerWrapper">
    <form name="userLogin" method="post" action="">
    <fieldset style="width:380px; margin:35px auto 0 auto; +margin-top:20px">
    <legend>用户登录</legend>
    <center>
      <p>用户名：
        <input type="text" name="username" size="20" maxlength="15" />
      </p>
      <p>密　码：
        <input type="password" name="password" size="20" maxlength="50" />
      </p>
        <p>验证码：
        <input type="text" name="captcha" size="20" maxlength="50" />
        <p>
            <img id="captchaImg" src="http://www.yunphp.cn/user/captcha" align="absmiddle" onclick="getCaptchaImg();" /></p>
            <span class="tips">看不清楚，<a href="#" onclick="getCaptchaImg();">刷新图片</a></span>
        </p>
      <p>
        <input type="submit" value=" 登 录 "   class="button"/>
        <input type="button" value=" 注 册 " class="button" onclick="parent.location='<?=$this->url(array('action' => 'register'),'default', true);?><?=(!empty($url)) ? '?u=' . urlencode($url) : ''?>'" />
      </p>
      <p>
        <input name="lifetime" type="checkbox" value="2592000" checked="checked" />
        记住密码 | <a href="<?=$this->url(array('action' => 'forget'),'', true);?>" target="_parent">忘记了密码？</a></p>
    </center>
    </fieldset>
    </form>

</div>
</div>

</body>
</html>
<script type="text/javascript" language="javascript">
function getCaptchaImg()
{
    $('#captchaImg').attr('src', 'http://www.yunphp.cn/user/captcha?' + Math.random());
}
$().ready(function(){
    /* ---- 样式修正 ---- */
    $('input').each(function(){
        switch ($(this).attr('type').toLowerCase()) {
            case 'text':
            case 'password':
                $(this).addClass('text');
                $(this).mouseover(function(){$(this).addClass('texthover')});
                $(this).mouseout(function(){$(this).removeClass('texthover')});
                break;
            case 'button':
            case 'submit':
            case 'reset':
                $(this).addClass('button');
                $(this).mouseover(function(){$(this).addClass('buttonhover')});
                $(this).mouseout(function(){$(this).removeClass('buttonhover')});
                break;
            default:
                break;
        }
    });
    $('textarea').mouseover(function(){$(this).addClass('textareahover')});
    $('textarea').mouseout(function(){$(this).removeClass('textareahover')});
});
</script>