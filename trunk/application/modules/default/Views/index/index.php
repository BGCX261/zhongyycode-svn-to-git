<?=$this->render('header.php'); // 显示模版?>

		<div id="main">
			<div id="content">
				<div id="main-logo">预览模式:<a href="#">普通</a> | <a href="#">列表</a></div>
				<?php if (count($this->paginator)){ ?>
				<?php foreach($this->paginator as $article) { ?>
				<div id="title">
					<div class="blog-title"><a href="<?=$this->url(array('module' => 'default'),'default', true);?>article/<?=$article['art_id'];?>.html"><?=$article['title']?></a></div>
					<div class="remark">作者:軒轅雲 日期:<?=date('Y-m-d H:i:s', $article['save_time'])?></div>

					<div class="blog-content">
						<?=($article['brief'])  ;?>
					</div>
					<div class="blog-view"><a href="<?=$this->url(array('module' => 'default'  ), 'default', true);?>article/<?=$article['art_id']?>.html"><img src="/public/images/blog/view.jpg" /></a></div>
					<div class="review">分类:<a href="<?=$this->url(array('module'=>'default'), 'default', true);?>category/<?=$article['cate_id']?>.html"><?=$article['cate_name']?> </a>| <a href="#">评论(<?=$article['comments']?>)</a> | <a href="#">查看次数(<?=$article['clicks']?>)</a></div>
				</div>
                <?php } ?>
                <?php } ?>

            <?php echo $this->paginationControl($this->paginator,
                             'Jumping',
                             array('page.php', 'default')); ?>

			</div> <!--end id="content" -->

			<div id="category">
			     <!--日历-->
                <?=$this->render('layout/calendar.php');?>
                <?=$this->render('layout/link.php');?>
			</div><!--end class="category"-->


		<div class="clearfloat"></div>
		</div> <!--end id="main" -->


<?=$this->render('footer.php');?>