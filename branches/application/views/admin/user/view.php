<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery.form.min.js"></script>
<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#98caef" style="margin-top: 10px;">
    <tbody>
        <tr style="background: none repeat scroll 0% 0% rgb(236, 248, 255);"><th align="center" colspan="6">用户基础信息 [<a href="/admin/user/edit?uid=<?=$userInfo['uid']?>">编辑</a>] [<a title="涮新用户空间状况" href="/admin/user/upcache?uid=<?=$userInfo['uid']?>">涮新</a>]</th></tr>
    <tr><td width="100"><b>用户ID</b></td><td>135111</td><td width="100"><b>用户名</b></td><td><?=$userInfo['username']?> (<a onclick="getRank(135111);" title="重新计算用户等级" href="#" id="rank"><?=$userInfo['group']['group_name']?></a>)</td><td width="100"><b>积分</b></td><td><?=$userInfo['points']?></td></tr>
    <tr><td><b>访问量</b></td><td><?=$userInfo['visit']?></td><td><b>空间大小</b></td><td><?=$userInfo['group']['max_space']?>M</td><td><b>已使用</b></td><td><?=round($userInfo['use_space'] / 1024 /1024)?>M</td></tr>
    <tr><td><b>图片数</b></td><td><?=$userInfo['count_img']?></td><td><b>差价</b></td><td><?=$userInfo['fee_day'];?></td><td><b>生日</b></td><td><?=date('Y-m-d H:i:s', $userInfo['field']['birthday'])?></td></tr>
    <tr><td><b>用户类型</b></td><td><span class="u0"><?php echo ($userInfo['type'] == 0) ? '内贸用户' : '外贸用户';?></span></td><td><b>QQ</b></td><td></td><td><b>邮件</b></td><td><?=$userInfo['email']?></td></tr>
    <tr><td><b>手机</b></td><td><?=$userInfo['field']['mobile']?></td><td><b>电话</b></td><td><?=$userInfo['field']['phone']?></td><td><b>MSN</b></td><td><?=$userInfo['field']['msn']?></td></tr>
    <tr><td><b>登录次数</b></td><td><?=$userInfo['login_count']?></td><td><b>上次登录IP</b></td><td><?=$userInfo['last_ip']?></td><td><b>上次登录时间</b></td><td><?=date('Y-m-d H:i:s', $userInfo['last_time'])?></td></tr>
    <tr><td><b>注册IP</b></td><td><?=$userInfo['reg_ip']?> </td><td><b>注册时间</b></td><td><?=date('Y-m-d H:i:s', $userInfo['reg_time'])?></td><td><b>来源域名</b></td><td></td></tr>
    <tr><td><b>用户备注</b></td><td colspan="5"><?=$userInfo['memo']?></td></tr>
    </tbody>
</table>
<table width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#98caef" style="margin-top: 10px;">
    <tbody>
        <tr><td>磁盘名称</td><td>目录</td></tr>
        <?php $disks = ORM::factory('img_disk')->find_all();
            foreach ($disks as $disk) {
              $dir = '/server/wal8/www/'. $disk->disk_name . '/' . ORM::factory('user', $userInfo['uid'])->save_dir;


                echo '<tr><td>'.$dir .'</td><td>' .  path($dir) . '</td></tr>';


            }
        ?>
    </tbody>
</table>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>

<?php

function path($dir)
{
    if (empty($dir)) return ;
    $perms = fileperms($dir);
    if (($perms & 0xC000) == 0xC000) {
                        // Socket
        $info = 's';
    } elseif (($perms & 0xA000) == 0xA000) {
        // Symbolic Link
        $info = 'l';
    } elseif (($perms & 0x8000) == 0x8000) {
        // Regular
        $info = '-';
    } elseif (($perms & 0x6000) == 0x6000) {
        // Block special
        $info = 'b';
    } elseif (($perms & 0x4000) == 0x4000) {
        // Directory
        $info = 'd';
    } elseif (($perms & 0x2000) == 0x2000) {
        // Character special
        $info = 'c';
    } elseif (($perms & 0x1000) == 0x1000) {
        // FIFO pipe
        $info = 'p';
    } else {
        // Unknown
        $info = 'u';
    }

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
                (($perms & 0x0800) ? 's' : 'x' ) :
                (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
                (($perms & 0x0400) ? 's' : 'x' ) :
                (($perms & 0x0400) ? 'S' : '-'));

    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));
    return $info;
}