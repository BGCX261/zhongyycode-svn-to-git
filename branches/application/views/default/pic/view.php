<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.mod_share_album {height:200px;overflow:hidden;}
#report_content {background:#ECF5FC; border:#BBDB9A 1px solid; width:300px; padding:3px 5px; position:absolute; display:none;}
#report_content .h {border-bottom:1px dashed #BBDB9A; width:100%; text-align:right; margin:5px 0;}
#report_content .c {}
</style>
<link href="/styles/album/photos_show.css" rel="stylesheet" type="text/css" />


<div id="body" style="width:960px;">
  <div id="content">
    <div class="photos">
      <div class="title">
        <h2><?=$imgInfo['custom_name']?></h2>
        <div class="clearfloat"></div>
        <span class="upload_time" style="float:left;">上传用户：【<?=$imgInfo['username']?>】 上传于<?php echo date('Y-m-d', $imgInfo['uploadtime']);?> </span><span class="back"><a href="javascript:" onclick="report(this);">举报</a><a href="/">返回首页</a> </span> </div>
        <div class="clearfloat"></div>
        <div style="border-bottom:4px solid #85C64E;"></div>
      <div class="pic">
      <br />
      <img src="<?php echo URL::domain() . Str::changeLoad($thumb->create($imgInfo['img_dir'] .'/' . $imgInfo['picname'], 640,640, 's')); ?>"  alt="<?=$imgInfo['custom_name']?>"/><br />
          <br />
         <a class="img" href="/pic/zoom?id=<?php echo $imgInfo['id']; ?>">查看原图 </a> </div>
    </div>
    <div class="comment">
      <div class="title">
        <h2>留言评论</h2>
        <sub>+Message&nbsp;comment</sub> </div>
    <?php
        if (!empty($commentList)) {
        foreach ($commentList as $comment) { ?>
      <div class="mod_comment_content">
        <div class="avatar"> <?php if(!empty($comment['username']))  {?><a class="pic" href="/u/<?php echo $comment['username'] ?>"> <img src="<?php echo $comment['avatar'] ?>" border="0" alt=""  /> </a> <?php } else { ?> <a class="pic" href="#"><img src="/images/album/no_avatar.png" border="0" alt=""  /></a><?php }?> </div>
        <div class="main">
          <div class="info"> <strong><?=(!empty($comment['username'])) ? $comment['username'] : '匿名'; ?></strong><?php echo date('Y-m-d H:i', $comment['post_time']); ?>说：
            <?php if(!empty($auth) && ($auth['uid'] == $imgInfo['userid'])) { ?>
           <?php if(empty($comment['quote'])) { ?>
            <a href="javascript:show_from(<?php echo $comment['cid'] ?>)" class="reply">回复</a> <?php }} ?>
          </div>
          <p class="content">
              <?php echo $comment['content']?>
          </p>
            <?php if(!empty($comment['quote'])) { ?>  <p class="host_reply"> <?php echo $comment['quote'] . '<br/></p>'; } ?>
          <div id="reply_<?php echo $comment['cid'] ?>"></div>
        </div>
      </div>
  <?php } } else { ?>
        <div class="mod_comment_content">
        <div class="main">
         暂无评论
        </div>
      </div>
  <?php } ?>
  <div id="replay_from" style="display:none;">
    <form action="/pic/replay" id="add_tags" method="post">
    <input type="hidden" name="replay_cid" id="replay_cid" value="" />
    <input type="hidden" name="pid" value="<?php echo $imgInfo['id'];?>" />

    <textarea class="text" name="content" cols="" rows=""></textarea>
    <input class="button" name="" type="submit" value="确定" />
    </form>
  </div>
      <div class="mod_fat_comments">
        <div class="comment">发表评论</div>
        <form action="/pic/comment" id="add_tags" method="post">
        <div class="content">
          <input type="hidden" name="pid" value="<?php echo $imgInfo['id'];?>" />
          <textarea name="content" cols="" rows=""></textarea>
          <div class="code_login">
            <?php if (!$auth) { ?>
                <input class="code_text" name="captcha" type="text" />
                <img id="captchaImg" src="<?php echo URL::base().'captcha/default'; ?>" height="30" width="130" align="absmiddle" onclick="getCaptchaImg();" />
                <a href="javascript:getCaptchaImg();">看不清，换一张</a> <span class="published"> 已有账号请<a class="login" href="/user/login?forward=<?=urlencode($_SERVER['REQUEST_URI'])?>">登陆</a>
                    <input class="botton" name="" type="submit" value=" 发 表 " />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </span>
                <?php } else { ?>
                    <input class="botton" name="" type="submit" value=" 发 表 " />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <?php } ?>
               </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div id="side">
    <div class="mod_user_info">
      <div class="hd"></div>
      <div class="bd">
            <a href="/u/<?php echo urlencode($imgInfo['username'])?>" target="user"> <img class="avatar" src="<?php echo (!empty($imgInfo['avatar'])) ? $imgInfo['avatar'] : '/images/album/img/no_avatar.png'?>" alt="" width="92" height="92"  border="0" /> </a>
           <div class="info"> <span class="icon"></span><a class="name" href="/u/<?php echo urlencode($imgInfo['username']);?>" target="user">【<?php echo $imgInfo['username']?>】</a>
          <p>个性签名： <?php echo (!empty($imgInfo['sign'])) ? $imgInfo['sign'] : '这家伙好懒，什么也没留下';?> </p>
        </div>
      </div>
      <div class="ft"></div>
    </div>
    <div class="clearfloat"></div>

