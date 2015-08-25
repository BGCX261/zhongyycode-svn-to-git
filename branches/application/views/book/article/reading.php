<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<div id="body">
    <div id="main">
        <div class="content">
            <div class="hd">
                <h2><?=$info['title']?></h2>
                <div class="info">
                    <a class="name" href="#"><?=$info['username']?></a>
                    收录于 <?=date('Y-m-d H:i', $info['post_date'])?>
                    <ul class="count">
                        <li><a href="javascript:" onclick="report(this);">举报</a></li>
                        <li>阅读：<?=$info['views']?></li>
                        <li>评论：<?=$info['comments']?></li>
                    </ul>
                </div>
            </div>

            <div class="bd">
                <a class="ad">
                    <img src="/images/album/banner/banner2.png" border="0" alt="" title="" width="685" height="80" />
                </a>
                <div class="text" style="width:650px;overflow:hidden;color:#000;">
                    <?=$info['content']?>
                </div>
            </div>

            <div class="ft">
                <ul class="filp">
                    <li class="pre">上一篇：<a href="/articles/<?=$preArticle['article_id']?>.html"><?=$preArticle['title']?></a></li>
                    <li class="next">下一篇：<a href="/articles/<?=$nextArticle['article_id']?>.html"><?=$nextArticle['title']?></a></li>
                </ul>
            </div>

        </div>

        <div class="comment">
            <div class="title">
                <h2>留言评论</h2><sub>+Message&nbsp;comment</sub>
            </div>
            <?php
                if (!empty($commentList)) {
                foreach ($commentList as $comment) { ?>
              <div class="mod_comment_content">
                <div class="avatar"> <?php if (!empty($comment['username'])) { ?> <a class="pic" href="/u/<?php echo $comment['username'] ?>"> <img src="<?=(!empty($comment['avatar'])) ?  $comment['avatar'] : '/images/album/img/no_avatar.png'; ?>" border="0" alt=""  /> </a><?php } else { ?> <a class="pic" href="#"> <img src="/images/album/img/no_avatar.png" border="0" alt=""  /></a> <?php } ?>  </div>
                <div class="main">
                  <div class="info"> <strong><?php echo (!empty($comment['username'])) ? $comment['username'] : '匿名'; ?></strong><?php echo date('Y-m-d H:i', $comment['post_time']); ?>说：
                    <?php if(!empty($auth) && ($auth['uid'] == $info['uid'])) { ?>
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
        <form action="/book/article/replay" id="add_tags" method="post">
        <input type="hidden" name="replay_cid" id="replay_cid" value="" />
        <input type="hidden" name="aid" value="<?php echo $aid;?>" />

        <textarea class="text" name="content" cols="" rows=""></textarea>
        <input class="button" name="" type="submit" value="确定" />
        </form>
      </div>

            <div class="mod_fat_comments">
                <div class="comment">发表评论</div>
                <form action="/book/article/comment" id="add_comment" method="post">
                <input type="hidden" name="aid" value="<?php echo $aid;?>" />
                <div class="content">
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

        <div class="mod_user_info_1">
            <div class="hd"></div>
            <div class="bd">
                <span class="avatar">
                    <a class="pic" href="/books/<?=urlencode($info['username'])?>">
                        <img src="<?=(!empty($info['avatar'])) ? $info['avatar']: '/images/album/no_avatar.png';?>" border="0" alt="<?=$info['username']?>" width="92" height="92" />
                    </a>
                </span>
                <span class="info">
                    <strong class="name"><?=$info['username']?></strong>
                    <p><?=(!empty($info['sign'])) ? $info['sign'] : '这家伙好懒，什么也没留下';?></p>
                </span>
            </div>
            <div class="ft"></div>
        </div>

        <div class="button">
            <a class="book_home" href="/book">图书馆首页</a>
            <a class="book_manage" href="/book/article/list">图书管理</a>
        </div>

        <div class="mod_folding_2 recommended_tags">
            <div class="hd">
                <div class="recommended_title">
                    <h2>推荐阅读</h2>
                    <sup>RECOMMEND</sup>
                </div>
            </div>
            <div class="bd">
                <ul class="recommended_lists">
                    <?php foreach ($channel_top as $item) { ?>
                    <li><a href="/articles/<?=$item->article_id;?>.html" title="<?=$item->title;?>"><?=Str::slice($item->title, 14, '...');?></a></li>
                    <?php } ?>

                </ul>
                <div class="fold">
                    <div class="tags_title">
                        <h2>热门标签</h2>
                        <sup>HOTTAGS</sup>
                    </div>
                </div>
                <ul class="tags_lists">
                    <?php foreach ($tags as $item) {?>
                    <li><a href="/book/search?tags=<?=$item?>"><?=Str::slice($item, 10)?></a></li>
                    <?php } ?>
                </ul>
                <div class="clearfloat"></div>
            </div>
            <div class="ft"></div>
            <a class="ad1" href="#">
                <img src="/images/album/banner/banner3.png" width="250" height="70" border="0" alt="" title="" />
            </a>
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

function show_from(aid, content)
{
    $('#replay_from #replay_cid').val(aid);
    $('#reply_'+ aid).html($('#replay_from').html());
}
function report(obj)
{

    $('#report_content').css('left', $(obj).offset().left-300);
    $('#report_content').css('top', $(obj).offset().top);
    $('#report_content').show();

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
        $.get("/common/report/article", { "content": content, "item_id": <?=$info['article_id']?> },function(data){                alert(data);
            $('textarea[name=report_content]').val('');
            $('#report_content').hide();
        });
    });
});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>