<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>


<style type='text/css'>
#content{width:750px; float:left;}

#showImgages {background:#ECF5FC; border:#4FAF03 1px solid; width:700px;height:400px;overflow: auto; padding:3px 5px;  display:none;
position:absolute;
z-index:1000;}
#showImgages .h {border-bottom:1px dashed #4FAF03; width:100%; text-align:left; margin:5px 0;}
#showImgages .c {}
.current_page{background:#F7C027;}
#body{}
.message{background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent; height:30px; line-height:30px;margin-bottom:0; padding-left:85px; width:660px;}
.user_img_zs{  margin-bottom:10px; display:inline-block; height:130px; line-height:130px; width:130px; overflow:hidden;}
.cate_list{margin:10px; width:740px; list-style:none;}
.cate_list li{float:left; width:175px;margin-left:0px;background:url("/images/album/user_0right_3.gif_img_bg.gif") no-repeat scroll 20px 0 transparent; height:240px;margin-bottom:10px;text-align:center;}
.filp{float:right;margin-right:10px; width:670px; text-align:right;}
.search_true{background:url(/images/user/btn_user_search.gif) no-repeat;width:57px;height:19px; border:none;}
.huang{margin-top:0px;}
.tis{margin:10px 0 0 0;}
p.img{margin:7px 0 0 6px;height:140px; text-align:center;}
input{line-height:14px;height:12px;padding:2px 0;font-size:12px;}
.picname{color:#4FAF03;}
.move{margin:5px; text-align:left;}
form{margin:0;padding:0;}
#add_cate{background:url(/images/user/icon_17.gif); width:71px; height:19px;border:none;}
.number_page{border:1px solid #DEDEDE;display:inline-block;height:18px;line-height:18px;padding:0 2px;text-decoration:none;width:auto;}
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
    <p  class="huang" style="width:400px;float:left;">当前位置：<a href="/category/list">根目录</a>
        <?php

            foreach ($arr as $key => $cate) {?>
             -><a href="/category/list?cate_id=<?=$key?>" ><?=$cate?></a>
        <?php
            }
            if($recycle) {
                echo '->回收站';
            }
            if($cate_id != 0){
                if ($cateInfo['parent_id'] !=0) {
                echo '<a href="/category/list?cate_id='.$cateInfo['parent_id'].'">
                <img src="/images/user/up_catalog.jpg" border="0" /> </a>';
                } else {
                    echo '<a href="/category/list"> <img src="/images/user/up_catalog.jpg" border="0" /> </a>';
                }
            }
        ?>

    </p>
    <p style="width:200px; float:right; text-align:right;">

        <a href="/category/list?recycle=1" title="回收站"><img alt="回收站" src="/images/user/recycle.gif"></a>
    </p>
    <div class="clearfloat"></div>
    <div class="search">

    <fieldset>
        <legend>相册操作</legend>
            <table>
            <tr>
                <td>
                <form action="" method="get" id="form_cate">
                <input type="text" value="新建相册" name="cate_name" id="cate_name" onfocus="if (this.value == '新建相册') {this.value = '';}" onblur="if (this.value == '') {this.value = '新建相册';}" size="10"/>&nbsp;
                </td>
                <td>
                <input type="hidden" value="<?=$cate_id;?>" name="parent_id" id="parent_id" />
                <input type="button" name="new_catalog"  id="add_cate"  value="" />

               </form>
            </td>
            <td>
               <form action="" method="get" id="search">
               &nbsp;搜索：<select name="search_type" gtbfieldid="367">
                           <option value="1" <?=Str::selected($type, 1)?>>文件名</option>
                           <option value="2" <?=Str::selected($type, 2)?>>照片名</option>
                         </select>
                 <input type="text" value="<?=$keyword?>" class="border" style="width:100px;" name="keyword" />&nbsp;
                排序：
                 <select name="order_by" >
                  <option value="DESC" <?=Str::selected($order_by, 'DESC');?>>越晚上传越靠前</option>
                  <option value="ASC" <?=Str::selected($order_by, 'ASC');?>>越早上传越靠前</option>
                </select>
                <input type="hidden" value="<?=$cate_id;?>" name="cate_id" />
                </td>
                <td>
                 <input type="submit" value=""   class="search_true"/>

                 </form>

                </td>
             </tr>
            </table>

    </fieldset>

        <ul class="cate_list">
            <form action="/category/edit" method="post" id="list">
            <?php foreach ($results as $item) { ?>
            <li>
                <?php  if ($item['index_img_id'] ) { ?><div style="position:absolute;width:44px;height:51px;margin:90px 0 0 100px;"><img src="/images/user/dir.gif"  alt="封面图片"></div><?php }?>
                <p class="img"><a href="/category/list?cate_id=<?php echo $item['cate_id']?>" > <img src="<?php  echo (!empty($item['index_img'])) ? $item['index_img'] : '/images/user/category.jpg'; ?>" /></a>

                </p><br />
                <p>&nbsp;<?php if ($item['is_share'] == 1) {
                    echo '<a href="/category/setShare?cate_id=' .$item['cate_id'].'&app=del&from='.urlencode($_SERVER['REQUEST_URI']) .'" title="点击删除共享"><img src="/images/icon/tick.gif"  alt="相册已共享"/></a>';
                    } else {
                    echo '<a href="/category/setShare?cate_id=' .$item['cate_id'].'&from='. urlencode($_SERVER['REQUEST_URI']) .'" title="共享此相册"><img src="/images/icon/cog.gif"  alt="设置相册共享"/></a>';
                    }
                    ?>
                </p>
                <table align="center">
                    <tr>
                        <td width="108"><input name="text" type="text" id="cate_name_<?php echo $item['cate_id']?>" value="<?php echo $item['cate_name']?>" /></td>
                        <td><a href="javascript:editcate(<?php echo $item['cate_id']?>);" ><img src="/images/user/icon_21.gif" /></a></td>
                    </tr>
                    <tr>
                        <td width="108">数量：<?php echo $item['img_num']?> </td>
                        <td><a href="/category/del?cate_id=<?php echo $item['cate_id']?>"  class="delete"><img src="/images/user/icon_22.gif" /></a></td>
                </tr>
                </table>
            </li>
            <?php } ?>


            <?php
                if (!empty($rootresults)) {
                foreach ($rootresults as $key => $item) {
                $img = 'http://' . $item['disk_domain'] .'.wal8.com/' . $item['disk_name'] .'/' . $item['picname'];
            ?>
            <li>

               <p class="img"><img src="<?php echo 'http://' . $item['disk_domain'] .'.wal8.com/' . $thumb->create($item['disk_name'] .'/' . $item['picname'], 130,130); ?>"  onclick="showImgages(this,'<?=$img?>');" style="cursor:pointer;"/></p>
                <br />
                <div>
                <?php echo ($item['is_share'] == 1) ? '<img src="/images/icon/tick.gif" alt="当前为相册封面图片"/>': '';?>&nbsp;
                <?php if($cate_id) { ?>
                    <? if ($cateInfo['index_img_id'] != $item['id']) { ?><a href="/userpic/catetop?id=<?=$item['id']?>&cate_id=<?=$item['cate_id']?>" title="点击将该图片设置为封面图片" class="cover" onclick="return confirm('需要将该图片设为封面显示吗？');"><img src="/images/icon/image.gif" /></a><?php } ?>

                <?php } ?>
                </div>
                <table  style="text-align:center;width:165px;">
                    <tr>
                        <td><span class="picname"><input name="custom_name" value="<?=$item['custom_name']?>" /></td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:2px;">
                        <table><tr><td><input type="checkbox" name="id[]" value="<?=$item['id']?>" /></td><td><?php if($recycle > 0) { ?>
                            <a  href="/userpic/recycle?id=<?php echo $item['id']?>&recycle=0"  title="恢复"><img src="/images/icon/arrow_undo.png" /></a><?php } else {?>
                            <p style="display:none;"  id="pic_zoom<?=$item['id']?>"><?php echo $img ?></p>

                            <p style="display:none;"  id="zoom_<?=$key?>"><?php echo $item['picname'] ?></p>

                        <a href="javascript:void(0);" onclick="copy_pic('<?=$img?>');" title="复制原图"><img src="/images/user/icon_23.gif"  /></a>
                        <a href="javascript:void(0);" onclick="copypic('pic_zoom<?=$item['id']?>');" title="复制原图地址"><img src="/images/user/icon_24.gif"/></a>


                        <a href="/pic/picedit?pid=<?php echo $item['id']?>" title="编辑"><img src="/images/user/icon_21.gif" /></a>
                     <?php } ?>
                        <a  href="<?php if($recycle > 0) { ?>/userpic/delPic?id=<?php echo $item['id']?>&u=<?=urlencode($_SERVER['REQUEST_URI'])?><?php } else {?>/userpic/recycle?id=<?php echo $item['id']?>&u=<?=urlencode($_SERVER['REQUEST_URI'])?><?php } ?>" class="delete" title="删除"><img src="/images/user/icon_22.gif" /></a>
                            </td></tr></table>
                        </td>
                </tr>
                </table>
            </li>
                <?php }} ?>

        </ul>
        <div class="clearfloat"></div>

        <div class="filp"><?php echo $pagination->render('pagination/digg');?></div>
        <div class="clearfloat"></div>
        <fieldset>
                <legend>操作</legend>
         <div class="move">

            <input type="hidden" name="u" value="<?=urlencode($_SERVER['REQUEST_URI'])?>" />
            <table width="700" align="left">
            <?php if(!$recycle) { ?>
            <tr>
                <td  colspan="6" align="left">移动到 <select name="to_cate_id">
                <option value="-1">请选择相册</option>
                <?php if ($cate_id) { ?>
                <option value="0">根目录</option>
                <?php } ?>
                <?php foreach ($cate_list as $cate) { ?>
                <option value="<?=$cate['cate_id']?>"><?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', '&nbsp; &nbsp; &nbsp;'), $cate['path']) . $cate['cate_name']?></option>
                <?php } ?>

            </select>
            <td>
            </tr>
            <tr>
            <td align="left" width="50"><input type="checkbox" name="chkAll" /> 全选 </td>
            <td align="left"  width="120"><a href="javascript:setPicShare()" title="设置图片共享">设置共享</a> <a href="javascript:delPicShare()" title="删除图片共享">取消共享</a><td>

            <td align="left"  width="70"><a href="javascript:movePic();"  title="转移图片"><img src="/images/user/icon_18.gif" /></a><td>
            <td align="left"  width="70"><a href="javascript:copy2();"  title="批量复制"><img src="/images/user/icon_20.gif" /></a><td>

            <td align="left"  width="70"><a href="javascript:del();" title="批量删除图片"><img src="/images/user/icon_19.gif" /></a><td>
            <td align="left"><a href="javascript:addsubject();" >添加到专题</a><td>
            </tr>
             <?php } else { ?>
            <tr>
                <td  align="left" width="50"><input type="checkbox" name="chkAll" /> 全选 </td>
                <td align="left"><a href="javascript:delrecycle();" title="批量删除图片" id="clear_img"><img src="/images/user/icon_19.gif" /></a></td>
                <td><a href="javascript:clear_recycle();" class="delete" id="clear_recycle"><img src="/images/user/clear_recycle.gif" height="27" /></a><td>
            </tr>

            <?php } ?>
            </table>
             <br/>
            <div class="clearfloat"></div>
            <img src="/images/icon/tick.gif"  alt=""/> 表示相册已共享（点击可以删除共享）
        </div>
         </fieldset>
         </form>
    <div class="clearfloat"></div>


    </div>

   </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('select[name=order_by]').change(function(){$("#search").submit();});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
    $('#add_cate').click(function(){checkSpecialCharacter('cate_name');add_cate();});
    $('a.delete').click(function(){return confirm('您确认要删除该记录吗？')});
});
function add_cate()
{
    if ($('#cate_name').val() == '' || $('#cate_name').val() == '新建相册') {
        alert('请输入相册名称');
        return false;
    }

    $("#form_cate").attr('action', '/category/addcate').attr('method', 'post').submit();
}
function del(){
   var num = 0;
    $('input[name="id[]"]:checked').each(function(i){
       if (i == 0) i = 1;
       num += i;
    });
    if (num > 0) {
      $("#list").attr('action', '/userpic/recycle').attr('method', 'get').submit();
      alert('图片已经被移到回收站，请及时清空回收站！');
    } else {
        alert('请选择需要删除的文件');
    }
}
function delrecycle(){
    var arr = new Array();
    $('input[name="id[]"]:checked').each(function(i){
        arr[i] = $(this).val();
    });
    if (arr.length ===0) {
        alert('请选择需要删除的文件');
    } else {
        $('#showImgages').css('height', '200px');
        $('#showImgages').css('text-align', 'center');
        $('#showImgages > .c').css('padding-top', '50px');
        $('#showImgages > .c').html('<h1 style="color:#F00;">图片正在清空中,请不要进行其它操作,以免图片清空操作中断</h1>');
        $('#showImgages').css('left',$('#clear_img').offset().left-120);
        $('#showImgages').css('top', $('#clear_img').offset().top - 150);
        $('#showImgages').show();
        setTimeout(function(){
            $('#showImgages').show();
        }, 3000);
        $.each(arr, function(i){
            $.get("/userpic/delpic", { "id": arr[i], "type": "ajax" }, function(data){
            });
        });
        setTimeout(function(){
             $('#showImgages > .c').html('<h1 style="color:#F00;">图片清空成功,即将涮新缓存</h1>');
             window.location.href = "/category/list?recycle=1";
        }, 3000);

    }
}
function clear_recycle()
{

        $('#showImgages').css('height', '200px');
        $('#showImgages').css('text-align', 'center');
        $('#showImgages > .c').css('padding-top', '50px');
        $('#showImgages > .c').html('<h1 style="color:#F00;">正在清空回收站中,请不要进行其它操作,以免操作中断</h1>');

        $('#showImgages').show();
        setTimeout(function(){
        }, 3000);

        $.get("/userpic/clear",  function(data){
            if (data == 'success') {
                setTimeout(function(){
                     $('#showImgages > .c').html('<h1 style="color:#F00;">清空回收站成功,即将涮新缓存</h1>');
                     window.location.href = "/category/list?recycle=1";
                }, 3000);
            }
        });

}


// 复制原图zoom, 标准图rule
function copypic(id){
    var str = $('#' + id).html();
    if (str != '') {
        copyToClipboard(str);
    }
}
function copy()
{
    var str = '';
   $('input[name="id[]"]:checked').each(function(i){

       var thumb_img = $('#pic_rule_2' + $(this).val()).html();

       str += '<img src=\"' + thumb_img + '\" /><br />';
   });

   if(str==''){
        alert('请选择图片');
    }else{
        copyToClipboard(str);
    }
}
function copy2()
{
    var str = '';
   $('input[name="id[]"]:checked').each(function(i){

       var thumb_img = $('#pic_zoom' + $(this).val()).html();

       str += '<img src=\"' + thumb_img + '\" /><br />';
   });

   if(str==''){
        alert('请选择图片');
    }else{
        copyToClipboard(str);
    }
}
function setPicShare(){
     $("#list").attr('action', '/userpic/setShare?u=<?=urlencode($_SERVER["REQUEST_URI"])?>').attr('method', 'post').submit();
}
function delPicShare(){
     $("#list").attr('action', '/userpic/setShare?u=<?=urlencode($_SERVER["REQUEST_URI"])?>&app=del').attr('method', 'post').submit();
}
function movePic(){
    if($("select[name=to_cate_id]").val() < 0) {
        alert('请先择要移动的目录');
        return ;
    }
    var num = 0;
    $('input[name="id[]"]:checked').each(function(i){
       if (i == 0) i = 1;
       num += i;
    });
    if (num > 0) {
        $("#list").attr('action', '/userpic/movePic?u=<?=urlencode($_SERVER["REQUEST_URI"])?>').attr('method', 'post').submit();
    } else {
        alert('请选择需要移动的文件');
    }

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
function editcate(id){
    var name = $('#cate_name_' + id).val();
    $.get("/category/edit", { cate_name: name, cate_id: id },function(data){
        alert(data);
    });
}


function showImgages(obj, src)
{
    var img = "<img src=\"" + src + "\" />";
    $('#showImgages > .c').html(img);
    $('#showImgages').show();
    $('#showImgages').css('left',$(obj).offset().left-120);
    $('#showImgages').css('top', $(obj).offset().top - 150);
}
</script>
<div id="showImgages">
<div class="h"><a href="javascript:" onclick="$('#showImgages').hide();">关闭</a></div>
<div class="c"></div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>