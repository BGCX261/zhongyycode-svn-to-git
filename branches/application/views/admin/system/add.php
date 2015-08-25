<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<fieldset>
  <legend><?php echo (empty($info)) ? '添 加' : '编辑';?>信息</legend>
    <form action="adddeal" method="post">
        <table width="100%">
            <tr>
              <th width="200" align="right">所属目录:1帮助，2关于</th>
          <td>
            <select name="cid" id="cid">
            <option value="1" <?php if ($info['cid']=='1') {?> selected="selected" <?php } ?>  >帮助</option>
             <option value="2" <?php if ($info['cid']=='2') {?> selected="selected" <?php } ?>>关于</option>
            </select>
            </td></tr>
            <tr>
              <th align="right">文档标题</th><td><input type="text" name="cname" value="<?php echo $info['cname']; ?>" class="txt" /></td>
            <tr><th align="right">文档名</th>

                <td><input type="text" class="txt" name="title" value="<?php echo $info['title']; ?>" /></td>
            </tr>
            <tr><th align="right">内容</th>
                <td> <?php echo Editor::create('XH', array('name' => 'content', 'value' =>$info['content'], 'width' => '650'));?> </td>
            </tr>
        </table>

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

    $('input[name=chkAll]').click(function() {
        $(':checkbox[name="id[]"]').attr('checked', $(this).attr('checked'));
    })
});
</script>