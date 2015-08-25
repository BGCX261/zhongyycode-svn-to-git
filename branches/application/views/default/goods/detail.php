<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<script type="text/javascript" language="javascript" src="/v3/scripts/shop.js"></script>
<script type="text/javascript" language="javascript" src="/v3/scripts/shop/detail.js"></script>
<link href="/v3/styles/shop.css" rel="stylesheet" type="text/css" media="all" />
<link href="/v3/styles/shop/detail.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
/*已添加到购物车浮动层*/
.add-cart{display:none; position:absolute; padding-bottom:3px; width:300px;color:#320606; font-weight:bold; background:#FFFAFC; border:3px solid #B8255C; z-index:9999; margin-left:-2px; +margin-left:0 !important; +margin-left:8px;}
.add-cart .h {border-bottom:1px dashed #B8255C; width:100%; text-align:right; margin:5px 0; padding-right:5px;}
.add-cart .c{text-align:center;margin:10px 0;}
.add-cart .shop{text-align:center;}
.add-cart a{color:#320606;}

.add-cart .to-cart{ position:absolute; padding-bottom:3px; width:150px; text-align:left; color:#320606; font-weight:bold;margin-top:2px;+margin-top:0;}
#goods-basic{width:950px; margin:0 auto; border:1px solid #F00;}
</style>

<div id="goods-basic">

  <div class="info">

    <h2>商品名称:<font color="red"><?=$info['goods_name']?></font></h2>
    <ul class="intro">

      <li><span>商品规格：</span><a href="javascript:;" class="current" title="当前商品的规格为：<?=$info['spec']?>"><?=$info['spec']?></a>
          <? if (!empty($groupSpec)) { ?><? foreach ($groupSpec as $item) { ?>
          / <a href="/<?=$item['goods_id']?>.html" title="选择该规格"><?=$item['spec']?></a>
          <? } ?><? } ?>
      </li>
      <li><span>规格类型：</span><em><?=$info['goods_type']?></em></li>



    </ul>
    <div class="other">


          <p class="price"><span class="sale">售价：<em style="color:#f00;">￥<?=$info['shop_price']?></em>元</span> </p>
         <p class="rank"><a href="http://teamblog.imeelee.com/147.html" title="查看会员等级详情" target="_blank">VIP会员享受98折～9折优惠！</a></p>



      <p class="buy"><a href="/cart/add?goods_id=<?=$info['goods_id']?>">添加到购物车</a></p>
        <div class="add-cart">
            <div class="to-cart">&nbsp;&nbsp;已成功添加到购物车</div>
            <div class="h"><a href="javascript:;" onclick="$('.add-cart').hide();">关闭</a>&nbsp;&nbsp;</div>
            <div class="c"></div>
        </div><!-- 购物车浮动层 -->
    </div>
    <div class="clearfloat"></div>


  </div>
</div>
<a name="service"></a>
<div class="clearfloat"></div>

</div>


<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>


<script type="text/javascript">
function addCart(obj, id)
{
    $('.add-cart').css('left', $(obj).offset().left);
    $('.add-cart').css('top', $(obj).offset().top - 40);
    cart.addItem(id, 1);
    $('.add-cart').show();
}
$(document).ready(function(){

    //$(".buy a").attr('href', "javascript:").bind('click',function(){
     //   addCart(this, <?=$info['goods_id']?>);
   // });

});
</script>