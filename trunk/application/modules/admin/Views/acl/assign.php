<?=$this->render('header.php'); ?>
<? if (empty($this->ruleGroup)) { ?>
    <p class="warning">还没有<a href="<?=$this->url(array('controller' => 'rule', 'action' => 'add'))?>">添加权限规则</a>，无法进行权限指派</p>
<? } else { ?>
<style type="text/css">
fieldset ul {margin:0; padding:5px; list-style:none;}
fieldset ul li {width:120px; float:left;}
</style>
<form action="<?=$this->url(array('action' => 'save', 'role_id' => $this->roleId))?>" method="post" name="aclAssign" id="aclAssign" class="allowKeySubmit">

<div style="border-bottom:4px solid #DEEFFA; padding:10px 0; +padding-bottom:0;">
    <select name="role_id">
        <? foreach ($this->roles as $role) { ?>
        <option value="<?=$role['role_id']?>" <?=$this->html()->selected($role['role_id'], $this->roleId)?>><?=$role['role_name']?> (<?=$role['role_desc']?>)</option>
        <? } ?>
    </select>
    <input type="submit" name="saveAssign" value=" 保存设定 " />
    <input type="reset" name="resetAssign" value=" 重置表单 " />
</div>
<? foreach ($this->ruleGroup['rule'] as $res_name => $rules) { ?>
<fieldset>
    <legend><input type="checkbox" name="checkAll" value="input.res_<?=$res_name?>" /> <?=$res_name?> (<?=$this->ruleGroup['resource'][$res_name]?>)</legend>
    <ul>
        <? foreach ($rules as $priv_name => $ruleId) { ?>
        <li><input type="checkbox" name="rule_id[]" value="<?=$ruleId?>" class="res_<?=$res_name?>" <?=$this->html()->checked(true, in_array($ruleId, $this->allowRules))?> /> <?=$priv_name?> (<?=$this->ruleGroup['privilege'][$priv_name]?>)</li>
        <? } ?>
        <div class="clearfloat"></div>
    </ul>
</fieldset>
<? } ?>
</form>
<script type="text/javascript" language="javascript">
$().ready(function(){
    $('select[name=role_id]').change(function(){
        location.replace('<?=$this->url(array('role_id' => $this->roleId))?>'.replace(/(\/role_id\/)\d+/, '$1' + this.value));
    });
});
</script>
<? } ?>
<?=$this->render('footer.php'); ?>