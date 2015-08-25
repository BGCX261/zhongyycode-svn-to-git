<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.success {background:url("/images/user/regdone_bg.gif") no-repeat scroll 0 0 transparent;height:573px;position:relative;width:950px;margin:0 auto;}
 .reg_table {position:absolute; top:100px; left:410px; width:420px;margin:40px 0 0 130px;}
.reg_ok {background:url("/images/album/btn_regok.gif") no-repeat scroll 0 0 transparent;height:30px;left:580px;
position:absolute;top:420px;width:84px;border:0;}
.reg_table td {padding-top:10px;}

.ltd {background:url("/images/album/icon_1.gif") no-repeat scroll 0 20px transparent;line-height:30px;text-align:right;vertical-align:top;width:75px;}

</style>

<div class="container success">
    <table class="reg_table">
        <tr><td> <b>欢迎加入『外链吧』大家族！ <b></td></tr>
        <tr><td> <b><font color="red">『外链吧』隆重推出</font><b></td></tr>
        <tr><td> <b>150M 惊爆价49元/年，价格超低，预购从速！<b></td></tr>
        <tr><td> <b>免费用户注册后即拥有100M可外链相册空间！<b></td></tr>
         <tr><td> <b>【<a href="/">点击返回首页</a>】 【<a href="/user">进入用户中心</a>】<b></td></tr>
    </table>



</div>
<div id="foot" style="margin:0 auto;">
    <div class="copyright">
        <div class="related">
            <ul class="auto">
                <li class="hd"><a href="/about?k=1">关于我们</a></li>
                <li><a href="/about?k=3">服务条款</a></li>
                <li><a href="/about?k=4">版权隐私</a></li>
                <li><a href="/about?k=5">意见反馈</a></li>
                <li class="ft"><a href="/about?k=6">联系我们</a></li>
            </ul>
            Copyright&nbsp;&copy;&nbsp;2009-2010&nbsp;外链吧&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn/" target="ICP">鲁ICP备10013633号</a>
        </div>
        <div class="logo">
            <h2>外链吧，永久免费！</h2>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">

$().ready(function(){

     //关闭链接
    $('.close a').click(function(){$(this).hide().parent().next().hide()});

});
</script>