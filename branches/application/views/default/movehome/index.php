<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:0;padding-left:85px;width:660px;}
.bj_A {background:url("/images/user/user_banjia_A_bg_2.gif") no-repeat scroll 0 0 transparent;height:639px;padding-left:67px;padding-top:127px;}
.user_banjia {margin-top:10px;position:relative;}
input{border:0px;}
.bj_A p {margin-top:5px;}
.tcent {text-align:center;}
p {line-height:20px;}
.fright{float:right;}
.user_banjia .user_banjia_btn {left:36px;position:absolute;top:5px;padding-left:25px;width:300px;height:30px;line-height:30px; text-align:left;color:#FFF;}
.user_banjia .user_banjia_btn a {color:#FFF;font-weight:bold}
#save_show{display:none;width:500px;height:400px;background:#ccc;position:absolute}
.close{float:right;color:#4FAF03;font-weight:bold;cursor:hand;}
.percent_num{color:#4FAF03;margin:10px auto; text-align:center;}
.percent_bar{width:490px;border:1px solid #4FAF03;height:20px;margin:0 auto;padding:0; position:relative;}
.percent_bar #bar{background:none repeat scroll 0 0 #F8DA62;color:#333333;display:block;height:20px;line-height:20px;position:relative;text-align:center;width:0;margin:0;padding:0;}
.percent_stat{ text-align:center;color:#4FAF03;font-size:16px;margin-top:10px;}

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

            <form name="moveitem_form" id="moveitem_form" method="post" action="">
                   <p>使用帮助：<a target="_blank" class="ahuang" href="/help?k=11">[查看]</a>
                   <span style="margin-left: 50px;" class="green">注：本站图片不允许搬家</span></p>
                   <br><br>
                   <p><span style="display: inline-table; width: 60px; float: left;">宝贝名称：</span>
                    </p>
                <div id="save_show">
                    <div class="close">关闭</div>
                    <div class="percent_num"></div>
                    <div class="percent_bar"><span id="bar">&nbsp;</span></div>
                     <div class="percent_stat"><span></span></div>
                </div>
                    <!--$_POST:title,source,sbm_album-->
                   <input type="text" style="border: 1px solid rgb(204, 204, 204); width: 402px; height: 22px; line-height: 22px;" id="title" name="title" gtbfieldid="205" value="<?=@$info['title']?>">
                   <p><span style="display: inline-table; width: 60px; text-align: right;">源码：</span>
                   <textarea style="border: 1px solid rgb(204, 204, 204); color:#000;" cols="95" rows="7" name="source"><?=@$info['src_content']?></textarea> </p>
                   <br>

                   <p class="tcent">
                    <input type="button" style="background: url(/images/user/user_banjia_tijiao.gif) repeat scroll 0% 0% transparent; width: 64px; height: 27px;" id="sbm_album" value=" " name="sbm_album">
                    &nbsp; &nbsp;
                   </p><div style="margin-top: 20px;"><p>
                   <span style="margin-right: 100px;" class="fright">
                    <input type="button" style="background: url(/images/user/icon_4.gif) repeat scroll 0% 0% transparent; width: 44px; height: 18px;" onclick="copycode()">

                    </span>
                   <span class="green">本次搬家：</span> &nbsp;
                   </p><p><span style="display: inline-table; width: 60px; text-align: right;">代码：</span>
                   <textarea id="code"  name="code" style="border: 1px solid rgb(204, 204, 204);" cols="90" rows="6"><?=@($info['content'])?></textarea></p>
                   </div>
                   <div class="user_banjia_btn"><a href="/movehome">产品搬家</a> <a style="margin-left: 60px;color:#4FAF03" href="/movehome/list">历史记录</a></div>
               </form>
           </div>

    </div>
</div>

<script language="javascript" type="text/javascript">
function copycode()
{
    var content = $('#code').val();
    copyToClipboard(content);
}
$(document).ready(function() {
    $('form:first').submit(function(){
        if($('textarea[name=source]').val() == '') {
            alert('搬家的源码不允许为空');
            $('textarea[name=source]').fcous();
            return false;
        }

    });
    $('.close').click(function(){$('#save_show').hide();});
    $('#sbm_album').click(function(){
         imageSave();
    });
});
function imageSave()
{
    var content = $("textarea[name=source]").val();
    var title = $("input[name=title]").val();
    if (content == '') {
        alert('搬家的源码不允许为空');
        return false;
    } else {
        $.post("/movehome/getimg", { "content": content, "title": title  }, function(data){
           var imgs = [];
           imgs = data.split(",");

           if (imgs.length > 0) {
                $('#save_show').show();
                $('.percent_num').html('转存图片数量：0/' + imgs.length);
                $('.percent_bar span').css('width', '0%');
                $('.percent_stat span').html(0);
                var p = 0;
                $.each(imgs, function(i, src){
                    $.get('/movehome/saveimg',{ "src": src, "title": title },  function(data){
                        p++;
                        var per = Math.ceil(p / imgs.length * 100);
                        $('.percent_num').html('转存图片数量：'+ p + '/' + imgs.length);
                        var n = per / 100  * 490;
                        $('.percent_bar span').css('width', parseInt(n) + 'px');
                        $('.percent_stat span').css('width', parseInt(n) + 'px').html(per);
                        content = content.replace(new RegExp(src,"gm"), data);
                        if (per == 100) {
                           $("#code").val(content);

                            alert('图片文件转存成功！');
                            $('#save_show').hide();
                            $('#moveitem_form').submit();
                        }
                    });
                });
            } else {
                alert('未找到任何外部图片');
            }
        });
    }

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