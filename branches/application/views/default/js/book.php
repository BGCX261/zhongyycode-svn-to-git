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

document.write("<div class=\"mod_user_info_1\">");
document.write("<div class=\"hd\"></div>");
document.write("<div class=\"bd\">");
document.write("<span class=\"avatar\">");
document.write("<a class=\"pic\" href=\"/books/<?=urldecode($auth['username'])?>\">");
document.write("<img src=\"<?php echo (!empty($auth['avatar']))? $auth['avatar'] : '/images/album/img/no_avatar.png'; ?>\" border=\"0\"  />");
document.write("</a>");
document.write("</span>");
document.write("<span class=\"info\">");
document.write("<strong class=\"name\"><a href=\"/books/<?=urldecode($auth['username'])?>\"><?=$auth['username']?></a></strong>");
document.write("<p>");
document.write("<?=(!empty($auth_field['sign'])) ? $auth_field['sign'] : '这家伙好懒，什么也没留下';?>");
document.write("</p>");
document.write("</span>");
document.write("</div>");
document.write("<div class=\"ft\"></div>");
document.write("</div>");
document.write("<div class=\"button\"> <a class=\"book_home\" href=\"/books/<?=urldecode($auth['username'])?>\">我的图书馆</a> <a class=\"book_manage\" href=\"/book/article/list\">图书管理</a> </div>");
<?php } else { ?>
$(document).ready(function(){
    var html = "<li><a href=\"/user/register\">注册</a>|</li>";
        html += "<li><a href=\"/user/login\">登陆</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"setHomepage();\">设为首页</a>|</li>";
        html += "<li><a style=\"cursor:pointer;\" onclick=\"addCookie();\">加入收藏</a>|</li>";
        html += "<li class=\"ft\"><a href=\"/help\">帮助</a></li>";
    $('#header .nav').html(html);
});
document.write("<div class=\"mod_user_login_1\" >");
document.write("<form action=\"/user/login?forward=<?=urlencode('/book');?>\" id=\"login\" method=\"post\">");
document.write("<div class=\"hd\"></div>");
document.write("<div class=\"bd\">");
document.write("<label class=\"user_name\"> <span> 用户名<br />");
document.write("<sup>USER NAME</sup> </span>");
document.write("<input name=\"username\" type=\"text\" />");
document.write("</label>");
document.write("<label class=\"password\"> <span> 密　码<br />");
document.write("<sup>PASSWORD</sup> </span>");
document.write("<input name=\"password\" type=\"password\" />");
document.write("</label>");
document.write("<span class=\"user_button\">");
document.write("<input class=\"login\" name=\"\" value=\"用户登录\" type=\"submit\" />");
document.write("<input class=\"find_password\" name=\"\" value=\"找回密码\" type=\"button\" onclick=\"location.href='/user/forget'\"/>");
document.write("</span> </div>");
document.write("<div class=\"ft\"></div>");
document.write("</form>");
document.write("</div>");
<?php } ?>