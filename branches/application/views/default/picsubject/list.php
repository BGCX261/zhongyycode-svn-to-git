<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
.hd h2{ width:100px; float:left;}
.title_list{float:right;width:300px; text-align:right;padding-right:20px;}
</style>
<div id="body">
<?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="main">
    <div class="mod_book_manage">
      <div class="hd">
        <h2><span class="icon"></span>专题管理</h2>
        <div class="title_list"><a href="/picsubject/add">添加专题</a> <a href="/">返回首页</a></div>  </div>
      <div class="bd">
        <fieldset>
            <legend>说明</legend>
            复制：表示复制当前专题的源代码
        </fieldset>
        <table class="book_lists" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th class="tr_hd"><span class="icon"></span>序号</th>
              <th>专题名称</th>
              <th>创建日期</th>
              <th>状态</th>
              <th class="tr_ft">操作</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($results as $k => $item ) { ?>
            <tr>
              <td class="td_hd"><span class="icon"></span><?php echo $k+1 ?></td>
              <td class="td_content"><a href="/picsubject/<?php echo $item['sid']?>.html"><?php echo $item['title']?></a></td>
              <td><?php echo date('Y-m-d H:i', $item['add_time'])?></td>
              <td>阅读：<?php echo $item['click']?>&nbsp;/&nbsp;评论：<?php echo $item['comment']?></td>
              <td class="td_ft">
                <div id="content_<?=$item['sid']?>" style="display:none;"><?=$item['content']?></div>
                <input class="delete" name="" type="button" value="删除"  class="td_ft" onclick="location.href='/picsubject/delSubject?sid=<?php echo $item['sid']?>'"/>
                <input class="edit" name="" type="button" value="编辑" onclick="location.href='/picsubject/edit?sid=<?php echo $item['sid']?>'"/>
                <input class="delete" name="" type="button" value="复制"  class="td_ft" onclick="copy('content_<?=$item['sid']?>')"/>
            </td>
            </tr>

            <?php } ?>
          </tbody>
        </table>
        <div class="page"><?php echo $pagination->render();?></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function copy(id) {
    var str = $('#' + id).html()
    if (str != '') {
        copyToClipboard(str);
    }
}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>