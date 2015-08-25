<script type="text/javascript" src="/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />

<form>
<fieldset>
<legend>日期选择</legend>
起始日期：<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/>&nbsp;&nbsp;
截止日期：<input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/>&nbsp;&nbsp;
<input type="submit" value="确定" />
</fieldset>

<?=$this->OFC(array('width' => '99%', 'height' => 500, 'data' => "{$this->url(array('module' => 'admin','controller' => 'stats', 'action' => 'lists'))}"))?>

<?//$this->OFC(array('width' => '99%', 'height' => 500, 'data' => "{$this->url(array('action' => 'orderMonth'))}"))?>

