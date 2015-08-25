<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<fieldset>
  <legend><?php echo (empty($info)) ? '添 加' : '编辑';?>信息</legend>
    <form action="" method="post" id="submit">
        <table width="100%" align="left">
            <tr>
              <th width="100" align="left">所属目录:</th>
          <td>
            <select name="cid" id="cid">
            <option value="1" <?php if (@$info['cid']=='1') {?> selected="selected" <?php } ?>  >帮助</option>
             <option value="2" <?php if (@$info['cid']=='2') {?> selected="selected" <?php } ?>>关于</option>
            </select>1帮助，2关于
            </td></tr>
            <tr>
              <th align="left">文档标题</th><td><input type="text" name="cname" size="80" value="<?php echo @$info['cname']; ?>" class="txt" /></td>
            <tr><th align="left">文档名</th>

                <td><input type="text" class="txt" name="title" size="80"  value="<?php echo @$info['title']; ?>" /></td>
            </tr>
            <tr><th align="left">内容</th>
                <td> <?php echo Editor::create('XH', array('name' => 'content', 'value' => @$info['content'], 'width' => '650'));?> </td>
            </tr>
        </table>
        <input type="hidden" value="<?=$info['id']?>" name="id" />
        <div class="submit">
            <input type="submit" class="blue_btn" value="保存" name="save_submit" />
            <input type="reset" class="gray_btn" value="重置" />
        </div>
    </form>
</fieldset>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
function edit(){
     $("#list").attr('action', '/admin/disk/edit').attr('method', 'post').submit();
}

$(document).ready(function() {
    $('form:first').submit(function(){
        var cname = $('input[name=cname]');
        if(cname.val() == '') {
            alert('文档标题不能为空');
            cname.focus();
            return false;
        }
        var title = $('input[name=title]');
        if(title.val() == '') {
            alert('文档名不能为空');
            title.focus();
            return false;
        }
        var content = $('textarea[name=content]');
        if(content.val() == '') {
            alert('内容不能为空');
            content.focus();
            return false;
        }

    });

});
</script>