<style type="text/css">
/* Tiny Carousel */
#slider1 { height: 1%; overflow:hidden; padding: 0 0 10px; border:3px solid #BBDB9A;  }
#slider1 .viewport { float: left; width: 275px; height: 135px;margin:10px 0 0 10px;+margin:0 0 0 10px;padding:0; overflow: hidden; position: relative; text-align:center; }
#slider1 .buttons {background:url("/images/album/img/icon.png") no-repeat scroll -167px 0 transparent; display: block; margin:0px 10px 0 0; background-position: 0 -38px; text-indent: -999em; float: left; width: 39px; height: 37px; position: absolute;overflow: hidden;  }
#slider1 .next { background:url("/images/album/img/icon.png") no-repeat scroll -151px 0 transparent;float:right; margin: 70px 0 0 296px;+margin: 70px 0 0 5px; width:18px }
#slider1 .prev {background:url("/images/album/img/icon.png") no-repeat scroll -167px 0 transparent;margin: 90px 0 0 0px; width:17px;}
#slider1 .disable { visibility: hidden; }
#slider1 .overview { list-style: none;  padding: 0; width: 480px; margin: 0 2px 0px 10px; }
#slider1 .overview li{ float: left; margin: 0 5px 0 0px; padding: 1px; height: 131px;  width: 84px;}
#slider1 .overview li .photo {-moz-box-shadow:3px 3px 10px -4px #AAAAAA;background:none repeat scroll 0 0 #FFFFFF;border:1px solid #E9EBEA;display:block;height:72px;margin-bottom:5px;padding:2px;width:72px;margin-left:2px;margin-top:5px;}
#slider1 table{color:#50B004;margin:5px 0 0 10px;}
</style>
    <div id="slider1">
        <a class="buttons prev" href="#" id="prev_pic">left</a>
        <table>
                <tr>
                <td>相册名：</td>
                <td><h2><?php echo Str::slice($imgInfo['cate_name'], '15', '...');?></h2></td>
                <td></td>
                </tr>
            </table>
        <div class="viewport">
            <ul class="overview" id="other_list">

            </ul>
        </div>
        <a class="buttons next" href="#" id="next_pic">right</a>
    </div>

    <?php if ($auth) { ?>
    <form action="/pic/comment" id="add_tags" method="post">
    <input type="hidden" name="pid" value="<?php echo $imgInfo['id'];?>" />
    <input type="hidden" name="uid" value="<?php echo $auth['uid'];?>" />
    <div class="quick_comments">
      <div class="hd">
        <h2>快速评论</h2>
        <input class="submit" name="" type="submit" value="发表" />
      </div>
      <div class="bd">
        <textarea name="content" cols="" rows=""></textarea>
      </div>

    </div>
    </form>
    <?php } ?>
    <div class="mood">
      <div class="hd">
        <h2>心情</h2>
      </div>
      <div class="bd"> <span class="up"> <a class="pic" href="javascript:mood(<?php echo $imgInfo['id'];?>, 'support');"> <img src="/images/album/img/mood_up.png" alt="" title="" border="0" /> </a><br />
        <a class="text" href="javascript:mood(<?php echo $imgInfo['id'];?>, 'support');">[赞一下]</a> </span>
        <span class="down"> <a class="pic" href="javascript:mood(<?php echo $imgInfo['id'];?>, 'oppose');"> <img src="/images/album/img/mood_down.png" alt="" title="" border="0" /> </a><br />
        <a class="text" href="javascript:mood(<?php echo $imgInfo['id'];?>, 'oppose');">[鄙视之]</a> </span>
        <div class="count"> <span class="comment">已有<strong><?php echo $imgInfo['comment_num']?></strong>人评论</span> <span class="mood">赞美<strong id="support_num"><?php echo $imgInfo['support']?></strong>人&nbsp;/&nbsp;鄙视<strong id="oppose_num"><?php echo $imgInfo['oppose']?></strong>人</span> </div>
      </div>
    </div>
    <div class="tags">
      <div class="hd">
        <h2>Tags</h2>
        <?php if(!empty($tags)) {
            $str =  '<font color="green">';
            foreach ($tags as $tag) {
             $str .= '<a href="/tags?uid=' . $imgInfo['userid'] . '&tags='. $tag . '" >'. $tag . '</a> &nbsp;&nbsp;';
            }
            $str .='</font>';
            echo $str;
        }?>
      </div>
      <div class="bd">
        <form action="" name="add_tags" id="add_tags" method="post">
        <div class="add"> <strong class="title">添加标签</strong>
          <input class="text" name="tags" type="text" />
          <input type="hidden" name="pid" value="<?php echo $pid?>">
          <input class="submit" value="提交" name="" type="submit" />
          <p> 多个标签以空格分开，例如：时间 地点 人物。 </p>

        </div>
        </form>
      </div>
    </div>
    <div class="other">
      <div class="hd">
        <h2>其他信息</h2>
      </div>
      <div class="bd"> <span>&copy;&nbsp;版权所有(All&nbsp;Rights&nbsp;Reserved)</span> <span>所有人可见</span> <span>拍摄于2010-9-18</span> <span>该照片被浏览<?php echo $imgInfo['click'] ?>次</span> <span>这张照片入选了每周推荐照片</span> </div>
    </div>
  </div>
