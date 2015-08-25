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
        file_upload_limit : "10",
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
        upload_complete_handler : function(){ },

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
    var url = '/test?cate_id=' + cate_id + '&uid=' + uid;
    upload1.setUploadURL(url);
    upload1.startUpload();
}
</script>
</head>
<body>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content">
    <div><img src="/images/user/user_shangchuan.gif"</div>
    <fieldset><legend>图片上传</legend>
    <form id="form1" action="upload.php" method="post" enctype="multipart/form-data">
    <table>
        <tr valign="top">
            <td>
                <div>
                    <?php if(!empty($cate_list)) { ?>
                     上传至：<select name="cate_id">
                        <option value="0">根目录</option>
                        <?php foreach ($cate_list as $cate) { ?>
                        <option value="<?=$cate['cate_id']?>"><?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', '&nbsp; &nbsp; &nbsp;'), $cate['path']) . $cate['cate_name']?></option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <span id="spanButtonPlaceholder1"></span>
                    <div class="fieldset flash" id="fsUploadProgress1">

                    </div>
                     <div id="divStatus">0 Files Uploaded</div>
                    <div style="padding-left: 5px;">

                         <a href="javascript:set()"> <img src="/images/user/user_shangchuan_btn.gif" /> </a> &nbsp; <a href="javascript:cancelQueue(upload1);" id="btnCancel1"> <img src="/images/user/user_shangchuan_shangchu.gif" /></a>
                        <br />

                    </div>
                </div>
            </td>

        </tr>
    </table>
    </form>
</fieldset>

    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>