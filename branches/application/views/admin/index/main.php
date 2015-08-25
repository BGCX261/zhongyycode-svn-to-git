<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#98CAEF" class="tablegrid" style="margin-top:10px;" align="center">
<tr style="background:#4FB4DE"><th align="center" colspan="6">我的状态 </th></tr>
<tr>
    <td align="center">登录者：<font color="red"> <?php echo $auth['username']?></font>&nbsp;&nbsp;所属用户组: <font color="red"> <?php echo ORM::factory('acl_role',$auth['roles']['admin']['role_id'])->role_desc ?> </font>&nbsp;&nbsp;(上次登录时间：<?=date('Y-m-d H:i:s', $auth['last_time'])?>, 登录IP：<?=$auth['last_ip']?>)</td>
</td>


</table>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>