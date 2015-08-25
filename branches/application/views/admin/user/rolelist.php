<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<style type="text/css">
label {display:inline;}
</style>


<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th>ID</th>
    <th align="left">用户名</th>
    <th align="left">角色</th>
    <th >操作</th>
 </tr>
 <? foreach ($list as $item) {?>
  <tr>
    <td><?=$item['uid']?></td>
    <td align="left"><a href="/admin/user/view?uid=<?=$item['uid']?>"><?=$item['username'];?></a></td>
    <td align="left"><?=$item['role_desc']?></td>
    <td  width="10%" align="center">
    <a href="/admin/user/view?uid=<?=$item['uid']?>" title="查看用户"><img src="/images/icon/view.gif" /></a>
    <?php if (Auth::getInstance()->isAllow('privilege.assign')) { ?><a href="/admin/user/role?uid=<?=$item['uid']?>" title="指派权限"><img src="/images/icon/group.gif"  alt="编辑用户"/></a><?php } ?>
  </tr>
  <? } ?>
</table>
<br/>

<br />

</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

});
</script>