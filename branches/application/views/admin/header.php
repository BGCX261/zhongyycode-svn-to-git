<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<title>iMeeLee.com 网站管理后台</title>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.3.2.pack.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.checkbox.min.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.tablegrid.min.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.thickbox.min.js"></script>
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
    $('table.tablegrid').tablegrid({oddColor:'#FFFFFF', evenColor:'#F0F5F8', overColor:'#FFE0D0'});
    $('input[type=checkbox][name=checkAll]').each(function(){
        $(this).checkbox().toggle($(this).val());
    });
    $(document).keydown(function(event){
        if(event.ctrlKey && event.keyCode == 13) {
            $('form.allowKeySubmit').submit(); //将表单 class 设为 allowKeySubmit 则可以通过 CTRL + 回车 进行提交
        }
    });
    /* ---- Tabs ----*/
    $.fn.tabs = function(event, elements){
        event = (event == 'click') ? 'click' : 'mouseover';
        $(this).each(function(){
            var eles = [];
            if (!elements) {
                $(this).find('li').each(function(){
                    eles.push($($(this).find('a').attr('href')));
                });
            }
            $(this).find('li').bind(event, function(){
                (!elements) ?
                    $.each(eles, function(i){eles[i].css('height', '0px').hide()})
                    : $(elements).css('height', '0px').hide();
                $($(this).find('a').attr('href')).css('height', 'auto').show();
                $(this).parent().find('li').removeClass('current');
                $(this).addClass('current');
                $(this).find('a').blur();
                return false;
            }).unbind(event == 'click' ? 'mouseover' : 'click');
        });
    };
    $('.jquery-tabs').tabs('click');
});
</script>
<link href="/styles/admin/global.css" rel="stylesheet" type="text/css" media="all" />
<link href="/styles/thickbox.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
#TB_title {display:none;} /* 隐藏 thickbox 标题*/
</style>
</head>
<body>
<div id="header">
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
<?php if(!empty($layout)) { ?>
<div id="layoutbasic" class="layout">
    <h3><?=$layout['title']?></h3>
    <ul>
    <?
    if (isset($layout['action'])) {
     foreach ($layout['action'] as $name => $item) {
         $class = '';
         (isset($layout['current']) && $layout['current'] == $name) && $class = "current";
         isset($item['class']) && $class = trim("$class {$item['class']}");
    ?>
    <li<? if (!empty($class)) { ?> class="<?=trim($class)?>"<? } ?><? if (isset($item['id'])) { ?> id="<?=$item['id']?>"<? } ?>><a href="<?=$item['url']?>"<? if (isset($item['target'])) echo ' target="' . $item['target'] .  '"';?> title="<?=isset($item['title']) ? $item['title'] : $item['text']?>"><span><?=$item['text']?></span></a></li>
    <? } }?>
    </ul>
    <div class="clearfloat"></div>
</div>
<?  }?>
<?php if (!empty($description)) { ?>
<style type="text/css">
#layoutdescription {background:url(/images/admin/bg_layout.gif) 0px -60px repeat-x; padding:5px 8px; margin-bottom:10px;}
#layoutdescription ul {margin:5px; padding:0px;}
#layoutdescription li {margin:3px 10px; padding:0px;}
</style>
<div id="layoutdescription" class="layout">
<?=$description?>
</div>
<?php } ?>
</div>
<div id="tbody">
