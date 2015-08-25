<?php
    defined('SYSPATH') or die('No direct script access.') ;
    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
    if($auth) {
?>
$(document).ready(function(){
    var html = "<li>欢迎你，<a href=\"/user\"><?php echo $auth['username']?></a>|</li>";
            <? if (Auth::getInstance()->isAllow('index.access@admin')) { ?>
        html += "<li><a href=\"/admin\">后台管理</a>|</li>";
            <?php } ?>
        html += "<li><a href=\"/user/logout\">退出</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"setHomepage();\">设为首页</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"addCookie();\">加入收藏</a>|</li>";
        html += "<li class=\"ft\"><a href=\"/help\">帮助</a></li>";
    $('#header .nav').html(html);
});

document.write("<div class=\"mod_user_info_1\">");
document.write("<div class=\"hd\"></div>");
document.write("<div class=\"bd\">");
document.write("<span class=\"avatar\">");
document.write("<a class=\"pic\" href=\"/user\"><img src=\"<?php echo (!empty($auth['avatar']))? $auth['avatar'] : '/images/album/img/no_avatar.png'; ?>\" border=\"0\" alt=\"\" /></a>");
document.write("</span>");
document.write("<span class=\"info\">");
document.write("<strong class=\"name\"><a  href=\"/user\" title=\"返回用户中心\"><?php echo $auth['username']; ?></a></strong>");
document.write("<p><?php echo (!empty($auth_field['sign'])) ? $auth_field['sign'] : '这家伙好懒,什么也没留下'; ?></p>");
document.write("</span>");
document.write("</div>");
document.write(" <div class=\"ft\"></div>");
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
document.write("<form action=\"/user/login\" id=\"login\" method=\"post\">");
document.write("<div class=\"mod_user_login_1\">");
document.write("<div class=\"hd\"></div>");
document.write("<div class=\"bd\">");
document.write("<label class=\"user_name\">");
document.write("<span>用户名<br /><sup>USER NAME</sup></span>");
document.write("<input name=\"username\" type=\"text\" />");
document.write("</label>");
document.write("<label class=\"password\">");
document.write("<span>密　码<br />");
document.write("<sup>PASSWORD</sup>");
document.write("</span>");
document.write("<input name=\"password\" type=\"password\" />");
document.write("</label>");
document.write("<span class=\"user_button\">");
document.write("<input class=\"login\" name=\"\" value=\"用户登录\" type=\"submit\" />");
document.write("<input class=\"find_password\" name=\"\" value=\"找回密码\" type=\"button\" />");
document.write("</span>");
document.write("</div>");
document.write("<div class=\"ft\"></div>");
document.write("</div>");
document.write("</form>");

<?php }?>
document.write("<div class=\"button\">");
document.write("<a class=\"album\" href=\"<?php if($auth) { echo '/u/'. urlencode($auth['username']);}else { echo '/user/login';}?> \">我的相册</a>");
document.write("<a class=\"topics\" href=\"/picsubject/list\">我的专题</a>");
document.write("</div>");