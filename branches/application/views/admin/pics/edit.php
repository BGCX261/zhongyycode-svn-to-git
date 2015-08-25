<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {

});

</script>
<style type="text/css">
label {display:inline;}
.percent {width:310px; margin:10px auto 0 auto; +margin-top:18px;}
.percent .percent_bar {background:#E8E8E8; border-right:1px solid #CCC; float:left; height:18px; width:250px;}
.percent .percent_num {float:right; font-size:14px; width:55px; margin-top:0; text-align:right; overflow:hidden;}
.percent .percent_bar span {background:#0a0; display:block; border:1px solid #060; height:16px; overflow:hidden;}
.percent .percent_stat {clear:both; padding-top:8px; text-align:center; font-size:14px;}
.percent .percent_stat span {color:red; font-weight:bold; margin:0 5px 0 5px;}
</style>

<form name="articlePost" action="/admin/template/edit" method="post">
    <input type="hidden" name="id" value="<?=@$info['id']?>" />
    <table width="100%" border="0" cellpadding="0" cellspacing="2" class="dataedit">
        <tr>
            <th width="11%" align="left">邮件模板名</th>
      <td width="89%"><input name="name" type="text" size="80" value="<?=@$info['name']?>" /></td>
      </tr>
        <tr>
            <th align="left" valign="top"><div style="line-height:22px">邮件主题</div></th>
            <td>
                    <input name="subject" type="text" size="80" value="<?=@$info['subject']?>" />            </td>
        </tr>
        <tr>
            <th align="left">发件人</th>
            <td><input name="sender" type="text" size="25" value="<?=@$info['sender']?>" /></td>
        </tr>
        <tr>
            <th align="left">发件人邮箱</th>
            <td><input name="sender_email" type="text" size="25" value="<?=@$info['sender_email']?>" /></td>
        </tr>
        <tr>
          <th colspan="2" align="left" style="color:#CCCCCC">
         <font color="#0000FF" style=" font-size:14px;"> 模板 </font> <br/>
<font style="color:#993300">  $LINK$ </font>表示 找到密码的链接 例如
<input type="text" readonly="" value="&lt;a href=&quot;http://www.wal.com/?p=xxxxxx\&quot;&gt;http://www.wal.com/?p=xxxxxx&lt;/a&gt;&lt;/div&gt;" style="width: 510px; border: 0pt none;"><font style="color:#993300">$NAME$</font> 表示 用户名 例如 Test1 <br/>
          </th>
        </tr>
        <tr>
            <th align="left" valign="top"><div style="line-height:22px">专题内容</div></th>
            <td><?= Editor::create('XH', array('name' => 'template', 'value' => @$info['template'],'width' => '700', 'height' => 500))?>            </td>
        </tr>
    </table>
<p style="margin:10px 0 10px 72px;">
        <input type="submit" value="保存编辑" />
        &nbsp;
        <input type="button" value="返回上页" onclick="history.back();" />
    </p>
</form>
<script type="text/javascript">
$(pageInit);
var editor;
function pageInit()
{
    editor=$('#content').xheditor({shortcuts:{'ctrl+enter':submitForm}});
    editor=$('#content')[0].xheditor;
}
function submitForm(){$('form[name=articlePost]').submit();}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
