<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<? if (empty($info)) { ?>
<p style="background:url(/images/icon/lightbulb.gif) no-repeat; padding-left:20px;"><font color="red"><b>未找到指定的订单日志</b></font></p>
<? } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="dataedit">
  <tr>
    <th width="80" align="left" valign="top">支付方式</th>
    <td align="left"><?=$info['pay_name']?></td>
  </tr>
  <tr>
    <th align="left" valign="top">客户端 IP</th>
    <td align="left"><?=$info['client_ip']?></td>
  </tr>
  <tr>
    <th align="left" valign="top">日志时间</th>
    <td align="left"><?=$info['log_time']?></td>
  </tr>
  <tr>
    <th align="left" valign="top">请求地址</th>
    <td align="left"><textarea rows="4" style="width:800px; overflow:auto;">http://www.wal8.com<?=$info['request_uri']?></textarea></td>
  </tr>

  <tr>
    <th align="left" valign="top">$_GET</th>
    <td align="left"><div style="border:1px solid #C0E0F0; padding:5px; background:#F5F5FF;"><?
    $vars = unserialize($info['get_vars']);
    foreach ($vars as $key => $value) {
        echo "<font color=green>$key</font> : <font color=gray><i>$value</i></font><br />";
    }
    ?></div></td>
  </tr>
  <tr>
    <th align="left" valign="top">$_POST</th>
    <td align="left"><div style="border:1px solid #C0E0F0; padding:5px; background:#F5F5FF;"><?
    $vars = unserialize($info['post_vars']);
    foreach ($vars as $key => $value) {
        echo "<font color=green>$key</font> : <font color=gray><i>$value</i></font><br />";
    }
    ?></div></td>
  </tr>
  <tr>
    <th align="left" valign="top">$_SERVER</th>
    <td align="left"><div style="border:1px solid #C0E0F0; padding:5px; background:#F5F5FF;"><?
    $vars = unserialize($info['server_vars']);
    foreach ($vars as $key => $value) {
        echo "<font color=green>$key</font> : <font color=gray><i>$value</i></font><br />";
    }
    ?></div></td>
  </tr>
</table>
<? } ?>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>