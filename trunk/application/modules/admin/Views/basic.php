<style type="text/css">
#layoutbasic {padding-bottom:4px;}
#layoutbasic h3 {color:#09D; font-size:14px; font-weight:bold; margin:5px 0 0 0; padding:0; float:left; clear:left;}
#layoutbasic ul {margin:0; padding:0; list-style:none; float:right; clear:right; text-align:right;}
#layoutbasic ul li {height:24px; line-height:24px; float:left;}
#layoutbasic ul li a:link, #layoutbasic ul li a:visited { color:#666; text-decoration:none; padding:0 6px;}
#layoutbasic ul li a:hover {text-decoration:underline; color:#06A;}
#layoutbasic ul li.current {background:url(/images/admin/bg_action_btn.gif) no-repeat; margin-right:3px;}
#layoutbasic ul li.current a {background:url(/images/admin/bg_action_btn_round.gif) right no-repeat;}
#layoutbasic ul li.current a:link, #layoutbasic ul li.current a:visited {color:#FFF; display:block;}
#layoutbasic ul li.current a:hover {text-decoration:none;}
</style>
<div id="layoutbasic" class="layout">
<h3><?=$layout['basic']['title']?></h3>
<ul>
<?
print_r($layout['basic']['title']);
if (isset($layout['basic']['action'])) {
 foreach ($layout['basic']['action'] as $name => $item) {
?>
<li<? if ($layout['basic']['current'] == $name) echo ' class="current"';?>><a href="<?=$this->url($item['url'])?>"<? if (isset($item['target'])) echo ' target="' . $item['target'] .  '"';?> title="<?=isset($item['title']) ? $item['title'] : $item['text']?>"><span><?=$item['text']?></span></a></li>
<?
 }
}
?>
</ul>
<div class="clearfloat"></div>
</div>
