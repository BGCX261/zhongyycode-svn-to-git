<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/album/index.js"></script>
<style type="text/css">
.container {margin:0 auto;width:950px;}
.huandeng {background:url("/images/user/huan_bg.gif") no-repeat;height:381px;width:594px;float:left;}
.zhuce {background:url("/images/user/zhuce_bg.gif") no-repeat;height:394px;margin-left:40px;float:left;width:310px;}

.newface h2 {background:url("/images/user/newface_ico.gif") no-repeat;color:#4FAF05;padding-left:25px;}
.newface { padding-left:10px; width:594px;float:left; text-align:center;margin-top:5px;}
 p { margin-top:5px;}
    .newface h2 { padding-left:25px; background:url(/images/user/newface_ico.gif) no-repeat; color:#4FAF05;text-align:left;}
    .newface h2 a { float:right;margin-right:40px;}
    .newface h2 a img { }

.login form {background:url("/images/user/login_bg.gif") no-repeat;float:left;height:132px;padding-left:120px;padding-top:28px;width:210px;}
.login form .denglu {background:url("/images/user/login_post.gif") no-repeat scroll 0 0 transparent;width:75px;height:26px;border:0;}
.login form .wangji {background:url("/images/user/f_pwd.gif") no-repeat scroll 0 0 transparent;width:75px;height:26px; border:0;}
.user_list{padding-top:10px;}
.user_list li{float:left;margin:0;padding:0;height:110px;width:90px; }
.userinfo  {background:url("/images/user/userinfo_bg.gif") no-repeat;float:left;height:132px;padding-left:10px;padding-top:0px;width:320px;}
.userinfo .avatar{float:left;width:90px;margin-top:28px;}
.userinfo .info{float:left;border-left:1px dashed #D8D9D4;margin-top:28px;padding-left:10px;width:170px; height:85px;}
.userinfo .info a{color:#4FAF03;font-size:14px;font-weight:bold;}
/*图片轮播*/
.slide {position:relative; width:537px; height: 358px; overflow:hidden; z-index:100;margin:10px 0 0 10px;}
.slide-list {position:relative; list-style:none; margin:0; padding:0;}
.slide-list li {position:absolute; top:0; left:0; display:none;}
.slide-list li.current {display:block;}
.slide-trigger {position:absolute; list-style:none; bottom:4px; right:0px;padding:55px 0 0 0;
-moz-background-clip:border;-moz-background-origin:padding;-moz-background-size:auto auto;background-attachment:scroll;
background-color:transparent;background-image:url("/images/user/flash_star_bg.png") !important;background-position:0 0;
background-repeat:repeat;height:27px;width:537px;z-index:1;text-align:right;}
.slide-trigger li {float:right; margin-left:5px;margin-top:10px; width:15px; height:15px; cursor:pointer; font:Arial;font-weight:bold; color:#FFFFFF; font-size:12px; text-align:center; line-height:15px; padding:2px;}
.slide-trigger li.current {margin-top:8px; color:#C00100; font-size:12px; font-weight:bold;}
.free_reg{position:absolute; width:150px;margin:360px 0 0 95px;}
.banner{margin-top:10px;}
</style>
<div class="container">
    <div class="huandeng">
        <div class="slide">
            <ul class="slide-list">
                 <li class="current"> <a href="/user/register" title="100M外链相册！现在就免费拥有100M超大空间外链相册！"><img src="/images/01.jpg"/></a></li>
                <li> <a href="/user/login" title="批量上传，批量外链"><img src="/images/02.jpg" /></a></li>
                <li> <a href="/user/login" title="图片无水印，完美支持GIF动画，然你的图片动起来！"><img src="/images/03.jpg" /></a></li>
                <li> <a href="/user/login" title="将图片上传到【我的图册】，向朋友展示个人风采！"><img src="/images/04.jpg" /></a></li>
            </ul>
            <ul class="slide-trigger">
                <li class="current">4</li>
                <li>3</li>
                <li>2</li>
                <li>1</li>
            </ul>
        </div>
    </div>
    <div class="zhuce"><a href="/user/register" class="free_reg"><img alt="免费注册" src="/images/user/reg.gif" /></a></div>
    <div class="clearfloat"></div>
    <div class="newface">
        <h2><a href="/pic"><img alt="更多" src="/images/user/more.gif" /></a>我在外链吧</h2>
        <ul class="user_list">
           <?php foreach($topUser as $key => $item) { ?>
            <li>
                <a class="avatar" href="/u/<?=urlencode($item['username'])?>">
                    <img src="<?=(!empty($item['avatar'])) ? $item['avatar']: '/images/album/no_avatar.png';?>" border="0" alt=""  width="80" height="80"/>
                </a>
                <a class="name" href="/u/<?=urlencode($item['username'])?>">
                    <?php echo Str::slice($item['username'],8); ?>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="login">
    <div class="banner"><a href="/user/register"><img alt="永久免费" src="/images/user/login_bannber.gif" /></a></div>
    <br />
    <script  language="javascript" src="/js"></script>

</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
