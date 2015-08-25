<?=$this->render('header.php') ?>
<? if (empty($this->ruleGroup)) { ?>
<p class="warning">还没有<a href="<?=$this->url(array('controller' => 'rule', 'action' => 'add'))?>">添加权限规则</a></p>
<? } else { ?>
<style type="text/css">
fieldset ul {margin:0; padding:5px; list-style:none;}
fieldset ul li {width:120px; float:left;}
</style>
<form action="<?=$this->url(array('action' => 'append'))?>" method="post" name="ruleList" id="ruleList">

<div style="border-bottom:4px solid #DEEFFA; padding:10px 0; +padding-bottom:0;">
    <div style="width:20%;float:left; text-align:left;">
        <input type="button" name="delPriv" value=" 删除所选 " />
    </div>
    <div style="width:80%;float:right; text-align:right;">
        <select name="priv_name">
            <option value="0">请选择权限</option>
            <? foreach ($this->privileges as $priv_name => $priv_desc) { ?>
            <option value="<?=$priv_name?>"><?=$priv_name?> (<?=$priv_desc?>)</option>
            <? } ?>
        </select>
        <select name="res_name">
            <option value="0">请选择目标资源</option>
            <? foreach ($this->resources as $res_name => $res_desc) { ?>
            <option value="<?=$res_name?>"><?=$res_name?> (<?=$res_desc?>)</option>
            <? } ?>
        </select>
         &nbsp;
        <input type="submit" name="appendPriv" value=" 添加 " />
    </div>
    <div class="clearfloat"></div>
</div>

<? foreach ($this->ruleGroup['rule'] as $res_name => $rules) { ?>
<fieldset>
    <legend><input type="checkbox" name="checkAll" value="input.res_<?=$res_name?>" /> <?=$res_name?> (<?=$this->ruleGroup['resource'][$res_name]?>)</legend>
    <ul>
        <? foreach ($rules as $priv_name => $ruleId) { ?>
        <li><input type="checkbox" name="rule_id[]" value="<?=$ruleId?>" class="res_<?=$res_name?>" /> <?=$priv_name?> (<?=$this->ruleGroup['privilege'][$priv_name]?>)</li>
        <? } ?>
        <div class="clearfloat"></div>
    </ul>
</fieldset>
<? } ?>
<? }?>
</form>
<?=$this->render('footer.php') ?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    $('input[name=delPriv]').click(function(){
        if ($("input:checked").not('input[name=checkAll]').length > 0) {
            if (confirm('确认要删除这些权限吗？')) {
                $('#ruleList').attr('action', '<?=$this->url(array('action' => 'del'))?>').submit();
            }
        } else {
            alert("至少需要选择一个权限才可以执行删除操作");
        }
    });
    $('input[name=appendPriv]').click(function(){
        if ($('select[name=priv_name]').val() == 0) {
            alert('请选择需要添加的权限');
            $('select[name=priv_name]').focus();
            return false;
        } else if ($('select[name=res_name]').val() == 0) {
            alert('请选择目标资源');
            $('select[name=res_name]').focus();
            return false;
        } else {
            return true;
        }
    });
});
</script>
