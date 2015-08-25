<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#art_list li{margin:12px 2px 2px 10px;}
#art_list li a{font-size:14px; font-weight:bold;}
#art_list li p{color:#000;}
.books_controller{background:url(/images/user/controller.gif) no-repeat; width:670px;height:30px;margin:0 0 10px 0;padding:5px 0 10px 80px;border-bottom:2px solid #4FAF03;}
</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="main">
        <div class="mod_editor articles">
            <div class="title">
                <h2><span class="icon"></span>文章编辑</h2>
                <span class="back"> <a href="#">图书馆首页</a> <a href="#">我的图书馆</a> </span> </div>
            <div class="main">
                <?php include(dirname(__FILE__).'/bookmenu.php'); ?>
                <form action="" id="article_form" method="post">
                <input  name="aid" type="hidden" value="<?=$info->article_id?>" />
                <div class="hd"></div>
                <div class="bd">
                    <label class="articles_name"> <span class="name"> 文章名称 <sup>NAME</sup> </span>
                    <input class="input_text" name="title" type="text" value="<?=$info->title?>" />
                    <br />
                    <span class="text"> （名称不要超过20个中文字符） </span> </label>
                    <label class="articles_class"> <span class="name"> 文章类别 <sup>CATEGORY</sup> </span>

                     <select name="cate_id">
                        <option value="0">选择目录类别</option>
                        <? foreach ($categories as $item) { ?>
                        <option value="<?=$item['cate_id']?>" <?=(@$info->cate_id == $item['cate_id'])?'selected':''?>>
                        <? if ($item['parent_id'] > 0) {
                            echo preg_replace(array('/0;\d+;/', '/\d+/', '/;/'), array('', '', '&nbsp; &nbsp; '), $item['path']);
                            echo '|--';
                        } ?> <?=$item['cate_name']?></option><? } ?>
                        </select>
                    </label>
                    <label class="add_tags"> <span class="name"> 添加标签 <sup>ADD TAGS</sup> </span>
                    <input class="input_text" name="tags" type="text" value="<?=$tags?>"/>
                    <br />
                    <span class="text"> （多个标签以空格分开，英文单词请用双引号括起来） </span> </label>
                    <div class="editor">  <?php echo Editor::create('XH', array('name' => 'content', 'value' => $info->content, 'width' => '650', 'height' => '600'));?> </div>
                    <br /><input type="submit" value=" 提 交 "  class="botton"/>
                </div>
                </form>
                <div class="ft"></div>
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {

    $('#article_form').submit(function() {
        var title = $('input[name=content]');
        if (title.val() == '') {
            alert('请输入图书文章名称');
            title.focus();
            return false;
        }

        var cate = $('select[name=cate_id]');
        if (cate.val() == 0) {
            alert('请选择分类目录');
            cate.focus();
            return false;
        }

        var content = $('textarea[name=content]');

        if (content.val() == '') {
            alert('请输入图书文章内容');
            title.focus();
            return false;
        }
    });
});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>