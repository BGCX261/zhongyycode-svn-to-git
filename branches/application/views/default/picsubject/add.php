<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
 .submit{background:url("/images/user/user_banjia_tijiao.gif") repeat scroll 0 0 transparent;height:27px;width:64px; border:none;}
</style>
<div id="body">
<?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
<form action=""  method="post" id="picsubject">
  <div id="main">
    <div class="mod_editor topics">
      <div class="title">
        <h2><span class="icon"></span>新建专题</h2>
        <span class="back"> <a href="/picsubject/list">管理专题</a> <a href="/pic">返回相册</a> </span> </div>
      <div class="main">
        <div class="hd"></div>
        <div class="bd">
          <label class="articles_name"> <span class="name"> 专题名称 <sup>TOPIC NAME</sup> </span>
          <input class="input_text" name="title" type="text" />
          <br />
          <span class="text"> （名称不要超过30个中文字符） </span> </label>
          <label class="add_tags"> <span class="name"> 添加标签 <sup>ADD TAGS</sup> </span>
          <input class="input_text" name="tags" type="text" />
          <br />
          <span class="text"> （多个标签以空格分开，如;人物 时间 地点） </span> </label>
          <div class="editor"> <?php echo Editor::create('XH', array('name' => 'content', 'value' => $content, 'width' => '650', 'height' => '700'));?> </div>
          <br />
          <input type="submit" value=" " class="submit" />
          <input type="button" value="复制源代码" class="botton"  onclick="copy();"/>
        </div>

        <div class="ft"></div>
      </div>
    </div>
  </div>
</div>
</form>
<script language="javascript" type="text/javascript">
function copy(){
    var str = $('textarea[name=content]').val();
    if (str != '') {
        copyToClipboard(str);
    }
}

$(document).ready(function() {
    $('#picsubject').submit(function(){
        var title = $('input[name=title]');
        if (title.val() == '') {
            alert('专题名称不能为空');
            title.focus();
            return false;
        }
        var content = $('textarea[name=content]');
        if (content.val() == '') {
            alert('专题内容不能为空');
            content.focus();
            return false;
        }
    });
});
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>