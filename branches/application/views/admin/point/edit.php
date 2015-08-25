<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>

<form method="post" id="list">
<input type="hidden" name="id" value="<?=$rows['id']?>" />
<table cellspacing="5">
    <tbody>
    <tr><td><b>用户名：</b></td><td><?=$rows['uname']?>  </td></tr>
    <tr><td><b>提交时间：</b></td><td><?php echo date('Y-m-d  H:i:s',strtotime ($rows['submit_date']))?> </td></tr>
    <tr><td><b>标题：</b></td><td><input type="text" size="50" value="<?=$rows['title']?>" name="title" class="text" gtbfieldid="46"></td></tr>
    <tr><td><b>URL：</b></td><td>
    <input type="text" size="50" value="<?=$rows['url']?>" name="url" class="text" gtbfieldid="46">
    </td></tr>
    <tr><td><b>积分：</b></td><td>
    <input type="text" size="50" value="<?=$rows['points']?>" name="points" class="text" gtbfieldid="46">
    </td></tr>
    <?php if ($rows['status']) {?>
    <tr><td><b>审核时间：</b></td><td><?php echo date('Y-m-d  H:i:s',strtotime ($rows['audite_date']))?> </td></tr>
    <?php } ?>
     <tr><td><b>审核状态：</b></td><td>
    <select name="status" >
        <option value="0" <?=Str::selected('0', $rows['status']);?>> 未审</option>
        <option value="1" <?=Str::selected('1', $rows['status']);?>> 已审</option>
        <option value="2" <?=Str::selected('2', $rows['status']);?>> 每月系统扣分</option>
    </select>
    </td></tr>
     <tr><td><b>任务描述:</b></td><td><textarea cols="100" rows="5" name="description"><?=$rows['description']?></textarea></td></tr>
    <tr><td><b>审核评语:</b></td><td><textarea cols="100" rows="5" name="audite_memo"><?=$rows['audite_memo']?></textarea></td></tr>


    <tr><td colspan="2"><input type="submit" value="提交" class="button"> <input type="reset" value="重置" class="button"> <input type="button" onclick="javascript:history.back()" value="返回" class="button"></td></tr>
</tbody></table>
</form>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">

$(document).ready(function() {

});
</script>