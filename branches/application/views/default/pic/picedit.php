<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/jquery/yoxview/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/yoxview/yox.js"></script>
<script type="text/javascript" src="/scripts/jquery/yoxview/yoxview-init.js"></script>
<link href="/scripts/jquery/yoxview/yoxview.css" rel="stylesheet" type="text/css" />
<style type='text/css'>
#content{width:750px; float:left; overflow:hidden;}
.message{background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent; height:30px; line-height:30px;margin-bottom:0; padding-left:85px; width:660px;}
.user_img_zs{  margin-bottom:10px; display:inline-block; height:130px; line-height:130px; width:130px; overflow:hidden;}
.cate_list{margin:10px;list-style:none;}
.cate_list li{float:left; width:175px;margin-left:5px;background:url("/images/album/user_0right_3.gif_img_bg.gif") no-repeat scroll 0 0 transparent;}
.filp{float:right;margin-right:10px; width:670px; text-align:right;}
.move{margin:5px; text-align:right;}
.tis{margin:15px 0;}
p.img{ clear:both;margin:7px 0 0 6px;height:130px;width:130px;}
.picname{margin:10px 0 0 0 ;}



ul.SizeList{margin:10px 0 0 0;}
ul.SizeList li {border-left:1px solid #EEEEEE;float:left;height:33px;margin:0;padding:5px 5px 10px;text-align:center;width:100px;}
ul.SizeList li.CurrentZoom {background-color:#F5F5F5;}
div#copyCode {background:none repeat scroll 0 0 #F5F5F5;margin-top:20px;padding:10px;}
ul#copyCodeItem li {clear:both;height:30px;line-height:25px;list-style:none outside none;margin-bottom:5px;}
ul#copyCodeItem input.txt {width:350px;}
.btn {background:none repeat scroll 0 0 #666666;border-color:#999999 #353535 #353535 #999999;border-style:solid;border-width:1px;color:#FFFFFF;font-size:1.1em;font-weight:bold;overflow:visible;padding:2px 4px;}
div#copyCodeItem label.td {display:block;float:left;width:100px;border:1px solid #F00;}
h5 {font-size:1.2em;line-height:1.25;margin:0.5em 0;}
div.ZoomUploader {height:30px;position:absolute;float:right:width:200px;z-index:4;margin:0 0 0 800px;}
</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content">
    <div class="message">
        <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
            <span id="newgoals"><?=$configs['marquee_message']; ?></span>
        </marquee>
    </div>
    <div class="tis"><img src="/images/user/user_0right_3.gif"></div>
    <p  class="huang">当前位置：<a href="/category/list">根目录</a>&gt 编辑图片 </p>
    <div class="search">
        <form enctype="multipart/form-data" action="" method="post">
        <fieldset>
            <legend> 修改图片信息</legend>
            修改文件名: <input type="text" value="<?=$info->custom_name ?>"  name="name" />&nbsp;
            同名文件替换：<input type="file" value="" name="newfile" />
            <input type="submit" value=" 编 辑 "   class="botton"/>
            <input type="botton" value=" 返 回 "  onclick="location.href='/category/list'" class="botton"/>
            <input type="hidden" name="pid" value="<?=$info->id?>" />
        </fieldset>
        </form>

        <div class="yoxview">
            <ul class="SizeList">
                <li class="<?=($zoom == 'thumb')? 'CurrentZoom':'Zoom';?>"><a href="/pic/picedit?pid=<?=$pid?>&zoom=thumb"><strong>缩略图</strong></a><br><span class="Dimensions"></span></li>

                <li class="<?=($zoom == 'medium')? 'CurrentZoom':'Zoom';?>"><a href="/pic/picedit?pid=<?=$pid?>&zoom=medium"><strong>中型图</strong></a><br><span class="Dimensions"></span></li>
                <li class="<?=(empty($zoom))? 'CurrentZoom':'Zoom';?>"><a href="/pic/picedit?pid=<?=$pid?>"><strong>原图</strong></a><br><span class="Dimensions"></span></li>
            </ul>
        </div>
        <div class="clearfloat"></div>

    </div>
    <div class="pic"><img src="<?=$picname?>" /></div>
    <div id="copyCode">
        <ul id="copyCodeItem">
            <li><h5>外链代码</h5></li>
            <li>
                <label class="td">照片地址：</label><input type="text" onmouseover="this.select()" value="<?=$picname?>" class="txt" id="intro">
                <input type="button" value="复制" class="btn" onclick="copyToClipboard(document.getElementById('intro').value);" ></li>
            <li>
                <label class="td">HTML代码：</label><input type="text" onmouseover="this.select()" id="htmlCode" value="&lt;a href=&quot;<?=$picname?>&quot; title=&quot;<?=$info->custom_name;?>&quot;&gt;&lt;img src=&quot;<?=$picname?>&quot; alt=&quot;<?=$info->custom_name;?>&quot;border=&quot;0&quot; /&gt;&lt;/a&gt;" class="txt">
                <input type="button" value="复制" class="btn" onclick="copyToClipboard(document.getElementById('htmlCode').value);" >
            </li>
            <li>
                <label class="td">UBB代码：</label><input type="text" onmouseover="this.select()" value="[URL=<?=$picname?>][IMG]<?=$picname?>[/IMG][/URL]" class="txt" id="ubbCode">
                <input type="button" value="复制" class="btn" onclick="copyToClipboard(document.getElementById('ubbCode').value);" /></li>
            <li>
                <label class="td">图片短地址：</label><input type="text" onmouseover="this.select()" value="http://wal8.com/<?=$info->id?>" class="txt" id="short">
                <input type="button" value="复制" class="btn" onclick="copyToClipboard(document.getElementById('short').value);" /></li>
        </ul>
    </div>
   </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>

<script type="text/javascript">

$(document).ready(function(){

    $('a.delete').click(function(){return confirm('一旦删除将无法恢复，您确认要删除该记录吗？')});
    $(".yoxview").yoxview({
        videoSize: { maxwidth: 720, maxheight: 560 }
    });
});
</script>
<script type="text/javascript">
//<![CDATA[
  copyToClipboard = function(txt) {
  if(window.clipboardData) {
    window.clipboardData.clearData();
    window.clipboardData.setData("Text", txt);
  } else if(navigator.userAgent.indexOf("Opera") != -1) {
  //暂时无方法:-(
  } else if (window.netscape) {
  try {
   netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
  } catch (e) {
   alert("您的firefox安全限制限制您进行剪贴板操作，请打开’about:config’将signed.applets.codebase_principal_support’设置为true’之后重试");
   return false;
  }

  var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
  if (!clip)
  return;
  var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
  if (!trans)
  return;
  trans.addDataFlavor('text/unicode');
  var str = new Object();
  var len = new Object();
  var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
  var copytext = txt;
  str.data = copytext;
  trans.setTransferData("text/unicode",str,copytext.length*2);
  var clipid = Components.interfaces.nsIClipboard;
  if (!clip)
  return false;
  clip.setData(trans,null,clipid.kGlobalClipboard);
  }
  alert('图片连接已复制到剪贴板，可以使用粘贴或ctrl+v调用。');
  }
//]]>
</script>
