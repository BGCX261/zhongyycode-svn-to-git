
<?php
    defined('SYSPATH') or die('No direct script access.') ;
    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
    if($auth) {
?>

$(document).ready(function(){
    var html = "<li>欢迎你，<a href=\"/user\"><?php echo $auth['username']?></a>|</li>";

        html += "<li><a href=\"/user/logout\">退出</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"setHomepage();\">设为首页</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"addCookie();\">加入收藏</a>|</li>";
        html += "<li class=\"ft\"><a href=\"/help\">帮助</a></li>";
    $('#header .nav').html(html);
});
document.write("<div class=\"userinfo\">");
document.write("<a class=\"avatar\" href=\"/user\">");
document.write("<img src=\"<?=(!empty($auth['avatar'])) ? $auth['avatar']: '/images/album/no_avatar.png';?>\" border=\"0\"  width=\"80\" height=\"\80\"/>");
document.write("</a>");
document.write("<div class=\"info\">");
document.write("<p><a href=\"/user\" class=\"name\">【<?=$auth['username']?>】</a></p>");
document.write(" <p><p> 个性签名：<?=(!empty($auth_field['sign'])) ? $auth_field['sign'] : '这家伙好懒，什么也没留下'; ?></p></p>");
document.write("</div>");
document.write("</div>");
    <?php } else { ?>
$(document).ready(function(){
    var html = "<li><a href=\"/user/register\">注册</a>|</li>";
        html += "<li><a href=\"/user/login\">登陆</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"setHomepage();\">设为首页</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"addCookie();\">加入收藏</a>|</li>";
        html += "<li class=\"ft\"><a href=\"/help\">帮助</a></li>";
    $('#header .nav').html(html);
});
document.write("<form method=\"post\" action=\"/user/login\" class=\"denglukuang\" id=\"userlogin\">");
document.write("<p><input type=\"text\"  value=\"请输入用户名\" name=\"username\" onfocus=\"if (this.value == '请输入用户名') {this.value = '';}\" onblur=\"if (this.value == '') {this.value = '请输入用户名';}\" /></p>");
document.write("<p><input type=\"password\" value=\"请输入密码\" name=\"password\" onfocus=\"if (this.value == '请输入密码') {this.value = '';}\" onblur=\"if (this.value == '') {this.value = '请输入密码';}\" /></p>");
document.write("<p><input class=\"denglu\" type=\"submit\" name=\"login\" value=\"\">");
document.write("<input class=\"wangji\" type=\"button\" onclick=\"javascript:window.location.href='/user/forget'\" /></p>");
document.write("</form>");
<?php }?>
