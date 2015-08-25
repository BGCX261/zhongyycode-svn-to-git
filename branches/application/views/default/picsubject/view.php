<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.content_box .content{width:560px; overflow:hidden;}
.recommend_lists, .new_lists{height:200px;}
</style>
<div id="body">
    <div id="main">
            <div class="content_box">
                <div class="title_box">
                    <h2><?php  if ($results['is_top']) {?><span>[顶]</span><?php } echo  $results['title']?></h2>
                    <span class="time"><?php echo  date('Y-m-d H:i', $results['add_time']);?></span>
                    <a href="/" class="back">返回首页</a>
                </div>
                <div class="tags_box">

                    <span class="count">
                        阅读：<?php echo $results['click']?> / 评论：<?php echo $results['comment']?>
                    </span>
                </div>
                <div class="content" id="copy_content">
                   <?php echo $results['content']?>
                </div>

                <div class="up_down_box">
                    <span class="up_down">
                        <a href="javascript:mood(<?php echo $results['sid'];?>, 'support');">[顶一下]</a>：<span id="support_num"><?php echo $results['support']?></span>
                        <a href="javascript:mood(<?php echo $results['sid'];?>, 'oppose');">[鄙视之]</a>：<span id="oppose_num"><?php echo $results['oppose']?></span>
                    </span>

                </div>
                <ul class="filp">
                        <li class="pre">上一专题：<?php if (!empty($preSpecial)) {?><a href="/picsubject/<?php echo $preSpecial['sid'];?>.html"><?php echo $preSpecial['title'];?></a><?php } else{ ?>没了<?php }?></li>
                        <li class="next">下一专题：<?php if (!empty($nextSpecial)) {?><a href="/picsubject/<?php echo $nextSpecial['sid'];?>.html"><?php echo $nextSpecial['title'];?></a><?php } else{ ?>没了<?php }?></li>
                </ul>
            </div>

            <div class="comment">
            <div class="title">
                <h2>留言评论</h2><sub>+Message&nbsp;comment</sub>
            </div>
            <a name="comment_list"></a>
            <?php
                if (!empty($commentList)) {
                foreach ($commentList as $comment) { ?>
              <div class="mod_comment_content">
                <?php if (!empty($comment['username'])) { ?><div class="avatar"> <a class="pic" href="/u/<?php echo $comment['username'] ?>"> <img src="<?php echo $comment['avatar'] ?>" border="0" alt=""  /> </a> </div> <?php } ?>
                <div class="main">
                  <div class="info"> <strong><?php echo (!empty($comment['username'])) ? $comment['username'] : '匿名'; ?></strong><?php echo date('Y-m-d H:i', $comment['post_time']); ?>说：
                    <?php if(!empty($auth) && ($auth['uid'] == $results['uid'])) { if (empty($comment['quote'])) { ?><a href="javascript:show_from(<?php echo $comment['cid'] ?>)" class="reply">回复</a> <?php }} ?>
                  </div>
                  <p class="content"><?php echo ($comment['content'])?></p>
                  <?php if(!empty($comment['quote'])) { ?> <p class="host_reply" style="padding-left:10px;"> <?php echo ($comment['quote']); ?></p> <?php } ?>
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
                <form action="/picsubject/replay"  method="post">
                <input type="hidden" name="replay_cid" id="replay_cid" value="" />
                <input type="hidden" name="sid" value="<?php echo $sid;?>" />
                <textarea class="text" name="content" cols="" rows=""></textarea>
                <input class="button" name="" type="submit" value="确定" />
                </form>
            </div>

            <div class="mod_fat_comments">
                <div class="comment">发表评论</div>
                <form action="/picsubject/comment" id="add_comment" method="post">
                <div class="content">
                    <input type="hidden" name="sid" value="<?php echo $sid;?>" />
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
                <a href="#" target="user">
                    <img class="avatar" src="/images/album/img/no_avatar.png" alt="" title="" border="0" />
                </a>
                <div class="info">
                    <span class="icon"></span><a class="name" href="/u/<?php echo urlencode($results['username'])?>" target="user">【<?php echo $results['username']?>】</a>
                    <p>
                        个性签名：<?php if (!empty($results['sign'])) { echo $results['sign']; } else { echo '这家伙好懒，什么也没留下';} ?>
                    </p>
                </div>
            </div>
            <div class="ft"></div>
        </div>

        <div class="topics_lists">
            <div class="hd">
                <h2>最新专题</h2>
            </div>
            <div class="bd">
                <ul class="new_lists">
                    <?php foreach ($newSpecial as $item) { ?>
                    <li><a href="/picsubject/<?php echo $item->sid;?>.html"><?php echo Str::slice($item->title, 30,'...');?></a></li>
                    <?php } ?>

                </ul>
                <div class="fold">
                    <h2>推荐专题</h2>
                </div>
                <ul class="recommend_lists">
                     <?php foreach ($newSpecial as $item) { ?>
                    <li><a href="/picsubject/<?php echo $item->sid;?>.html"><?php echo Str::slice($item->title, 30,'...');?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="ft"></div>
        </div>

        <a class="ad5" href="#">
            <img src="/images/album/banner/banner5.png" border="0" alt="" title="" />
        </a>

        <div class="mod_tags">
            <div class="hd">
                <h2>Tags</h2>
                <span class="tags">
                       <?php foreach ($tags as $tag) { ?> <a href="#"><?php echo $tag;?></a> <?php } ?>
                </span>
            </div>
            <div class="bd">
                <form action="" name="add_tags" id="add_tags" method="post">
                <div class="add"> <strong class="title">添加标签</strong>
                  <input class="text" name="tags" type="text" />
                  <input type="hidden" name="sid" value="<?php echo $sid?>">
                  <input class="submit" value="提交" name="" type="submit" />
                  <p> 多个标签以空格分开，例如：时间 地点 人物。 </p>
                </div>
                </form>
            </div>
        </div>

        <div class="mod_other">
            <div class="hd">
                <h2>其他信息</h2>
            </div>
            <div class="bd">
                <span>&copy;&nbsp;版权所有(All&nbsp;Rights&nbsp;Reserved)</span>
                <span>所有人可见</span>
                <span>拍摄于<?php echo  date('Y-m-d H:i', $results['add_time']);?></span>
                <span>该照片被浏览<?php echo $results['click']; ?>次</span>
            </div>
        </div>

    </div>
</div>
<script language="javascript" type="text/javascript">
function getCaptchaImg()
{
    $('#captchaImg').attr('src', '<?php echo URL::base().'captcha/default'; ?>?s='+Math.random());
}
function mood(sid, value)
{
    $.get("/picsubject/mood", { item_id: sid, app: value }, function(data){
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

function copy_content()
{
    var content = $('#copy_content').html();
    copyToClipboard(content);
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
});
</script>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>