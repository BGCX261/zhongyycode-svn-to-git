<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<form method="get">
<div class="form-div">
  <table width="100%">
    <tr>
      <td>
      关键字： <input type="text" name="keyword" value="<?php echo $keyword; ?>" size="30" />&nbsp;
      <select name="payment" onchange="this.form.submit();">
        <option value="">支付方式</option>
        <?php foreach ($payments as $p): ?>
        <option value="<?php echo $p->adapter; ?>"<?php echo $payment==$p->adapter ? ' selected' : ''; ?>><?php echo $p->pay_name; ?></option>
        <?php endforeach; ?>
      </select>
      <input type="submit" value=" 搜 索 " class="button" />
      </td>
    </tr>
  </table>
</div>
</form>
<div class="list-div" id="listDiv">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablegrid">
  <tr>
    <th>ID</th>
    <th>支付方式</th>
    <th>请求网址</th>
    <th>发生时间</th>
    <th>客户端IP</th>
    <th>操作</th>
  </tr>
    <? foreach ($pagination as $item) { ?>
  <tr>
    <td align="left"><?=$item['log_id']?></td>
    <td align="left"><?=$item['adapter']?></td>
    <td align="left"><a href="/<?=$item['request_uri']?>" onclick="prompt('Ctrl + C 复制地址', this.href); return false;"><? if (strlen($item['request_uri']) > 50) { ?><?=substr($item['request_uri'], 0, rand(30, 45))?> ... <?=substr($item['request_uri'], -6)?><? } else { ?><?=$item['request_uri']?><? } ?></a></td>
    <td align="left"><?=date('Y-m-d H:i:s',$item['log_time'])?></td>
    <td align="left"><?=$item['client_ip']?></td>
    <td align="left"><a href="/admin/payment/view?id=<?=$item['log_id']?>">查看详情</a></th>
  </tr>
  <? } ?>
</table>
<?php echo $pagination->render('pagination/digg'); ?>
</div>
<div id="readShop" style="display:none;position:absolute;border:5px solid #666666;background:#fff;width:400px;padding:5px">
    <div class="readShop">
        <div class="readColorA" style="float:right"><img src="/misc/images/layBut.png" onclick="hideDiv()" style="cursor:pointer"/></div>
        <div style="font-weight:bold;padding-bottom:5px">请求地址:</div>
        <form>
        <div class="readInput"><input type="text" style="width:360px" name="input_url" id="input_url" value="" /></div>
        </form>
        <div style="padding-top:5px"><input class="button ctLyBut" type="button" onclick="copyText()" value="全选"/><input class="button ctLyButB" type="button" onclick="hideDiv()" value="取消" /></div>
    </div>
</div>
<script>
//弹出复制框
function copyUrl(obj) {
    var top = (document.documentElement.clientHeight)/2-120+"px";
    var left = (document.documentElement.clientWidth)/2-200+"px";
    var request_url = $(obj).attr('rel');
    $('#input_url').val(request_url);
    var readShop = document.getElementById('readShop');
    readShop.style.top=top;
    readShop.style.left=left;
    $('#readShop').show();
    $('#input_url').select();
}
//选中文本
function copyText(){
   var obj = document.getElementById('input_url');
   obj.select();
}
//隐藏层
function hideDiv() {
    $('#readShop').hide();
}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>