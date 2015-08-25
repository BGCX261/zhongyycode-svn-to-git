<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<fieldset>
  <legend>详细信息</legend>
    <form action="adddeal" method="post">
        <table width="100%" class="help_table">
           <tr>
              <th align="right">用户名：</th><td><?php echo $auth['username']; ?></td>
              </tr>
            <tr>
              <th width="200" align="right">所属目录:1帮助，2关于：</th>
          <td>
          <?php 
		  $arr_cid=array("1"=>"帮助","2"=>"关于");
		  echo  $arr_cid[$info['cid']];
		  ?>
            </td></tr>
            <tr>
              <th align="right">文档标题：</th><td><?php echo $info['cname']; ?></td>
              </tr>
            <tr><th align="right">文档名：</th>
                <td><?php echo $info['title']; ?></td>
            </tr>
            <tr><th align="right">内容：</th>
                <td> <?php echo $info['content'];?> </td>
            </tr>
        </table>

        <div class="submit">
            <a href="/admin/help/index"><img src="/images/user/icon_15.gif" /></a>
        </div>
    </form>
</fieldset>
