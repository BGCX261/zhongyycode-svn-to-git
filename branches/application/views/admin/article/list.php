<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
.page{float:right; text-align:right;}
</style>
<form method="get" id="list">
<fieldset>
  <legend>图书搜索</legend>
  图书名: <input type="text" name="keyword" size="20" value="<?=$keyword?>" />
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />
  <input type="checkbox" name="is_recommend" value="1" onclick="this.form.submit();" <? if ($is_recommend) { echo 'checked="checked"'; } ?> /> 美文推荐
  <input type="checkbox" name="is_hot" value="1" onclick="this.form.submit();" <? if ($is_hot) { echo 'checked="checked"'; } ?> /> 热门文章
  <input type="checkbox" name="is_new" value="1" onclick="this.form.submit();" <? if ($is_new) { echo 'checked="checked"'; } ?> /> 最新文章
  <input type="checkbox" name="index_top" value="1" onclick="this.form.submit();" <? if ($index_top) { echo 'checked="checked"'; } ?> /> 首页置顶
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>
<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th>ID</th>
    <th align="left">标题</th>
    <th align="left">用户</th>
    <th align="left">发布时间</th>
    <th align="left">修改用户</th>
    <th align="left">修改时间</th>
    <th align="left">访问数</th>
    <th align="left">评论数</th>
    <th align="left">最新文章</th>
    <th align="left">热门文章</th>
    <th align="left">美文推荐</th>
    <th align="left">首页置顶</th>
    <th align="left">显示</th>

    <th >操作</th>
 </tr>
 <? foreach ($pagination as $item) {

 ?>
  <tr>
    <td><?=$item['article_id']?></td>
    <td align="left"><a href="/articles/<?=$item['article_id']?>.html" title="查看图书" target="_blank"><?=$item['title']?></a></td>
    <td align="left"><a href="/admin/article/list?uid=<?=$item['uid']?>" title="查看该用户下的图书"><?=$item['username']?></td>
    <td><?=date('Y-m-d H:i', $item['post_date']);?></td>
    <td align="left"><a href="/admin/article/list?uid=<?=$item['uid']?>" title="查看该用户下的图书"><?=$item['edit_username']?></td>
    <td><?=(!empty($item['edit_date'])) ? date('Y-m-d H:i', $item['edit_date']) : '';?></td>
    <td><?=$item['views']?></td>
    <td><?=$item['comments']?></td>
    <td><img src="/images/<?=$item['is_new']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['article_id']?>, 'is_new');" /></td>
    <td><img src="/images/<?=$item['is_hot']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['article_id']?>, 'is_hot');" /></td>
    <td><img src="/images/<?=$item['is_recommend']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['article_id']?>, 'is_recommend');" /></td>
     <td><img src="/images/<?=$item['index_top']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['article_id']?>, 'index_top');" /></td>
    <td><img src="/images/<?=$item['is_show']?'yes':'no'?>.gif" style="cursor:pointer" onclick="setStat(this, <?=$item['article_id']?>, 'is_show');" /></td>

    <td  width="10%" align="center">
    <a href="/articles/<?=$item['article_id']?>.html" title="查看文章" target="_blank"><img src="/images/icon/view.gif" /></a>
    <a href="/admin/article/edit?id=<?=$item['article_id']?>" title="编辑文章"><img src="/images/icon/edit.gif"  alt="编辑文章"/></a>
  </tr>
  <? } ?>
</table>


<input type="button" value="批量删除"  onclick="delPic();"/>
    <?php echo $pagination->render('pagination/digg');?>
<br />
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function delPic(){
     $("#list").attr('action', '/admin/pics/delPic').attr('method', 'post').submit();
}


function setStat(obj, id, type) {
    var val = (obj.src.match(/yes.gif/i)) ? 0 : 1;
    if (val == 0) {
        obj.src = '/images/no.gif';
    } else {
        obj.src = '/images/yes.gif';
    }
    $.get('/admin/article/setStat', {'article_id': id, 'val': val, 'type': type});
}
$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>