<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta  name="save"  content="history">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="<?=$this->refresh?>;url=<?=$this->redirect?>">
<title><?=$this->title?></title>
<style type="text/css">
html {height:100%;}
body {height:100%; margin:0; font:12px Tahoma, Verdana, Arial; line-height:160%;}
#tbody {height:100%; text-align:center;}
#feedback {width:500px; margin:0 auto; border:1px solid #CAD9EA; text-align:left;}
#feedback .head {border-bottom:1px dashed #CAD9EA; height:30px; line-height:30px; padding:0 0 0 10px; color:#000; font-size:14px; font-weight:bold;}
#feedback .body {padding:25px 15px; text-align:center;}
#feedback .body .message {}
#feedback .body .control {margin-top:20px;}

#debuginfo {border-top:4px solid #DEEFFA; padding-top:10px; text-align:left;}
#debuginfo em, #debuginfo i {color:red;}
#debuginfo pre {margin:5px 0; padding:5px; border:1px dashed #E0E0E0; font:12px 'Courier New'; font-style:italic; color:#00AA00;}
</style>
<script type="text/javascript" language="javascript" src="/public/scripts/jquery/jquery-1.2.6.min.js"></script>
<script type="text/javascript" language="javascript">
$().ready(function() {
    $(document).keydown(function(event){
        if(event.keyCode == 13) { //当按下回车键时页面快速跳转
            location = '<?=$this->redirect?>';
        }
    });
});
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tbody">
  <tr>
    <td valign="middle">
      <div id="feedback">
        <div class="head"><?=$this->title?></div>
        <div class="body">
          <div class="message"><?=$this->message?></div>
          <div class="control"><a href="<?=$this->redirect?>" title=""><?=$this->linktext?></a></div>
        </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
