<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<? if (empty($ruleGroup)) { ?>
<p class="warning">还没有<a href="/admin/rule/add">添加权限规则</a></p>
<? } else { ?>
<style type="text/css">
fieldset ul {margin:0; padding:5px; list-style:none;}
fieldset ul li {width:120px; float:left;}
</style>
<form action="/admin/rule/append?mod_name=<?=$modName?>" method="post" name="ruleList" id="ruleList">
<? if (Auth::getInstance()->hasAllow(array('rule.append', 'rule.delete'))) { ?>
<div style="border-bottom:4px solid #DEEFFA; padding:10px 0; +padding-bottom:0;">
    <? if (Auth::getInstance()->isAllow('rule.delete')) { ?>
    <div style="width:20%;float:left; text-align:left;">
        <input type="button" name="delPriv" value=" 删除所选 " />
    </div>
    <?php } ?>
    <? if (Auth::getInstance()->isAllow('rule.append')) { ?>
    <div style="width:80%;float:right; text-align:right;">
        <select name="priv_name">
            <option value="0">请选择权限</option>
            <? foreach ($privileges as $priv_name => $priv_desc) { ?>
            <option value="<?=$priv_name?>"><?=$priv_name?> (<?=$priv_desc?>)</option>
            <? } ?>
        </select>
        <select name="res_name">
            <option value="0">请选择目标资源</option>
            <? foreach ($resources as $res_name => $res_desc) { ?>
            <option value="<?=$res_name?>"><?=$res_name?> (<?=$res_desc?>)</option>
            <? } ?>
        </select>
         &nbsp;
        <input type="submit" name="appendPriv" value=" 添加 " />
    </div>
    <?php } ?>
    <div class="clearfloat"></div>

</div>
<?php } ?>
<? foreach ($ruleGroup['rule'] as $res_name => $rules) { ?>
<fieldset>
    <legend><? if (Auth::getInstance()->isAllow('rule.delete')) { ?><input type="checkbox" name="checkAll" value="input.res_<?=$res_name?>" /><?php } ?><?=$res_name?> (<?=$ruleGroup['resource'][$res_name]?>)</legend>
    <ul>
        <? foreach ($rules as $priv_name => $ruleId) { ?>
        <li><? if (Auth::getInstance()->isAllow('rule.delete')) { ?><input type="checkbox" name="rule_id[]" value="<?=$ruleId?>" class="res_<?=$res_name?>" /> <?php } ?><?=$priv_name?> (<?=$ruleGroup['privilege'][$priv_name]?>)</li>
        <? } ?>
        <div class="clearfloat"></div>
    </ul>
</fieldset>
<? } ?>
</form>
<? if (Auth::getInstance()->hasAllow(array('rule.append', 'rule.delete'))) { ?>
<script type="text/javascript" language="javascript">
$().ready(function(){
    <? if (Auth::getInstance()->isAllow('rule.delete')) { ?>
    $('input[name=delPriv]').click(function(){
        if ($("input:checked").not('input[name=checkAll]').length > 0) {
            if (confirm('确认要删除这些权限吗？')) {
                $('#ruleList').attr('action', '/admin/rule/del?mod_name=<?=$modName?>').submit();
            }
        } else {
            alert("至少需要选择一个权限才可以执行删除操作");
        }
    });
    <?php } ?>
    <? if (Auth::getInstance()->isAllow('rule.append')) { ?>
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
    <?php } ?>

});
</script>

<?php } ?>
<?php } ?>


<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>