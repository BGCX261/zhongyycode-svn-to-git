<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo ($msg_type==1) ? '成功' : '失败';?>信息反馈</title>
<style type="text/css">
html {height:100%;}
body {height:100%; margin:0; font:12px Tahoma, Verdana, Arial; line-height:160%;}
#tbody {height:100%; text-align:center;}
#logo {width:500px; margin:10px auto 0 auto;}
#feedback {width:500px; margin:0 auto; border:1px solid #CAD9EA; text-align:left;}
#feedback .head {border-bottom:1px dashed #CAD9EA; height:30px; line-height:30px; padding:0 0 0 10px; color:#000; font-size:14px; font-weight:bold;}
#feedback .body {padding:25px 15px; text-align:center;}
#feedback .body .message {color:#F00;}
#feedback .body .control {margin-top:20px; text-align:left;}

#debuginfo {border-top:4px solid #DEEFFA; padding-top:10px; text-align:left;}
#debuginfo em, #debuginfo i {color:red;}
#debuginfo pre {margin:5px 0; padding:5px; border:1px dashed #E0E0E0; font:12px 'Courier New'; font-style:italic; color:#00AA00;}
</style>
<script type="text/javascript" language="javascript" src="/scripts/jquery/jquery-1.3.2.min.js"></script>

</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbody">
  <tr>
    <td valign="middle">
      <div id="feedback">
        <div class="head"><?php echo ($msg_type==1) ? '成功' : '失败';?>信息反馈</div>
        <div class="body">
          <div class="message"><?php echo $msg_detail; ?></div>
          <div class="control">
            <?php
              $line = 1;
              foreach($links as $id => $link) {
                  echo "<p>{$line}、<a href=\"{$link['href']}\">{$link['text']}</a></p>";
                  $line++;
              }

              ?>
            <?php if($auto_redirect) { ?>
                <p><a href="<?php echo $default_url; ?>" class="orgLnk">默认返回到<?php echo $default_text; ?>，如果您的浏览器没有跳转，请点这里</a></p>
            <?php } ?>
          </div>
        </div>
      </div>
    </td>
  </tr>
</table>

<?php
if($auto_redirect) {
    echo <<<EOQ
<script type="text/javascript">
<!--
$(document).ready(function(){
        setTimeout(function(){
            window.location.href = "{$default_url}";
        }, 3000);
    });
//-->
</script>
EOQ;
}?>
</body>
</html>
