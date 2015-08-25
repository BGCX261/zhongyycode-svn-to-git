	<div id="buttom">
		<img src="/public/images/blog/buttom.jpg" />
		<p class="copyright">Copyright © 2008-2009 www.yunphp.cn 版权所有，并保留所有权利。<br>
	    QQ：121981379&nbsp; &nbsp; &nbsp; &nbsp; 邮箱：<a href="mailto:regulusyun@gmail.com" class="mailto" title="通过发送邮件与我联系">regulusyun@gmail.com</a></p>
	    <p><a href="http://www.miibeian.gov.cn/" target="_blank">粤ICP备09010792号</a></p>
	</div>
<? if (Yun_Core::_getDebug()) { ?>
	<div class="btn_div" style="border:0px;text-align:left;background:#FFF;">
	    页面运行时间 <em style="color:#FF0000"><?=number_format(microtime(true)-START_TIME, 8, '.', '')?></em> 秒
	</div>
<? } ?>
</div><!--end id="wrapper" -->

</body>
</html>
