<?php
/**
 * 分页页面
 *
 * @package    html
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 */
?>
<style type="text/css">
.pagination {clear:both; color:#333; font-weight:normal;}
.pagination a {background:#FFF; color:#06e; border:1px solid #DDDDDD; padding:2px 7px; text-decoration:none;}
.pagination a:hover {background:#F30; color:#FFF; text-decoration:none;}
.pagination .pageCurrentItem {color:#F30; font-weight:bold; padding:2px 7px;}

</style>
<div class="pagination">
<div class="pageList">
<?php
echo  $this->paginator;
if ($this->pageCount){
// first page
$html = '';
if (isset($this->previous)) {
    $html .= "<a href=". $this->url(array('page' => $this->previous)) . " class=\"pageFirst\">前一页</a> ";
}else{
    $html .= '<span class="disabled"> 前一页</span>' ;
}


if ($this->current < 6 || $this->pageCount < 10) {
    for ($i = 1; $i < 10; $i++) {
        $html .= ($this->current == $i) ?
             "<span class=\"pageCurrentItem\" title=\"当前第 $i 页\">$i</span>\n"
             :"<a href=\"" . $this->url(array('page' => $i)) ."\" class=\"pageItem\" title=\"前往第 $i 页\">$i</a>\n";
        if ($i >= $this->pageCount) break;
    }
}else if($this->current > 5 && $this->current < $this->pageCount - 4) {

    for ($i = $this->current - 4; $i < $this->current + 5; $i++) {
        $html .= ($this->current == $i) ?
                     "<span class=\"pageCurrentItem\" title=\"当前第 $i 页\">$i</span>\n"
                     :"<a href=\"" . $this->url(array('page' => $i)) ."\" class=\"pageItem\" title=\"前往第 $i 页\">$i</a>\n";
        if ($i >= $this->pageCount) break;
    }
} elseif ($this->current + 5 > $this->pagesCount) {

    for ($i = $this->pageCount - 8; $i < $this->pageCount + 1; $i++) {
        $i > 1 && $html .= ($this->current == $i) ?
                     "<span class=\"pageCurrentItem\" title=\"当前第 $i 页\">$i</span>\n"
                     :"<a href=\"" . $this->url(array('page' => $i)) ."\" class=\"pageItem\" title=\"前往第 $i 页\">$i</a>\n";
    }
}

// next page
if (isset($this->next)){
    $html .= "<a href=" . $this->url(array('page' => $this->next)). " class=\"pageLast\">后一页  </a>";
} else{
    $html .= '<span class="disabled">后一页</span>';
}
}
echo $html ;

?>
</div>
</div>