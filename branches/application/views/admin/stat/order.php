<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.3.2.pack.js"></script>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />
<form>

<div style="width:100%; margin:10px auto; text-align:center;">
<?=Ofc::getInstance()->create(array('width' => '99%', 'height' => 500, 'data' => (Url::site('admin/stat/orderday'))))?>
<?=Ofc::getInstance()->create(array('width' => '99%', 'height' => 500, 'data' => (Url::site('admin/stat/ordermonth'))))?>
</div>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">


$(document).ready(function() {

});
</script>