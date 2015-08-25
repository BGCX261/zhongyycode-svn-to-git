<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.checkbox.min.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.tablegrid.min.js"></script>
<link href="/styles/admin/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript">
$().ready(function() {
    /* ---- Style Fix ---- */
    $('input').each(function(){
        switch ($(this).attr('type').toLowerCase()) {
            case 'text':
            case 'file':
                $(this).addClass('text');
                $(this).mouseover(function(){$(this).addClass('texthover')});
                $(this).mouseout(function(){$(this).removeClass('texthover')});
                break;
            case 'button':
            case 'submit':
            case 'reset':
                $(this).addClass('button');
                $(this).mouseover(function(){$(this).addClass('buttonhover')});
                $(this).mouseout(function(){$(this).removeClass('buttonhover')});
                break;
            default:
                break;
        }
    });
    $('textarea').mouseover(function(){$(this).addClass('textareahover')});
    $('textarea').mouseout(function(){$(this).removeClass('textareahover')});
    /* ---- Fix End ----*/
    $('a.delete').click(function(){return confirm('一旦删除将无法恢复，您确认要删除该记录吗？')});
    $('table.tablegrid').tablegrid({oddColor:'#FFFFFF', evenColor:'#F8FAFC', overColor:'#FFF0E0'});
    $('input[type=checkbox][name=checkAll]').each(function($i){
        $(this).checkbox().toggle($(this).val());
    });
    $(document).keydown(function(event){
        if(event.ctrlKey && event.keyCode == 13) {
            $('form.allowKeySubmit').submit(); //将表单 class 设为 allowKeySubmit 则可以通过 CTRL + 回车 进行提交
        }
    });
});
</script>

</head>
<Style>

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
#description {background:url(/images/admin/bg_layout.gif) repeat-x scroll 0 -60px;
padding:5px 8px; margin:0px;}
</Style>

<body>
<div id="header">
<div id="layoutbasic" class="layout">
    <h3><?=$this->layout['title']?></h3>
    <ul>
        <?if (isset($this->layout['action'])) {
            foreach ($this->layout['action'] as $name => $item) {
        ?>
              <li <? if ($this->layout['current'] == $name) echo ' class="current"';?>><a href="<?=$this->url($item['url'], '',true)?>" title="<?=isset($item['title']) ? $item['title'] : $item['text']?>"><span><?=$item['text']?></span></a></li>
        <?
            }
        }
        ?>
    </ul>
    <div class="clearfloat"></div>
</div>

<?if (isset($this->layout['description'])) { ?>
<div id="description"  class="layout">
    <? foreach ($this->layout['description'] as $name => $item) {?>
    <?=$item?>
    <? }?>
</div>

<? }?>
</div>