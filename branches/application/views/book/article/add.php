<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#art_list li{margin:12px 2px 2px 10px;}
#art_list li a{font-size:14px; font-weight:bold;}
#art_list li p{color:#000;}
.mod_editor .main{margin:0px auto; }
#save_show{display:none;width:600px;height:750px;background:#ccc;position:absolute;}
.close{float:right;color:#4FAF03;font-weight:bold;cursor:hand;}
.percent_num{color:#4FAF03;margin:100px auto 10px; text-align:center;}
.percent_bar{width:490px;border:1px solid #4FAF03;height:20px;margin:0 auto;padding:0; position:relative;}
.percent_bar #bar{background:none repeat scroll 0 0 #F8DA62;color:#333333;display:block;height:20px;line-height:20px;position:relative;text-align:center;width:0;margin:0;padding:0;}
.percent_stat{ text-align:center;color:#4FAF03;font-size:16px;margin-top:10px;}

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
                <div class="clearfloat"></div>
                <form action="" id="article_form" method="post">
                <div class="hd"></div>
                <div class="bd">
                    <label class="articles_name"> <span class="name"> 文章名称 <sup>NAME</sup> </span>
                    <input class="input_text" name="title" type="text" />
                    <br />
                    <span class="text"> （名称不要超过20个中文字符） </span> </label>
                    <label class="articles_class"> <span class="name"> 文章类别 <sup>CATEGORY</sup> </span>

                     <select name="cate_id">
                        <option value="-1">选择目录类别</option>
                        <? foreach ($categories as $item) { ?>
                        <option value="<?=$item['cate_id']?>" <?=(@$cateInfo['parent_id'] == $item['cate_id'])?'selected':''?>>
                        <? if ($item['parent_id'] > 0) {
                            echo preg_replace(array('/0;\d+;/', '/\d+/', '/;/'), array('', '', '&nbsp; &nbsp; '), $item['path']);
                            echo '|--';
                        } ?> <?=$item['cate_name']?></option><? } ?>
                        </select>
                    </label>
                    <label class="add_tags"> <span class="name"> 添加标签 <sup>ADD TAGS</sup> </span>
                    <input class="input_text" name="tags" type="text" />
                    <br />
                    <span class="text"> （多个标签以空格分开，英文单词请用双引号括起来） </span> </label>
                        <div id="save_show">
                        <div class="close">关闭</div>
                        <div class="percent_num"></div>
                        <div class="percent_bar"><span id="bar">&nbsp;</span></div>
                         <div class="percent_stat"><span></span></div>
                    </div>
                    <div class="editor">  <?php echo Editor::create('XH', array('name' => 'content', 'value' => @$content, 'width' => '650', 'height' => '600'));?> </div>
                    <br /><input type="button"  id="submit_art"value=" 提 交 " class="botton"/>
                </div>

                <div class="ft"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('.close').click(function(){$('#save_show').hide();});

    $('#submit_art').click(function(){
        var title = $('input[name=title]');
        if (title.val() == '') {
            alert('请输入图书文章名称');
            title.focus();
            return false;
        }

        var cate = $('select[name=cate_id]');
        if (cate.val() < 0) {
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
        imageSave();
    });

});
function imageSave()
{

    var content = $("textarea[name=content]").val();
    $.post("/book/article/getimg", { "content": content }, function(data){
       var imgs = [];
       imgs = data.split(",");

       if (imgs.length > 0) {
            $('#save_show').show();
            $('.percent_num').html('转存图片数量：0/' + imgs.length);
            $('.percent_bar span').css('width', '0%');
            $('.percent_stat span').html(0);
            var p = 0;
            $.each(imgs, function(i, src){
                $.get('/book/article/saveimg',{ "src": src },  function(data){
                    p++;
                    var per = Math.ceil(p / imgs.length * 100);
                    $('.percent_num').html('转存图片数量：'+ p + '/' + imgs.length);
                    var n = per / 100  * 490;
                    $('.percent_bar span').css('width', parseInt(n) + 'px');
                    $('.percent_stat span').css('width', parseInt(n) + 'px').html(per);

                     content = content.replace(new RegExp(src,"gm"), data);
                    if (per == 100) {
                        $("textarea[name=content]").val(content);
                        alert('图片文件转存成功！');
                        $('#save_show').hide();
                        $('#article_form').submit();
                    }
                });
            });
        } else {
            $('#article_form').submit();
        }
    });


}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>