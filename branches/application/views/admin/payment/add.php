<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
label {display:inline;}
table th {height:28px;line-height:24px;padding:0 3px;}
table td {height:24px;line-height:20px;padding:0 3px;}
table tr {background:none repeat scroll 0 0 #FFFFFF;}
</style>


<form method="post" id="list">

<table cellspacing="5">
    <tbody>
        <tr><td><b>支付方式：</b></td><td><input type="text" size="50" value="" name="adapter" > </td></tr>
        <tr><td><b>支付名称：</b></td><td><input type="text" size="50" value="" name="pay_name" ></td></tr>
        <tr><td><b>支付描述：</b></td><td>
            <textarea name="pay_desc" class="autogrow" cols="100" rows="5"></textarea>
        </td></tr>
        <tr><td><b>是否在线支付：</b></td><td>
         <input type="checkbox" name="online" id="online" value="1"  />
        </td></tr>
        <tr><td><b>允许使用</b></td>
            <td><input type="checkbox" name="enabled" id="enabled" value="1"/></td></tr>
        <tr><td><b>支付费用：</b></td><td><input type="text" size="50" value="" name="pay_fee" /></td></tr>
        <tr><td><b>支付密钥：</b></td><td><input type="text" size="50" value="" name="pay_key" /></td></tr>
        <tr><td><b>配置参数:</b></td><td>

        <div class="sconfig"><input name="config[key][]" value="" type="text" size="20" /> =&gt; <input name="config[val][]" value="" type="text" size="50" /></div>

        <div><input type="button" value="增加" id="add_config"  class="button" /> <input type="button" value="删除" id="plus_config"  class="button" /></div>
        </td></tr>
        <tr><td><b>收货确认地址：</b></td><td><input type="text" size="50" value="" name="receive_url" /></td></tr>
        <tr><td><b>排序：</b></td><td><input type="text" size="50" value="0" name="sort_order" /></td></tr>
        <tr><td colspan="2"><input type="submit" value="提交" class="button"> <input type="reset" value="重置" class="button"> <input type="button" onclick="javascript:history.back()" value="返回" class="button"></td></tr>
    </tbody>
</table>


</form>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
    // 添加配置项
    $("#add_config").click(function(){
        $(".sconfig:last").after($(".sconfig:last").clone(true));
        $(".sconfig:last input[name='config[key][]']").val('');
        $(".sconfig:last input[name='config[val][]']").val('');
    });
    //减少配置项
    $("#plus_config").click(function(){
        if($(".sconfig").length<=1)
        {
            alert('配置项至少有一个!')
            return;
        }
        $(".sconfig:last").remove();
    });

});
</script>