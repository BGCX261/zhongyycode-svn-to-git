<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.form.min.js"></script>
<form method="post" action="/admin/disk/<?php echo (empty($info)) ? 'add' : 'edit';?>" id="list">
<fieldset>
  <legend><?php echo (empty($info)) ? '添 加' : '编辑';?>磁盘</legend>
  主机名: <input type="text" name="disk_domain" size="20" value="<?php echo @$info['disk_domain']?>" />
  目录名: <input type="text" name="disk_name" size="10" value="<?php echo @$info['disk_name']?>" />
  容量: <input type="text" name="disk_capa" size="10" value="<?php echo @$info['disk_capa']?>" />
  服务器IP: <input type="text" name="server_ip" size="20" value="<?php echo @$info['server_ip']?>" />
  备注: <input type="text" name="memo" size="30" value="<?php echo @$info['memo']?>" />
       <input type="hidden" name="id" size="30" value="<?php echo @$info['id']?>" />
       <input type="submit" name ="" value="<?php echo (empty($info)) ? '添 加' : '编辑';?>" />
       <?php echo (!empty($info)) ? '<a href="/admin/disk/list">添 加</a>' : '';?>
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th>ID</th>
    <th align="left">主机名</th>
    <th align="left">目录名</th>
    <th align="left">容量</th>
    <th align="left">服务器IP</th>
    <th align="left">添加时间</th>
    <th>备注</th>
    <th >操作</th>
 </tr>
 <? foreach ($results as $item) {

 ?>
  <tr>

    <td><?=$item['id']?></td>
    <td align="left"><?=$item['disk_domain']?></td>
    <td align="left"><?=$item['disk_name']?></td>
    <td><?php echo $item['disk_capa']?></td>

    <td><?php echo $item['server_ip']?></td>
    <td><?php echo date('Y-m-d H:i:s', $item['add_date'])?></td>
    <td><font color="red"><?php echo $item['memo']?></font></td>

    <td  width="10%" align="center">
    <?php if ($item['is_use']) { ?>
        <font color="red">当前活跃磁盘</font>
    <?php } else { ?>
     <?php if(Auth::getInstance()->isAllow('disk.delete')){?><a href="/admin/disk/del?id=<?=$item['id']?>" class="delete" title="删除"><img src="/images/icon/delete.gif" /></a><?php }?>
     <?php if(Auth::getInstance()->isAllow('disk.set')){?>
        <a href="/admin/disk/list?id=<?=$item['id']?>" title="编辑"><img src="/images/icon/edit.gif"  alt="编辑用户"/></a>
        <a href="/admin/disk/active?id=<?=$item['id']?>" title="激活磁盘"><img src="/images/icon/cog.gif"  alt="激活当前磁盘"/></a><?php }?>
    <?php } ?>
    </td>
  </tr>
  <? } ?>
</table>


<br />

</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function edit(){
     $("#list").attr('action', '/admin/disk/edit').attr('method', 'post').submit();
}

$(document).ready(function() {

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>