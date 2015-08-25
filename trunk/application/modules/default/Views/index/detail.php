<?=$this->render('header.php');?>
		<div id="main">
			<div id="content">
				<div id="main-logo">预览模式:<a href="#">普通</a> | <a href="#">列表</a></div>

				<div id="title">
					<div class="blog-title"><?=$this->article['title']?></div>
					<div class="remark">作者:軒轅雲 日期:<?=date('Y-m-d H:i:s', $this->article['save_time'])?></div>

					<div class="blog-content">
						<?=$this->article['content']?>
					</div>

					<div class="review">分类:<a href="<?=$this->url(array('module' => 'default', ), 'default', true);?>category/<?=$this->article['cate_id']?>.html"><?=$this->article['cate_name']?> </a>| <a href="#">评论(<?=$this->article['comments']?>)</a> | <a href="#">查看次数(<?=$this->article['clicks']?>)</a></div>

<style type="text/css">
#comments {padding:10px 5px; text-align:left;}
#comments .caption{border-bottom:#666 1px dashed; color:gray; font-size:14px; margin:15px 0; font-weight:bold; height:16px; line-height:16px;}
#comments .list{}
#comments .list .u{background:#DED4BB none repeat scroll 0 0; color:#666; font-weight:bold; padding:3px 6px; height:14px; line-height:14px;}
#comments .list .c{margin:5px 0 20px 0; padding:0 6px;}



.c{margin:5px 0 20px 0; padding:0 6px;}
</style>
					<div id="comments">
					    <div class="caption"><span style="float:left">用户评论</span><span style="float:right;"><a href="javascript:" onClick="parent.postComment();">我要评论</a></span></div>
					     <div class="list">
                            <? if($this->comment) { ?>
                    				<? foreach($this->comment as $item) { ?>
                            <p class="u" >评论人：<?=$item['comment_name'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 评论时间：<?=date('Y-m-d H:i:s', $item['add_time']) ?></p>

                            <p class="c"><?=$item['content'] ?></p>
                    			   <?  } ?>
            			   <?  } else { ?>
                            <p style="text-align:center;"><font color="green"><a href="javascript:" onClick="parent.postComment();">暂时未有用户评论。</a></font></p>
                         <?  } ?>
                        </div>
					</div>
				</div>

			</div> <!--end id="content" -->
			<div id="category">

				<?=$this->render('layout/calendar.php');?>

				<?=$this->render('layout/link.php');?>
			</div><!--end class="category"-->


		<div class="clearfloat"></div>

		</div> <!--end id="main" -->


<div id="post" style="display:none;">
    <div style="width:330px;">
    <form name="postComment" method="POST"  action="<?=$this->url(array('module' => 'default', 'controller' => 'index', 'action' => 'comment', 'art_id' =>  $this->article['art_id']), 'default' , true);?>" onSubmit="tb_remove();">
    <input type="hidden" name="art_id" value="<?=$this->article['art_id']?>" />
    <div style="margin:10px 0;">
		<table width="100%" align="center">
		<tr><td width="50"> 名称：</td><td><input type="text" name="comment_name" value=""  class="text"/></td></tr>
		<tr><td  width="50">信息：</td><td><textarea name="content" rows="6" cols="40"></textarea></td></tr></table>
	</div>
    <div><input name="sb" type="submit" value="发表评论"  class="button"/> <input type="button" class="button" value="取消" onClick="tb_remove();" /></div>
    </form>
</div>
</div>
<?=$this->render('footer.php');?>
<script type="text/javascript">
function postComment() {
    var url = '#TB_inline?height=220&width=570&inlineId=post' ;
    tb_show('', url, false);
}

</script>