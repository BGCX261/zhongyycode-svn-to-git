<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:0;padding-left:85px;width:660px;}
.bj_A {background:url("/images/user/user_banjia_B_bg.gif") no-repeat scroll 0 0 transparent;height:639px;padding-left:67px;padding-top:127px;}
.user_banjia {margin-top:10px;position:relative;}
input{border:0px;}
.bj_A p {margin-top:5px;}
.tcent {text-align:center;}
p {line-height:20px;}
.fright{float:right;}
.user_banjia .user_banjia_btn {left:36px;position:absolute;top:5px;padding-left:25px;width:300px;height:30px;line-height:30px; text-align:left;color:#FFF;}
.user_banjia .user_banjia_btn a {color:#4FAF03;font-weight:bold}
.fenye{margin-right:50px;}
</style>

<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="content">
        <div class="zxxx">
            <marquee scrolldelay="150" onmouseout="this.start();" onmouseover="this.stop();" behavior="scroll" direction="left" aligh="left">
                <?=$configs['marquee_message']?>
            </marquee>
        </div>
        <div><img src="/images/user/user_banjia_top_2.gif"></div>
        <div class="user_banjia_btn"><a href="move_item.php">&nbsp;</a> <a style="margin-left: 10px;" href="move_item_hist.php">&nbsp;</a></div>
        <div class="user_banjia bj_A">
            <form name="moveitem_form" id="moveitem_form" method="post" action="move_item.php">
                    <ul>
                    <?php foreach ($results as $item) { ?>
                        <li>
                        <p><span style="margin-right: 100px;" class="fright">
                        <a href="#"><img onclick="copycode('sourceok_<?=$item['id']?>')" src="/images/user/icon_4.gif" alt="复制"> </a>

                        <a onclick="return confirm('您确定要删除此记录？');" href="/movehome/del?id=<?=$item['id']?>">
                        <img src="/images/user/icon_6.gif" alt="删除"></a>
                        </span>
                        <span class="green"><?=$item['title']?></span>
                        &nbsp; 完成时间：<?=$item['update_time']?> </p>
                        <p> &nbsp; &nbsp; &nbsp; 代码：<textarea style="border: 1px solid rgb(204, 204, 204);" cols="63" rows="6" id="sourceok_<?=$item['id']?>"><?=$item['content']?> </textarea></p>
                        </li>
                    <?php } ?>
                    </ul>
                    <div class="clear fenye">&nbsp;&nbsp;<?php echo $pagination->render('pagination/digg');?></div>
                   <div class="user_banjia_btn"><a href="/movehome">产品搬家</a> <a style="margin-left: 60px;color:#FFF" href="/movehome/list">历史记录</a></div>
               </form>
           </div>

    </div>
</div>
<script language="javascript" type="text/javascript">
function copycode(id)
{
    var content = $('#' + id).val();
    copyToClipboard(content);
}

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
  alert('专题图片源代码已复制到剪贴板，可以使用粘贴或ctrl+v调用。');
  }
//]]>
</script>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>