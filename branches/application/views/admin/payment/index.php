<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/jquery/jquery.form.min.js"></script>
<form method="get" id="list">


<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>

    <th align="left">支付方式</th>
    <th align="left">支付名称</th>
    <th align="left">支付描述</th>
    <th align="left">是否在线支付</th>
    <th align="left">是否允许使用</th>
    <th >操作</th>
 </tr>
 <? foreach ($payments as $item) {?>
  <tr>
    <td align="left"><?=$item['adapter']?></td>
    <td align="left"><?=$item['pay_name']?></td>
    <td align="left"><?=$item['pay_desc']?></td>
    <td><img src="/images/<?=$item['online']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, '<?=$item['adapter']?>', 'online');" /></td>
    <td><img src="/images/<?=$item['enabled']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, '<?=$item['adapter']?>', 'enabled');" /></td>

    <td  width="10%" align="center">
    <a href="/admin/payment/set?adapter=<?=$item['adapter']?>" title="编辑"><img src="/images/icon/edit.gif"  alt="编辑"/></a>
    <a href="/admin/payment/del?adapter=<?=$item['adapter']?>" class="delete" title="删除"><img src="/images/icon/trash.gif"  alt="删除"/></a>
  </tr>
  <? } ?>
</table>
<br/>

<br />

</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function setStat(obj, id, type) {

    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/admin/payment/setStat', {'adapter': id, 'val': val, 'type': type});
}

$(document).ready(function() {

});
</script>