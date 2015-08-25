<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />
<style type="text/css">
label {display:inline;}
</style>
<form method="get" id="list">
<fieldset>
  <legend>用户搜索</legend>
  等级:<select name="rank">
        <option value="-1">全部</option>
        <?php foreach ($group as $item) { ?>
            <option value="<?=$item['id']?>" <?=Str::selected($rank, $item['id'])?>> <?=$item['group_name'];?></option>
        <?php }?>
        </select>
  状态：
      <select name="status" >
            <option value="-1"> 全部</option>
            <option value="approved" <?=Str::selected('approved', $status);?>> 通过</option>
            <option value="overtime" <?=Str::selected('overtime', $status);?>> 过期</option>
            <option value="disapproval" <?=Str::selected('disapproval', $status);?>> 冻结</option>
            <option value="forbid" <?=Str::selected('forbid', $status);?>> 禁止</option>
        </select>
  用户名: <input type="text" name="username" size="10" value="<?=$username?>" />
  邮箱: <input type="text" name="email" size="20" value="<?=$email?>" />
  目录: <input type="text" name="save_dir" size="30" value="<?=$save_dir?>" />
  积分：
      <select name="sign" >
            <option value="-1"> 全部</option>
            <option value=">=" <?=Str::selected('>=', $sign);?>> 大于等于</option>
            <option value=">" <?=Str::selected('>', $sign);?>> 大于</option>
            <option value="<=" <?=Str::selected('<=', $sign);?>> 小于等于</option>
            <option value="<" <?=Str::selected('<', $sign);?>> 小于</option>
            <option value="=" <?=Str::selected('=', $sign);?>> 等于</option>
        </select>&nbsp;<input type="text" name="points" size="5" value="<?=$points?>" />

</fieldset>
<fieldset>

  时间
    <select name="time_type">
    <option value="reg_time" <?=Str::selected('reg_time', $time_type);?>>注册时间</option>
    <option value="expire_time" <?=Str::selected('expire_time', $time_type);?>>过期时间</option>
    </select><input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;
<input type="checkbox" name="index_top" value="1" onclick="this.form.submit();" <? if ($index_top) { echo 'checked="checked"'; } ?> /> 明星用户
  &nbsp;<input type="submit" value=" 搜 索 " />
</fieldset>

<table class="tablegrid" width="100%" style="text-align:center;">
 <tr>
    <th align="left" width="50"><input type="checkbox" name="chkAll" /> 全选</th>
    <th>ID</th>
    <th align="left">用户名</th>
    <th align="left">邮箱</th>
    <th align="left">用户组</th>
    <th align="left">注册时间<br />到期时间</th>
    <th>积分</th>
    <th>登陆次数<br />用户类型</th>
    <th>图片数量<br />状态</th>
    <th>总空间<br />已使用</th>
    <th>账户状态</th>
    <th>存储目录</th>
    <th >操作</th>
 </tr>
 <? foreach ($pagination as $item) {
    switch($item['status']) {
        case 'approved':
            $status = '<font color="blue">通过</font>';break;
        case 'overtime':
            $status = '<font color="red">过期</font>';break;
        case 'disapproval':
            $status = '<font color="green">冻结</font>';break;
        case 'forbid':
            $status = '<font color="red">禁止</font>';break;
        default:
            $status = '<font color="red">禁止</font>';break;

    }
 ?>
  <tr>
    <td align="left"><input type="checkbox" name="uid[]" value="<?=$item['uid']?>" /></td>
    <td><?=$item['uid']?></td>
    <td align="left"><a href="/admin/pics/list?uid=<?=$item['uid']?>"  <?=($item['index_top'] == 1) ? 'style="color:red;" title="查看明星用户"' : 'title="查看用户"';?>><?=Str::highlight($item['username'], $username);?></a></td>
    <td align="left"><?=$item['email']?></td>
    <td align="left"><a href="/admin/user/list?rank=<?=$item['rank']?>" title="查看该用户组下的用户"><?=$item['group_name']?></a></td>
    <td align="left"><?php echo date('Y-m-d H:i:s',$item['reg_time'])?><br /><?php echo date('Y-m-d H:i:s',$item['expire_time'])?></td>
    <td><?php echo $item['points']?></td>
    <td><?php echo $item['login_count']?><br /> <?php echo ($item['type'] == 0) ? '内贸用户' : '外贸用户';?></td>
    <td><?php echo $item['count_img']?></td>
    <td><font color="blue"><?php echo $item['max_space']?></font>M <br /><font color="red"><?php echo round( $item['use_space']/ 1024 / 1024)?></font>M</td>
    <td><?php echo $status?></td>
    <td><?=$item['save_dir']?></td>
    <td  width="10%" align="center">
    <a href="/admin/user/view?uid=<?=$item['uid']?>" title="查看用户"><img src="/images/icon/view.gif" /></a>
    <?php if (Auth::getInstance()->isAllow('privilege.assign')) { ?><a href="/admin/user/role?uid=<?=$item['uid']?>" title="指派权限"><img src="/images/icon/group.gif"  alt="编辑用户"/></a><?php } ?>
    <a href="/admin/user/edit?uid=<?=$item['uid']?>" title="编辑用户"><img src="/images/icon/edit.gif"  alt="编辑用户"/></a>
    <a href="/admin/user/upgrade?uid=<?=$item['uid']?>" title="升级用户"><img src="/images/icon/coins.gif"  alt="升级用户"/></a>
  </tr>
  <? } ?>
</table>
<br/>
<?php echo $pagination->render('pagination/digg');?>
<br />
<input type="button" value="设置明星用户"  onclick="indexTop('add');"/>
<input type="button" value="删除明星用户"  onclick="indexTop('del');"/>
</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
// 设置明星用户
function indexTop(app){
     $("#list").attr('action', '/admin/user/indextop?app='+app).attr('method', 'post').submit();
     $("#list").attr('action', '').attr('method', 'get');
}
$(document).ready(function() {
    $('select[name!=time_type]').change(function(){$("form:first").submit();});
    $('.date').datepicker({yearRange:'-5:5'});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="uid[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>