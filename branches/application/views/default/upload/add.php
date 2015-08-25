<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<link href="/flash/swf/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/flash/swf/swfupload.js"></script>
<script type="text/javascript" src="/flash/swf/swfupload.queue.js"></script>
<script type="text/javascript" src="/flash/swf/fileprogress.js"></script>
<script type="text/javascript" src="/flash/swf/handlers.js"></script>
<script type="text/javascript">
var upload1, upload2;

window.onload = function() {
    upload1 = new SWFUpload({
        // Backend Settings
        upload_url: "/test/",
        post_params: {"uid" : "<?=$auth['uid']?>", 'cate_id' : $('input[name=cate_id]')},

        // File Upload Settings
        file_size_limit : "5120", // 100MB
        file_types : "*.jpg;*.gif;*.jpeg;*.png;*.bmp;",
        file_types_description : "*.jpg;*.gif;*.jpeg;*.png;*.bmp;",
        file_upload_limit : "0",
        file_queue_limit : "0",

        // Event Handler Settings (all my handlers are in the Handler.js file)
        file_dialog_start_handler : fileDialogStart,
        file_queued_handler : fileQueued,
        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : function(){},
        upload_start_handler : uploadStart,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : function(){ $('.show_img').show();},

        // Button Settings
        button_image_url : "/flash/swf/browseBtn.png",
        button_placeholder_id : "spanButtonPlaceholder1",
        button_width: 80,
        button_height: 28,

        // Flash Settings
        flash_url : "/flash/swf/swfupload.swf",
        custom_settings : {
            progressTarget : "fsUploadProgress1",
            cancelButtonId : "btnCancel1"
        },

        // Debug Settings
        debug: false
    });


}

function set(){
    var cate_id = $('select[name=cate_id]').val();
    var uid = <?=$auth['uid']?>;
    var url = '/upload/add?cate_id=' + cate_id + '&uid=' + uid;
    upload1.setUploadURL(url);
    upload1.startUpload();
}
</script>

<style type="text/css">
.swfupload{margin:-30px 0 0 300px;position:absolute }
</style>

<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content" style="background: url(/images/user/user_shangchuan.gif) no-repeat scroll 200px 0px transparent;padding-top:50px;">
<fieldset>
<legend>公示</legend>
<p>其它上传方式:<a href="/upload/basic">普通上传</a></p>

</fieldset>
<br />
    <fieldset><legend>图片上传</legend>
    <form id="form1" action="upload.php" method="post" enctype="multipart/form-data">

    <table>
        <tr valign="top">
            <td>
                     <p>上传至：<select name="cate_id" style="width:200px;">
                        <option value="0">根目录</option>
                        <?php foreach ($cate_list as $cate) { ?>
                        <option value="<?=$cate['cate_id']?>"><?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', '&nbsp; &nbsp; &nbsp;'), $cate['path']) . $cate['cate_name']?></option>
                        <?php } ?>
                    </select>
                    </p>
                    <!--p>
                    压缩选项：<select name="select_width">
                        <option value="0">请选择</option>
                        <option value="500">500*Auto</option>
                        <option value="550">550*Auto</option>
                        <option value="600">600*Auto</option>
                        <option value="620">620*Auto</option>
                        <option value="650">650*Auto</option>
                        <option value="700">700*Auto</option>
                        <option value="750">750*Auto</option>
                    </select>缩小宽度，可节省空间，加快打开速度
                   </p-->
                    <span id="spanButtonPlaceholder1"></span>
                    <div class="fieldset flash" id="fsUploadProgress1">

                    </div>
                    <div class="clearfloat"></div>
                    <div style="padding-left: 5px;">
                        <p>&nbsp;&nbsp;&nbsp;支持上传格式： *.jpg;*.jpeg;*.gif;*.png;*.bmp 单个文件不能超过：5.0MB</p>
                        <div class="show_img" style="display:none;margin:10px 0 10px 20px;"><a href="/category/list">查看相片</a>&nbsp;<a href="/user/upload"> 继续上传</a><br /></div>
                        <div class="clearfloat"></div>
                         <a href="javascript:set()"> <img src="/images/user/user_shangchuan_btn.gif" /> </a> &nbsp; <a href="javascript:cancelQueue(upload1);" id="btnCancel1"> <img src="/images/user/user_shangchuan_shangchu.gif" /></a>
                        <br />

                    </div>

            </td>

        </tr>
    </table>
    </form>
</fieldset>


</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>