</div>
<div id="report_content">
<div class="h"><a href="javascript:" onclick="$('#report_content').hide();">关闭</a></div>
<div class="c">
<p>如果您在该网页中发现有色情、暴力、反动等不良内容，请填写以下表格联系我们：<p>
<p><textarea name="report_content" cols="50" rows="5"></textarea><p>
<br />
<p><input class="botton" name="" type="button" value="举报" id="report_ajax" />&nbsp;<input class="botton" onclick="$('#report_content').hide();" name="" type="button" value="取消" /><p>
</div>
</div>
<script language="javascript" type="text/javascript">
function getCaptchaImg()
{
    $('#captchaImg').attr('src', '<?php echo URL::base().'captcha/default'; ?>?s='+Math.random());
}
function report(obj)
{

    $('#report_content').css('left', $(obj).offset().left-300);
    $('#report_content').css('top', $(obj).offset().top);
    $('#report_content').show();

}
function mood(pid, value)
{
    $.get("/pic/mood", { item_id: pid, app: value }, function(data){
        if (data != '') {
            alert( data);
        } else {
             var num = Number($('#' + value + '_num').html()) + 1;
            $('#' + value + '_num').html(num);
        }
    });
}
function show_from(cid, content)
{
    $('#replay_from #replay_cid').val(cid);
    $('#reply_'+ cid).html($('#replay_from').html());
}
$(document).ready(function(){

    $('form[name=add_tags]').submit(function(){
        var tag = $('input[name=tags]');
        if(tag.val() == '') {
            alert('请输入标签');
            tag.focus();
            return false;
        }
    });
    $('#report_ajax').click(function(){
        var content = $('textarea[name=report_content]').val();
        if (content == '') {
            alert('请输入举报内容');
            return false;
        }
        $.get("/common/report/pic", { "content": content, "item_id": <?php echo $imgInfo['id']; ?> },function(data){                alert(data);
            $('textarea[name=report_content]').val('');
            $('#report_content').hide();
        });
    });
    $.getJSON("/pic/ajaxSharePic", { "cate_id": <?=$imgInfo['cate_id']?>, "uid": <?=$imgInfo['userid']; ?>, "id": <?=$imgInfo['id']; ?>},function(data){

        $('#other_list').html(data.pic_list);
        $('#next_pic').html(data.next_id);
        $('#prev_pic').html(data.prev_id);
    });
    $('#prev_pic').click(function(){
        var id = $(this).html();
        if(id <= 0) return false;
        $.getJSON("/pic/ajaxSharePic", { "cate_id": <?=$imgInfo['cate_id']?>,  "uid": <?=$imgInfo['userid']; ?>, "id": id},function(data){

            $('#other_list').html(data.pic_list);
            $('#next_pic').html(data.next_id);
            $('#prev_pic').html(data.prev_id);
        });
    });
    $('#next_pic').click(function(){
        var id = $(this).html();
        if(id <= 0) return false;
        $.getJSON("/pic/ajaxSharePic", { "cate_id": <?=$imgInfo['cate_id']?>, "uid": <?=$imgInfo['userid']; ?>, "id": id},function(data){
            $('#other_list').html(data.pic_list);
            $('#next_pic').html(data.next_id);
            $('#prev_pic').html(data.prev_id);
        });
    });

});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>