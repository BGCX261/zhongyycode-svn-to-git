<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>


<form method="post" id="list">
<input type="hidden" name="cid" value="<?=$row['cid']?>" />
<table cellspacing="5">
    <tbody><tr><td><b>应用名称：</b></td><td>
    <select name="app">
        <option value="img_subject" <?php if ($row['app']=='img_subject') ?> selected="selected"  > 专题评论 </option>
        <option value="img" <?php if ($row['app']=='img') ?> selected="selected" > 图片评论 </option>
        <option value="article" <?php if ($row['app']=='article') ?> selected="selected" > 图书评论 </option>
    </select>
    </td></tr>
    <tr><td><b>作者：</b></td><td ><?=$row['username']?></td></tr>
    <tr><td><b>是否显示：</b></td><td>
    <select name="is_show">
        <option value="0" <?php if ($row['is_show']=='0') ?> selected="selected" >不显示</option>
        <option value="1" <?php if ($row['is_show']=='1') ?> selected="selected" >显示</option>
    </select>
    </td></tr>
    <tr><td><b>是否置顶：</b></td><td>
    <select name="is_top">
        <option value="0" <?php if ($row['is_top']=='0') ?> selected="selected" >否</option>
        <option value="1" <?php if ($row['is_top']=='1') ?> selected="selected" >是</option>
    </select>
    </td></tr>
     <tr><td><b>引用内容:</b></td><td><textarea cols="100" rows="10" name="quote"><?=$row['quote']?></textarea></td></tr>
    <tr><td><b>评论内容:</b></td><td><textarea cols="100" rows="10" name="content"><?=$row['content']?></textarea></td></tr>


    <tr><td colspan="2"><input type="submit" value="提交" class="button"> <input type="reset" value="重置" class="button"> <input type="button" onclick="javascript:history.back()" value="返回" class="button"></td></tr>
</tbody></table>
</form>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">

$(document).ready(function() {

});
</script>