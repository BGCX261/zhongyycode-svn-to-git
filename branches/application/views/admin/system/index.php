<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>


<form method="post" id="list">
<input type="hidden" name="id" value="<?=$rows['id']?>" />
<table cellspacing="1" bgcolor="#98caef" width="100%">
    <tbody>
      <tr>
        <td colspan="3" align="center" style="background: none repeat scroll 0% 0% rgb(236, 248, 255); font-size:14px; font-weight:bold;">系统配置</td>
      </tr>
      <tr><td width="14%"><b>ID：</b></td><td colspan="2"><?=$rows['id']?> </td></tr>
    <tr>
      <td><b><span style="color:#FF0000">*</span>文件类型：<br />
      </b></td><td width="550"><input type="text" size="100" value="<?=$rows['allowed_ext']?>" name="allowed_ext" class="text" gtbfieldid="46"></td>
          <td width="380"><b><span class="red">(输入后缀，逗号隔开)</span></b></td>
    </tr>
        <tr>
          <td><b><span style="color:#FF0000">*</span>网站邮箱：</b></td>
          <td colspan="2">
    <input type="text" size="50" value="<?=$rows['admin_email']?>" name="admin_email" class="text" gtbfieldid="46">    </td></tr>
    <tr><td><b><span style="color:#FF0000">*</span>单文件大小上限：</b></td><td colspan="2">
    <input type="text" size="50" value="<?php $arr_max=explode(':',$rows['max_upload']); ?> <?=$arr_max['0']?>" name="max_upload" class="text" gtbfieldid="46">
    </td></tr>
     <tr><td><b><span style="color:#FF0000">*</span>（单位）</b></td><td colspan="2">
     <?php $unit=$arr_max['1'];?>
                    <select name="unit">
                        <option value="">请选择</option>
                        <option value="GB" <?php if($unit=="GB"){echo 'selected="1"';}?>>GB</option>
                        <option value="MB" <?php if($unit=="MB"){echo 'selected="1"';}?>>MB</option>
                        <option value="KB" <?php if($unit=="KB"){echo 'selected="1"';}?>>KB</option>
                    </select>
    </td></tr>
     <tr><td><b>临时维护公告:</b></td><td colspan="2"><textarea cols="100" rows="5" name="tmp_message_top"><?=$rows['tmp_message_top']?></textarea></td></tr>
    <tr><td><b>是否显示临时维护公告</b></td><td colspan="2">

                    <select name="show_top">
                        <option value="">请选择</option>
                        <option value="0" <?php if($rows['show_top'] ==0 ){echo 'selected="1"';}?>>不显示</option>
                        <option value="1" <?php if($rows['show_top']==1){echo 'selected="1"';}?>>显示</option>

                    </select>
    </td></tr>
    <tr><td><b>滚动公告信息:</b></td><td colspan="2"><textarea cols="100" rows="5" name="marquee_message"><?=$rows['marquee_message']?></textarea></td></tr>


    <tr><td>&nbsp;</td>
      <td><input type="submit" value="提交" class="button" /></td>
      <td>&nbsp;</td>
    </tr>
</tbody></table>
</form>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">

$(document).ready(function() {

});
</script>