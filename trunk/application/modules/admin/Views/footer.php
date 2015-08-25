<div id="footer"></div>
<? if (Yun_Core::_getDebug()) { ?>
<div class="btn_div" style="border:0px;text-align:left;background:#FFF;">
    页面运行时间 <em style="color:#FF0000"><?=number_format(microtime(true)-START_TIME, 8, '.', '')?></em> 秒
</div>
<? } ?>
</body>
</html>