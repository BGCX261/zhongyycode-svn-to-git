<?=$this->render('header.php') ?>

<form id="searchForm">
<fieldset>
<legend>文件搜索</legend>
所属分类：
<select name="cate_id">
<? foreach ($this->categories as $cate) { ?>
<option value="<?=$cate['cate_id']?>" title="<?=$cate['description']?>" <?=$this->html()->selected($this->cateId, $cate['cate_id'])?>><?=$cate['cate_name']?></option>
<? } ?>
</select>
关键字：<input type="text" name="keyword" size="50" value="<?=$this->keyword?>"/>
<input type="submit" value="搜索" />
</fieldset>
</form>

<div class="dataedit">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablegrid">
  <tr>
    <th>分类</th>
    <th align="left">文件名</th>
    <th align="right">大小</th>
    <th align="center">上传者</th>
    <th align="center">上传时间</th>
    <th>描述</th>
    <th>操作</th>
  </tr>
  <? if (count($this->paginator) < 0) { ?>
  <tr>
    <td align="left" colspan="6" height="50"><span class="warning">未找到上传的文件记录</span></td>
  </tr>
  <? } else {?>
  <? foreach ($this->paginator as $file) { ?>
  <tr>
    <td><?=$file['cate_name']?></td>
    <td align="left"><a href="/<?=$file['savename']?>" title="点击查看这个文件" target="_blank"><?=$file['filename']?></a></td>
    <td align="right"><?=ceil($file['filesize'] / 1024)?> Kb</td>
    <td align="center"><?=light_keyword($file['username'], $this->keyword)?></td>
    <td align="center"><?=date('Y-m-d H:i:s', $file['upload_time'])?></td>
    <td align="left"><?=light_keyword($file['description'], $this->keyword)?>&nbsp;</td>
    <td>
    <a href="<?=$this->url(array('controller' => 'files', 'action' => 'download', 'id' => $file['file_id']), '', true)?>" title="下载这个文件到本地磁盘"><img src="/images/icon/disk.gif" /></a>
    <a href="#" title="获取链接地址" onclick="prompt('请使用 Ctrl+C 复制链接地址!', 'http://www.yunphp.cn/<?=$file['savename']?>');"><img src="/images/icon/page_link.gif" /></a>
    <a href="<?=$this->url(array('action' => 'delete', 'id' => $file['file_id']))?>" class="delete" title="删除这个文件"><img src="/images/icon/trash.gif" /></a>
    </td>
  </tr>
  <? } ?>
  <? } ?>
</table>
<?php    echo $this->paginationControl($this->paginator,'Elastic','page.php'); ?>
</div>


<?=$this->render('footer.php') ?>

<script type="text/javascript">
$(document).ready(function() {
    $('select').change(function(){$("#searchForm").submit();});
});
</script>