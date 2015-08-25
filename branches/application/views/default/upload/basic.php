<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<style type="text/css">

</style>
<body>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content" style="background: url(/images/user/user_shangchuan.gif) no-repeat scroll 200px 0px transparent;padding-top:50px;">

<br />
    <fieldset><legend>普通方式图片</legend>
    <form id="form1" action="" method="post" enctype="multipart/form-data">
    <table>
        <tr valign="top">
            <td>
                  <div><input type="button" value="增加" id="add_config"  class="button" /> <input type="button" value="删除" id="plus_config"  class="button" /></div>

                 <p>上传至：<select name="cate_id" style="width:200px;">
                    <option value="0">根目录</option>
                    <?php foreach ($cate_list as $cate) { ?>
                    <option value="<?=$cate['cate_id']?>"><?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', '&nbsp; &nbsp; &nbsp;'), $cate['path']) . $cate['cate_name']?></option>
                    <?php } ?>
                </select></p>

                <p>图片列表:<br /> </p>
                <div class="sconfig">
                    <input class="input_class" type="file" name="pictures[]" /><br />
                 </div>
                 <p><input class="input_class" type="file" name="pictures[]" /><br />
                    <input class="input_class" type="file" name="pictures[]" /><br />
                    <input class="input_class" type="file" name="pictures[]" /><br />
                    <input class="input_class" type="file" name="pictures[]" /><br />
                 <p>

               <p>
                    <input type="hidden" name="uid" value="<?=$auth['uid']?>" />
                    <input type="image" src="/images/user/user_shangchuan_btn.gif"/>
                <p>
                <div style="padding-left: 5px;">
                    <p>&nbsp;&nbsp;&nbsp;支持上传格式： *.jpg;*.jpeg;*.gif;*.png;*.bmp 单个文件不能超过：5.0MB</p>
                    <div class="show_img" style="display:none;margin:10px 0 10px 20px;"><a href="/category/list">查看相片</a>&nbsp;<a href="/user/upload"> 继续上传</a></div>

                </div>
            </td>
        </tr>
    </table>
    </form>
</fieldset>

    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    // 添加配置项
    $("#add_config").click(function(){
        $(".sconfig:last").after($(".sconfig:last").clone(true));
    });
    //减少配置项
    $("#plus_config").click(function(){
        if($(".sconfig").length<=1)
        {
            alert('配置项至少有五个!')
            return;
        }
        $(".sconfig:last").remove();
    });

});
</script>