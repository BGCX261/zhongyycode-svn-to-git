<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="zend framework框架， EGP框架， php5 交流与学习, 轩辕云" />
<meta name="description" content="个人博客，zend framework框架， php 交流与学习，分享" />
<meta name="copyright" content="2008-2009 yunphp.cn" />
<meta name="verify-v1" content="6L2p6L6V5LqR=" />
<script src="/scripts/jquery/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="/scripts/jquery/thickbox.js" type="text/javascript"></script>
<link href="/styles/global.css" rel="stylesheet" type="text/css" media="all" />
<link href="/styles/thickbox.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
$(document).ready(function(){
    $("a.login").click(function(){
        tb_show(this.title, this.href + '?TB_iframe=true&height=250&width=500', false);
        this.blur();
        return false;
    });
});
</script>

<style type="text/css">
#TB_title {display:none;} /* 隐藏 thickbox 标题*/


body{ background:url(/images/blog/bg_02.jpg) repeat; font-size:12px; height:auto; margin:0px;}
#all{ background:url(/images/blog/bg_01.jpg) repeat-x; font-size:12px; height:auto;}
.clearfloat {height:0px; overflow:hidden; clear:both;}

img{ border:none;}
#wrapper{ width:1002px; margin:0px auto; padding:0px;}
#header{ width:800px; margin:0px auto; background:#393939; }
#logo{background:url(/images/blog/jian.jpg) no-repeat; width:110px; height:161px; margin:0px; padding:0px; float:left;}
#logo-txt{ line-height:26px; font-size:20px;color:#c6c9d0;}
#menu{background:url(/images/blog/menu-left.jpg) no-repeat; width:800px; height:45px; float:left; overflow:hidden;}
#menu-txt{background:url(/images/blog/menu-bg.jpg) repeat-x;float:left width:764px; height:45px; margin-left:36px; overflow:hidden;}

/*main*/
#main{ background:#dddddd; width:790px; margin:0px auto; padding:0px 5px; }
#content{ width:530px; float:left; background:#FFF; margin:10px 0px 5px 3px; height:auto;overflow:hidden; padding:0px 0px 0px 10px;}
#main-logo{ text-align:right; color:#000; padding-top:5px; padding-right:10px;}
#title{  background:url(/images/blog/title-img.jpg) no-repeat;}
.blog-title{ width:490px; margin-left:15px; padding:0px 0px 0px 5px; font-weight:bold; border-bottom:1px #CCCCCC dashed;}
.remark{ width:490px; margin-left:15px; padding:5px 0px 0px 5px; font-weight:bold; color:#666}
.blog-content{ margin:5px;padding:5px 0px 0px 5px; }
.blog-view{  margin-left:0px; margin-right:15px; padding:0px 5px 10px 5px; font-weight:bold; border-bottom:1px #CCCCCC dashed;}
.review{ text-align:right;padding:10px 15px 10px 5px; }
#category{width:230px; float:left; margin:10px 0px 5px 10px; }
.cate-title{background:#000; color:#FFF; height:22px; font-weight:bold; line-height:22px; padding-left:10px;overflow:hidden;}
.cate-content{ background:#FFF; text-align:center; padding:0px 0px 10px 0px; margin:0px ;overflow:hidden;  }
.cate-content ul{ margin:0px; padding:0px; list-style:none;}
.cate-content li{ text-align:left; background:url(/images/blog/link-bg.jpg) no-repeat; padding:3px 0px 0px 18px; margin-left:5px;}

/*buttom*/
#buttom{ width:800px; margin:0px auto; padding:0px; text-align:center;color:#FFF; }
#buttom a{color:#FFF; }
/*calendar*/
.cate-content table{border-width:0px 1px 1px 0px;border-collapse:collapse;border-style:solid;border-color:#ccc; margin-left:2px;float:left; }
.cate-content th, .cate-content td{border-width:1px 0px 0px 1px;border-style:solid;border-color: #ccc;text-align:center;padding:0px 7px 0px 7px;}
.cate-content .week6{font-weight:bold;color:#000;}
 .cate-content .week0, .cate-content.week7{font-weight:bold;color:#000;}
.pre,.next{color:#ccc;}
.today{color:#FF0000;font-weight:bold;}


#tabsH {float:left; width:100%;font-size:93%;line-height:normal;}
#tabsH ul {margin:0;padding:10px 10px 0 0px;list-style:none;}
#tabsH li {display:inline; margin:0; padding:0;}
#tabsH a {float:left;background:url("/images/blog/tableftH.gif") no-repeat left top;margin:0;padding:0 0 0 4px;text-decoration:none;}
#tabsH a span {float:left;display:block;background:url("/images/blog/tabrightH.gif") no-repeat right top;padding:5px 15px 4px 6px;color:#FFF;}
/* Commented Backslash Hack hides rule from IE5-Mac \*/
#tabsH a span {float:none;}
/* End IE5-Mac hack */
#tabsH a:hover span {color:#FFF;}
#tabsH a:hover {background-position:0% -42px;}
#tabsH a:hover span { background-position:100% -42px;}

#tabsH #current a {background-position:0% -42px;}
#tabsH #current a span {background-position:100% -42px;}

</style>
<title><?=$this->pageTitle?></title>
</head>
<body>
	<div id="wrapper">
		 <div id="header">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="4%" valign="bottom"><img src="/images/blog/jian.jpg" /></td>
						<td width="64%" ><a href="http://www.yunphp.cn" style="color:#FFF; font-size:16px; font-weight:bold;">人生若只初见</a><br /><span style="color:#85611c; font-family:'方正舒体'; padding-top:20px; font-size:14px;">天可以不懂雨的落魄 煙可以不懂手的寂寞 酒可以不懂喉的寄托  淚不可以不懂眼的脆弱 你不可以不懂我對你的<a class="login" href="<?=$this->url(array('module'=>'default','controller' => 'user', 'action' => 'login'), 'default', true);?>">＾○＾</a></span></td>
						<td width="4%"><img src="/images/blog/dream.jpg" /></td>
					</tr>
			</table>
			<div id="menu">
			<div id="menu-txt">
				<div id="tabsH">
					<ul>
						<li id="current" ><a  href="http://www.yunphp.cn/" ><span>首页</span></a></li>
					   <?php foreach ($this->cateList as $list) { ?>
						<li ><a  href="<?=$this->url(array('module'=>'default', 'action' => 'cate', 'cate_id' => $list['cate_id']), 'default', true);?>"><span><?=$list['cate_name']?></span></a></li>
						<?php } ?>

					</ul>
				</div>
            </div>
			</div>
		<div class="clearfloat"></div>

		</div> <!--end id="header" -->
