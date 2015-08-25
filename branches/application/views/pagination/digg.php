<?php
/**
 * Digg pagination style
 *
 * @preview  ? Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next ?
 */
?>
<div class="page">

    <span>[<a href="<?php echo $page->url() ?>"><?php echo __('首页') ?></a>]</span>
    <?php if ($previous_page): ?>
    <span >[<a href="<?php echo $page->url($previous_page) ?>"><?php echo __('Previous') ?></a>]</span>
    <?php else: ?>
    <span class="pageUp">[<?php echo __('Previous') ?>]</span>
    <?php endif ?>


    <?php if ($total_pages < 13): /* ? Previous  1 2 3 4 5 6 7 8 9 10 11 12  Next ? */ ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <?php if ($i == $current_page): ?>
    <strong><?php echo $i ?></strong>
    <?php else: ?>
    <span class="pageNu"><a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a></span>
    <?php endif ?>
    <?php endfor ?>

    <?php elseif ($current_page < 9): /* ? Previous  1 2 3 4 5 6 7 8 9 10 … 25 26  Next ? */ ?>

    <?php for ($i = 1; $i <= 10; $i++): ?>
    <?php if ($i == $current_page): ?>
    <strong><?php echo $i ?></strong>
    <?php else: ?>
    <span class="pageNu"><a href="<?php echo $page->url($i) ?>" class="cur"><?php echo $i ?></a></span>
    <?php endif ?>
    <?php endfor ?>

    &hellip;
    <span><a href="<?php echo $page->url($total_pages - 1) ?>"><?php echo $total_pages - 1 ?></a></span>
    <span><a href="<?php echo $page->url($total_pages) ?>"><?php echo $total_pages ?></a></span>

    <?php elseif ($current_page > $total_pages - 8): /* ? Previous  1 2 … 17 18 19 20 21 22 23 24 25 26  Next ? */ ?>

    <span><a href="<?php echo $page->url(1) ?>">1</a></span>
   <span> <a href="<?php echo $page->url(2) ?>">2</a></span>
    &hellip;

    <?php for ($i = $total_pages - 9; $i <= $total_pages; $i++): ?>
    <?php if ($i == $current_page): ?>
    <strong><?php echo $i ?></strong>
    <?php else: ?>
    <span  class="pageNu"><a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a></span>
    <?php endif ?>
    <?php endfor ?>

    <?php else: /* ? Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next ? */ ?>

    <a href="<?php echo $page->url(1) ?>">1</a>
    <a href="<?php echo $page->url(2) ?>">2</a>
    &hellip;

    <?php for ($i = $current_page - 5; $i <= $current_page + 5; $i++): ?>
    <?php if ($i == $current_page): ?>
    <strong><?php echo $i ?></strong>
    <?php else: ?>
    <span><a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a></span>
    <?php endif ?>
    <?php endfor ?>
    &hellip;
    <span><a href="<?php echo $page->url($total_pages - 1) ?>"><?php echo $total_pages - 1 ?></a></span>
    <span><a href="<?php echo $page->url($total_pages) ?>"><?php echo $total_pages ?></a></span>

    <?php endif ?>
    <?php if ($next_page): ?>
    <span>[<a href="<?php echo $page->url($next_page) ?>"><?php echo __('Next') ?></a>]</span>
    <?php else: ?>
    [<?php echo __('Next') ?>]
    <?php endif ?>
    <span>[<a href="<?php echo $page->url($total_pages) ?>"><?php echo __('末页') ?></a>]</span>
    <span>共<?=$total_items?>条记录</span><span>每页显示<?=$items_per_page?>条记录</span>
</div>

