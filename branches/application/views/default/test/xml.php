<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($pageTitle)) { echo $pageTitle . '_';}?>外链吧</title>
<meta name="keywords" content="<?=(!empty($keywords))? $keywords  : '淘宝相册|免费相册|外链免费相册|淘宝图片空间|淘宝免费相册|淘宝外链相册|免费可外链相册|图片外链网站';?>" />
<meta name="description" content="<?=(!empty($description))? $description  : '专业淘宝相册,外贸相册,提供稳定的淘宝图片存储空间，支持相册批量上传、批量贴图。中国唯一的彻底免费的淘宝免费相册。';?>">
<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="/scripts/pic_view/AC_RunActiveContent.js" language="javascript"></script>
<script src="/scripts/pic_view/SWFObject.js" language="javascript"></script>
</head>
<body bgcolor="#ffffff" style=margin:0px>
<script language="javascript">
    if (AC_FL_RunContent == 0) {
        alert("This page requires AC_RunActiveContent.js.");
    } else {
        function AC_FL_RunContent(){
          var ret =
            AC_GetArgs
            (  arguments, ".swf?a=<?=$xml_id?>", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
             , "application/x-shockwave-flash"
            );
          AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
        }
        AC_FL_RunContent(
            'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
            'width', '100%',
            'height', '100%',
            'src', 'zoomGallery',
            'quality', 'high',
            'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
            'align', 'middle',
            'play', 'true',
            'loop', 'true',
            'scale', 'noscale',
            'wmode', 'window',
            'devicefont', 'false',
            'id', 'zoomGallery',
            'bgcolor', '#ffffff',
            'name', 'zoomGallery',
            'menu', 'true',
            'allowFullScreen', 'ture',
            'allowScriptAccess','sameDomain',
            'movie', '/scripts/pic_view/zoomGallery',
            'salign', ''
            ); //end AC code
    }
</script>
<script type="text/javascript">
var fo = new FlashObject("/scripts/pic_view/zoomGallery.swf", "mymovie", "200", "100", "7", "#336699");
fo.write("flashcontent");
</script>
<noscript>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="100%" height="100%" id="zoomGallery" align="middle">
    <param name="allowScriptAccess" value="sameDomain" />
    <param name="allowFullScreen" value="false" />
    <param name="movie" value="zoomGallery.swf" /><param name="quality" value="high" /><param name="scale" value="noscale" /><param name="bgcolor" value="#ffffff" />   <embed src="zoomGallery.swf" quality="high" scale="noscale" bgcolor="#ffffff" width="100%" height="100%" name="zoomGallery" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
    </object>
</noscript>
</body>
</html>
