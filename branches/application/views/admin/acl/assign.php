<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<? if (empty($ruleGroup)) { ?>
    <p class="warning">还没有<a href="/admin/rule/add?mod_name=<?=$modName?>">添加权限规则</a>，无法进行权限指派</p>
<? } else { ?>
<style type="text/css">
fieldset ul {margin:0; padding:5px; list-style:none;}
fieldset ul li {width:120px; float:left;}
</style>
<form action="/admin/acl/save?role_id=<?=$roleId?>&mod_name=<?=$modName?>" method="post" name="aclAssign" id="aclAssign" class="allowKeySubmit">
<div style="border-bottom:4px solid #DEEFFA; padding:10px 0; +padding-bottom:0;">
    <select name="role_id">
        <? foreach ($roles as $role) { ?>
        <option value="<?=$role['role_id']?>" <?=Str::selected($role['role_id'], $roleId)?>><?=$role['role_name']?> (<?=$role['role_desc']?>)</option>
        <? } ?>
    </select>
    <input type="submit" name="saveAssign" value=" 保存设定 " />
    <input type="reset" name="resetAssign" value=" 重置表单 " />
</div>
<? foreach ($ruleGroup['rule'] as $res_name => $rules) { ?>
<fieldset>
    <legend><input type="checkbox" name="checkAll" value="input.res_<?=$res_name?>" /> <?=$res_name?> (<?=$ruleGroup['resource'][$res_name]?>)</legend>
    <ul>
        <? foreach ($rules as $priv_name => $ruleId) { ?>
        <li><input type="checkbox" name="rule_id[]" value="<?=$ruleId?>" class="res_<?=$res_name?>" <?=Str::checked(true, in_array($ruleId, $allowRules))?> /> <?=$priv_name?> (<?=$ruleGroup['privilege'][$priv_name]?>)</li>
        <? } ?>
        <div class="clearfloat"></div>
    </ul>
</fieldset>
<? } ?>
</form>
<script type="text/javascript" language="javascript">
$().ready(function(){
    $('select[name=role_id]').change(function(){
        location.replace('/admin/acl/assign?mod_name=<?=$modName?>&role_id=' + this.value);
    });
});
</script>
<? } ?>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>