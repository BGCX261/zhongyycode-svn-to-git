<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/jquery/yoxview/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/yoxview/yox.js"></script>
<script type="text/javascript" src="/scripts/jquery/yoxview/yoxview-init.js"></script>
<link href="/scripts/jquery/yoxview/yoxview.css" rel="stylesheet" type="text/css" />
<style type='text/css'>
#content{width:750px; float:left;}
.message{background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent; height:30px; line-height:30px;margin-bottom:0; padding-left:85px; width:660px;}
.user_img_zs{  margin-bottom:10px; display:inline-block; height:130px; line-height:130px; width:130px; overflow:hidden;}
.cate_list{margin:10px;list-style:none;}
.cate_list li{float:left; width:175px;margin-left:5px;background:url("/images/album/user_0right_3.gif_img_bg.gif") no-repeat scroll 0 0 transparent;}
.filp{float:right;margin-right:10px; width:670px; text-align:right;}
.move{margin:5px; text-align:right;}
.tis{margin:15px 0;}
p.img{ clear:both;margin:7px 0 0 6px;height:130px;width:130px;}
.picname{margin:10px 0 0 0 ;}
.search_true{background:url(/images/user/btn_user_search.gif) no-repeat;width:57px;height:19px; border:none;}
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
    <p  class="huang">当前位置：<a href="/category/list">根目录</a>&gt <a href="/userpic/list?cate_id=<?php echo $cate_id; ?>"><?= $cate_rows['cate_name'] ;?></a></p>
    <div class="search">
    <form action=""  id="picsearch">

    <fieldset>
        <legend> 搜索图片</legend>
                相册:
                <select name="cate_id">
                <option value="-1">请选择</option>
                <option value="0">根目录</option>
                <?php foreach ($cate_list as $cate) { ?>
                <option value="<?=$cate['cate_id']?>" <?=Str::selected($cate_id, $cate['cate_id']);?>><?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', '&nbsp; &nbsp; &nbsp;'), $cate['path']) . $cate['cate_name']?></option>
                <?php } ?>
                </select>
                照片名
                 <input type="text" value="<?php echo $keyword?>"  name="keyword" />&nbsp;
                排序：
                 <select name="order_by" >
                  <option value="0">请选择</option>
                  <option value="ASC" <?=Str::selected($order_by, 'ASC');?>>越晚上传越靠前</option>
                  <option value="DESC" <?=Str::selected($order_by, 'DESC');?>>越早上传越靠前</option>
                </select>
                 每页显示数量
                <select name="page_num" >
                  <option value="0">请选择</option>
                  <option value="20" <?=Str::selected($page_num, '20');?>>20</option>
                  <option value="40" <?=Str::selected($page_num, '40');?>>40</option>
                  <option value="60" <?=Str::selected($page_num, '60');?>>60</option>
                </select>
                 <input type="submit" value=""   class="search_true"/>

    </fieldset>
    </form>
    <form action="" method="post"  id="picList">
         <input name="cate_id" type="hidden" value="<?=$cate_id?>" />
        <ul class="cate_list yoxview">
            <?php foreach ($results as $key => $item) { ?>
            <li>
                <p class="img"><a href="/<?php echo $item['id']?>.html" target="__blank"> <img src="<?php echo 'http://' . $item['disk_domain'] .'.wal8.com/' . $thumb->create($item['disk_id']. '/'.$item['userid'] .'/' . $item['picname'], 120,100); ?>" /></a></p>
                <br />
                <div><?php echo ($item['is_share'] == 1) ? '已共享': '';?>&nbsp;<? if ($cate_rows['index_img_id'] != $item['id'] && $item['cate_id'] != 0) { ?><a href="/userpic/catetop?id=<?=$item['id']?>&cate_id=<?=$item['cate_id']?>" title="点击将该图片设置为封面图片" class="cover" onclick="return confirm('需要将该图片设为封面显示吗？');"><img src="/images/icon/image.gif" /></a><? } ?></div>
                <table>
                    <tr>
                        <td>图片名:<input name="text" type="text"  size="15" value="<?php echo $item['custom_name']?>" /></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="id[]" value="<?=$item['id']?>" />
                            <input type="hidden" value="<?php echo 'http://' . $item['disk_domain'] . '.wal8.com/'. $item['disk_id']. '/'.$item['userid'] .'/' . $item['picname'] ?>" name="picname_true"  id="zoom_<?=$key?>"/>
                            <a href="<?php echo 'http://' . $item['disk_domain'] .'.wal8.com/' . $thumb->create($item['disk_id']. '/'.$item['userid'] .'/' . $item['picname'], 640,640, 's'); ?>" title="查看标准图"><img src="/images/user/icon_23.gif" /></a>

                        <img src="/images/user/icon_24.gif" onclick="copypic('pic_rule_<?php echo $key?>');" alt="复制标准图地址"/>
                        <input id="pic_rule_<?php echo $key?>"  type="hidden" value="<?php echo 'http://' . $item['disk_domain'] .'.wal8.com/' . $thumb->create($item['disk_id']. '/'.$item['userid'] .'/' . $item['picname'], 640,640, 's'); ?>"/>

                        <img src="/images/user/icon_30.gif"  onclick="copypic('zoom_<?php echo $key?>');" alt="复制原图地址"/>
                        <a href="/pic/picedit?pid=<?php echo $item['id']?>" title="编辑"><img src="/images/user/icon_21.gif" /></a>
                        <a  href="/userpic/delPic?id=<?php echo $item['id']?>" class="delete" title="删除"><img src="/images/user/icon_22.gif" /></a></td>
                </tr>
                </table>
            </li>
                <?php } ?>
        </ul>
        <div class="clearfloat"></div>
        <?php if (!empty($results)) { ?>
        <div class="move">
            <table><tr>
            <td><input type="checkbox" name="chkAll" /> 全选 </td>
            <td><a href="javascript:setShare()" >设置共享</a> <a href="javascript:delShare()" >取消共享</a><td>
            <td>| 移动到 <select name="to_cate_id">
                <option value="-1">请选择相册</option>
                <?php if ($cate_id) { ?>
                <option value="0">根目录</option>
                <?php } ?>
                <?php foreach ($cate_list as $cate) {
                    if ($cate_id != $cate['cate_id']) {
                ?>
                <option value="<?=$cate['cate_id']?>"><?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', '&nbsp; &nbsp; &nbsp;'), $cate['path']) . $cate['cate_name']?></option>
                <?php }} ?>
            </select><td>
            <td><a href="javascript:movePic();"  title="转移图片"><img src="/images/user/icon_18.gif" /></a><td>
            <td><a href="javascript:copy();"  title="批量复制"><img src="/images/user/icon_20.gif" /></a><td>
            <td><a href="javascript:del();" title="批量删除图片"><img src="/images/user/icon_19.gif" /></a><td>
            <td><a href="javascript:addsubject();" >添加到专题</a><td>

            </tr></table>
        </div>
        <div class="filp"><?php echo $pagination->render('pagination/digg');?></div>
       <?php } ?>
        </form>
    </div>

   </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>

