<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
.submit{margin-top:10px;}
</style>
<fieldset>
  <legend>详细信息</legend>
    <form action="adddeal" method="post">
        <table  width="100%" cellspacing="1" cellpadding="2" border="0" bgcolor="#98caef" style="margin-top: 10px;">
           <tr>
              <th align="left">用户名：</th><td><?php echo $auth['username']; ?></td>
              </tr>
            <tr>
              <th width="100" align="left">所属目录:</th>
              <td><?=($info['cid'] == 1)? '帮助' : '关于'?></td>
            </tr>
            <tr>
              <th align="left">文档标题：</th><td><?php echo $info['cname']; ?></td>
              </tr>
            <tr><th align="left">文档名：</th>
                <td><?php echo $info['title']; ?></td>
            </tr>
            <tr><th align="left">内容：</th>
                <td> <?php echo $info['content'];?> </td>
            </tr>
        </table>

        <div class="submit">
            <a href="/admin/help/index"><img src="/images/user/icon_15.gif" /></a>
        </div>
    </form>
</fieldset>
