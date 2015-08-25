<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<form>
<!--fieldset>
<legend>日期选择</legend>
起始日期：<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/>&nbsp;&nbsp;
截止日期：<input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/>&nbsp;&nbsp;
<input type="submit" value="确定" />
</fieldset-->
<div style="width:100%; margin:10px auto; text-align:center;">
<?=Ofc::getInstance()->create(array('width' => '99%', 'height' => 500, 'data' => urlencode(Url::site('admin/stat/month?save_dir=' . ($save_dir) . "&stat_date=". $start_date.'&end_date='.$end_date))))?>
</div>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">


$(document).ready(function() {

});
</script>