<script type="text/javascript">
function movePic(){
    if($("select[name=to_cate_id]").val() < 0) {
        alert('请先择要移动的目录');
        return ;
    }
     $("#picList").attr('action', '/userpic/movePic').attr('method', 'post').submit();
}
function setShare(){
     $("#picList").attr('action', '/userpic/setShare?u=<?=urlencode($_SERVER["REQUEST_URI"])?>').attr('method', 'post').submit();
}
function delShare(){
     $("#picList").attr('action', '/userpic/setShare?u=<?=urlencode($_SERVER["REQUEST_URI"])?>&app=del').attr('method', 'post').submit();
}
function del(){
     $("#picList").attr('action', '/userpic/delpic').attr('method', 'get').submit();
}
function addsubject(){
   var arr = new Array();
   $('input[name="id[]"]:checked').each(function(i){
       arr[i] = $(this).val();
   });
   var str = arr.join("-");
   if (str == '') {
       alert('请选择图片')
   } else {
    location.href="/picsubject/add?id=" + str;
   }
}

function copy()
{
    var str = '';
   $('input[name="id[]"]:checked').each(function(i){
       str += '<img src=\"' + $(this).nextAll('input').attr('value') + '\" /><br />';
   });

   if(str==''){
        alert('请选择图片');
    }else{
        copyToClipboard(str);
    }
}
// 复制原图zoom, 标准图rule
function copypic(id){
    var str = $('#' + id).val();
    if (str != '') {
        copyToClipboard(str);
    }
}


$(document).ready(function(){
    $('select[name=cate_id]').change(function(){$("form:first").submit();});
    $('select[name=order_by]').change(function(){$("form:first").submit();});
    $(".yoxview").yoxview({
        videoSize: { maxwidth: 720, maxheight: 560 }
    });
    $('a.delete').click(function(){return confirm('一旦删除将无法恢复，您确认要删除该记录吗？')});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
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
