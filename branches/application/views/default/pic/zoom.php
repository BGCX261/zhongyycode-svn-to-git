<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">

.zmain{width:950px; margin:0 auto; }
.zmain  ul.SizeList{margin:10px 0 0 0;}
.zmain  ul.SizeList li {border-left:1px solid #EEEEEE;float:left;height:33px;margin:0;padding:5px 5px 10px;text-align:center;width:100px;}
ul.SizeList li.CurrentZoom {background-color:#F5F5F5;}
div#copyCode {background:none repeat scroll 0 0 #F5F5F5;margin-top:20px;padding:10px;}
ul#copyCodeItem li {clear:both;height:30px;line-height:25px;list-style:none outside none;margin-bottom:5px;}
ul#copyCodeItem input.txt {width:350px;}
.btn {background:none repeat scroll 0 0 #666666;border-color:#999999 #353535 #353535 #999999;border-style:solid;border-width:1px;color:#FFFFFF;font-size:1.1em;font-weight:bold;overflow:visible;padding:2px 4px; height:22px;line-height:20px;}
div#copyCode label.td {display:block;float:left;width:100px;}
h5 {font-size:1.2em;line-height:1.25;margin:0.5em 0;}
div.ZoomUploader {height:30px;position:absolute;float:right:width:200px;z-index:4;margin:0 0 0 800px;}
</style>
<div class="zmain">
    <div><a href="/<?=$pid?>.html">返回图片浏览页面</a></div>
    <div class="ZoomUploader">
    由 <a href="/u/<?=urlencode($info->username)?>" class="plain"><?=$info->username?></a><br>
    上传于 <?=date('Y-m-d H:i', $info->uploadtime);?>
</div>
    <h3>所有照片尺寸:</h3>

    <ul class="SizeList">
            <li class="<?=($zoom == 'thumb')? 'CurrentZoom':'Zoom';?>"><a href="/pic/zoom?id=<?=$pid?>&zoom=thumb"><strong>缩略图</strong></a><br><span class="Dimensions"></span></li>

            <li class="<?=($zoom == 'medium')? 'CurrentZoom':'Zoom';?>"><a href="/pic/zoom?id=<?=$pid?>&zoom=medium"><strong>中型图</strong></a><br><span class="Dimensions"></span></li>
            <li class="<?=(empty($zoom))? 'CurrentZoom':'Zoom';?>"><a href="/pic/zoom?id=<?=$pid?>"><strong>原图</strong></a><br><span class="Dimensions"></span></li>
    </ul>
     <div class="clearfloat"></div>
    <br />
    当前图尺寸：<?=$picinfo[0] . 'X' . $picinfo[1]?>
    <div class="clearfloat"></div>
    <div class="pic"><img src="<?=$picname?>" /></div>


</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>