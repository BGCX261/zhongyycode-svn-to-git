<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript" src="/scripts/jquery/ui/i18n/ui.datepicker-zh-CN.js"></script>
<link rel="stylesheet" href="/styles/datepicker.css" type="text/css" media="screen" />
<style type="text/css">
label {display:inline;}
</style>
<form method="get" action="" id="search">
<fieldset>
  <legend>查询</legend>
  用户名: <input type="text" name="username" size="20" value="<?=$username?>" />
  会员组 ：
    <select name="rank">
    <option value="-1" >全部</option>
    <?php foreach ($group as $item) { ?>
    <option value="<?=$item['id']?>" <?=Str::selected($rank, $item['id'])?>> <?=$item['group_name'];?></option>
    <?php }?>
    </select>
  排序:<select name="order_by">
        <option value="tot_flow" <?php if($order_by=='tot_flow') echo ' selected="1" ';?> >按流量</option>
        <option value="tot_times" <?php if($order_by=='tot_times') echo ' selected="1" ';?>>按次数</option>
    </select>

  日期：<input type="text" id="start_date" name="start_date" class="date" value="<?=$start_date?>" size="10"/> ~ <input type="text" id="end_date" name="end_date" class="date" value="<?=$end_date?>" size="10"/> &nbsp;

   <input type="submit" name ="" value=" 查 询 " />

</fieldset>
<table class="tablegrid" width="100%" style="text-align:left;">
 <tr>
    <th>序号</th>
    <th align="left">用户组<br />用户名</th>
    <th align="left">注册时间<br/>到期时间</th>
    <th align="left">登陆<br />类型</th>
    <th align="left">总空间<br/>已使用</th>
    <th align="left">图片<br/>状态</th>
    <th align="left">前一天流量<br/>前一天次数</th>
    <th align="left">近一月</th>
 </tr>
 <?php
    $sum = 0;
    foreach ($pagination as $item) {
        $sum  += 1;
        $type = ($item['type']==1) ? '内贸' : '<span class="green">外贸</span>';
        # 账户状态 和 图片状态
        $status_array = array(
            'approved' => '<span class="blue">通过</span>',
            'overtime' => '<span class="green">过期</span>',
            'disapproval' => '<span class="green">冻结</span>',
            'forbid' => '<span class="red">禁止</span>');
        $denyimg_array = array(
            'approved' => '<span class="blue">正常</span>',
            'overtime' => '<span class="blue">正常</span>',
            'disapproval' => '<span class="red">禁止</span>',
            'forbid' => '<span class="red">禁止</span>');
        if($item['status']=='approved') {
            $now = date("Y-m-d H:i:s");
            if(date("Y-m-d H:i:s", $item['expire_time']) < $now){
                if(date("Y-m-d",(strtotime("+7 days",strtotime($item['expire_time'])))) < $now){
                    $status = 'disapproval';
                } else {
                    $status = 'overtime';
                }
            } else{
                $status = $item['status'];
            }
        } else {
            $status = $item['status'];
        }

        $tot_flow = $item['tot_flow']/1048576;
            if($tot_flow > 1024){
                $tot_flow = $tot_flow / 1024;
                $tot_flow_show = round($tot_flow, 2) . "G";
            }else{
                $tot_flow_show = round($tot_flow, 2) . "M";
            }
?>
  <tr>

    <td align="left"><?=$sum?></td>
    <td align="left"><?=$item['group_name']?><br /><?=$item['username']?></td>
    <td align="left"><?=date('Y-m-d H:i', $item['reg_time'])?><br /><?=date('Y-m-d H:i', $item['expire_time'])?></td>
    <td align="left"><?=$item['login_count']?><br /><?=$type?></td>
    <td align="left"><?=$item['max_space']?><br /><?=$item['use_space']?></td>
    <td align="left"><?=$item['count_img']?><br /><?=$denyimg_array[$status];?></td>
    <td align="left"><?=$tot_flow_show?><br /><?=$item['tot_times']?></td>
    <td align="left">
        <a href="/admin/stat/list?uid=<?=$item['uid']?>&save_dir=<?=$item['save_dir']?>" >查看统计</a>
    </td>


  </tr>
  <? } ?>
</table>
<div style>

<?php echo $pagination->render('pagination/digg');?>
</div>
<br />

</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function delPic(){
     $("#search").attr('action', '/admin/pics/delPic').attr('method', 'post').submit();
}

$(document).ready(function() {
    $('select').change(function(){$("form:first").submit();});
    $('.date').datepicker({yearRange:'-5:5'});
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>