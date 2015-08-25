<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/jquery/yoxview/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/scripts/album/index.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.checkbox.min.js"></script>

<style type="text/css">
#content{width:750px; float:left;}
.user_bg {background:url("/images/user/user_1right_bg.gif") no-repeat scroll 0 0 transparent; height:659px; width:540px;float:left;}
.user_bg .flash{width:250px; float:left; }
.user_bg .text{ float:right; width:240px;margin-top:80px;}
.user_bg .text p{color:#4FAF03;}
.user_bg .text p span{color:#FF7800;}
.use_ad{float:left; width:183px;}
.use_ad_top {background:url("/images/user/user_1right_right_top_bg.gif") no-repeat scroll 0 0 transparent;
color:#4FAF03;padding:70px 10px 0 10px;}
.use_ad_top p{color:#4FAF03;}
.user_wenti {background:url("/images/user/user_wenti_bg.gif") no-repeat scroll 0 0 transparent;height:230px;padding-top:65px;padding-left:10px;}
.user_wenti p {height:25px;line-height:25px;color:#4FAF03;}
img{border:0;}

/*图片轮播*/
.slide {position:relative; width:250px; height: 161px; overflow:hidden; z-index:100;margin:60px 0 0 7px;}
.slide-list {position:relative; list-style:none; margin:0; padding:0;}
.slide-list li {position:absolute; top:0; left:0; display:none;}
.slide-list li.current {display:block;}
.slide-trigger {position:absolute; list-style:none; bottom:4px; right:4px; z-index:111;}
.slide-trigger li {float:left; margin-left:2px;margin-top:10px; width:15px; height:15px; cursor:pointer; font:Arial; background-color:#FFFFFF; color:#9F9F9F; font-size:12px; text-align:center; line-height:15px; border:1px solid #DCDCDC;}
.slide-trigger li.current {background-color:#C00100;margin-top:10px; border:1px solid #A00100; color:#FFFFFF; font-size:13px; font-weight:bold;}


</style>


<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>

  <div id="content">
    <div class="user_bg">
        <!-- 公告板 -->
            <div id="info">
                <div style="padding-top:5px; padding-left:80px;">
                    <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
                        <span id="newgoals">
                           <?=$configs['marquee_message']?>
                        </span>
                    </marquee>
                </div>
            </div>

            <div class="flash">
                <div class="slide">
                <ul class="slide-list">
                    <li class="current">
                     <a href="http://item.taobao.com/auction/item_detail.htm?item_num_id=9043011266" title="三通半遥控直升机" target="_blank">
                     <img src="http://img9.wal8.com/img9/sportlight/12946669900922.jpg" />
                     </a></li>
                    <li>
                     <a href="http://shop61203113.taobao.com/" title="芒果印章" target="_blank">
                     <img src="http://img5.wal8.com/img5/sportlight/1286890926_500639319.gif" />
                     </a></li>
                    <li>
                     <a href="about?k=19" title="广告招商" target="_blank">
                     <img src="http://img5.wal8.com/img5/sportlight/1286891161_1140689024.jpg" />
                     </a></li>
                </ul>
                <ul class="slide-trigger">
                    <li class="current">1</li>
                    <li>2</li>
                    <li>3</li>
                </ul>
                </div>
            </div>

            <div class="text">
                <p> 欢迎加入外链吧！</p>
                <p> 购买1年VIP-G服务，<span class="ahuang">送80M空间</span>；</p>
                <p> 购买1年VIP-E服务，<span class="ahuang">送50M空间</span>；</p>
               <p>  购买1年VIP-B服务，<span class="ahuang">送30M空间</span>！</p>
                <p><a href="/pay/upgrade" class="ahuang">[具体查看]</a></p>
            </div>
    </div>
    <div class="use_ad">
        <div class="use_ad_top">
            <p> 外链吧广告位正在<br />积极招商中，价格实惠，位置、形式灵活多样。<br />
            从现在起，具有良好品牌形象且人气旺盛的外链吧，一定是您产品、店铺推广的最佳选择！</p>
            <p> 联系QQ：1279384663</p>
        </div>
        <div class="user_wenti">
            <p><a href="/help?k=15">→如何上传图片</a></p>
            <p><a href="/help?k=16">→如何复制图片到淘宝中</a></p>
            <p><a href="/help?k=11">→如何使用产品搬家</a></p>
            <p><a href="/help?k=12">→如何使用店铺搬家</a></p>
            <p><a href="/help?k=17">→为什么我的图片被屏蔽了</a></p>
            <p><a href="/help?k=18">→如何开通我的账号</a></p>
        </div>

  </div>
  </div>

</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>