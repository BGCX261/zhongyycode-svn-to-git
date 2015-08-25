<?php include(dirname(__FILE__).'/header.php'); ?>
<style type="text/css">
#feedback {width:400px;height:171px;padding-top:100px; margin:0 auto; text-align:left; background:url(/images/user/cao_<?php echo ($msg_type==1) ? '1' : '2';?>.gif);;}
#feedback .head {border-bottom:1px dashed #CAD9EA; height:30px; line-height:30px; padding:0 0 0 10px; color:#000; font-size:14px; font-weight:bold;}
#feedback .body {padding:25px 15px; text-align:center;}
#feedback .body .message {color:#F00;margin-top:40px;}
#feedback .body .control {margin-top:20px; text-align:left;}
#debuginfo {border-top:4px solid #DEEFFA; padding-top:10px; text-align:left;}
#debuginfo em, #debuginfo i {color:red;}
#debuginfo pre {margin:5px 0; padding:5px; border:1px dashed #E0E0E0; font:12px 'Courier New'; font-style:italic; color:#00AA00;}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbody">
  <tr>
    <td valign="middle">
      <div id="feedback">

        <div class="body">
          <div class="message"><?php echo $msg_detail; ?></div>
          <div class="control">
            <?php
              $line = 1;
              foreach($links as $id => $link) {
                  echo "{$line}、<a href=\"{$link['href']}\">{$link['text']}</a>,&nbsp;";
                  $line++;
              }

              ?>
            <?php if($auto_redirect) { ?>
                <p><a href="<?php echo $default_url; ?>" class="orgLnk"  style="color:#FF7800;">默认返回到<?php echo $default_text; ?>，如果您的浏览器没有跳转，请点这里</a></p>
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
        }, $time);
    });
//-->
</script>
EOQ;
}?>
<?php include(dirname(__FILE__).'/footer.php'); ?>