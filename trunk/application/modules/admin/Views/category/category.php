<?=$this->render('header.php'); ?>
<script type="text/javascript" src="/scripts/dtree.js"></script>
<style type="text/css">
#tree {float:left;}
#action {margin-left:300px;text-align:left;}
</style>
<form method="POST">
<input type="hidden" name="cate_id" value="<?=$this->cate_id?>" />
<div id="main" >
    <div id="tree">
        <div style="margin:5px;"><a href="javascript:d.openAll();">全部展开</a>&nbsp; | &nbsp;<a href="javascript:d.closeAll();">全部闭合</a></div>
        <script type="text/javascript">
        d = new dTree('d');
        d.add(0, -1, '文章分类设置');
        <?
        foreach ($this->cateList as $item) { ?>
        d.add(<?=$item['cate_id']?>, <?=$item['parent_id']?>, '<?=$item['cate_name']?>', '<?=$this->url(array('cate_id' => $item['cate_id']))?>', '<?=$item['cate_name']?>');
        <? } ?>
        document.write(d);
        </script>
    </div> <!-- end #tree -->
    <div id="action" style="">
        <table cellspacing="10">
        <tr><td><b>上级分类</b></td><td><select name="parent_id">
        <option value="0">—— 选择父分类 ——</option>
        <? foreach ($this->cateList as $item) { ?>
        <option value="<?=$item['cate_id']?>" <?=($item['cate_id'] == $this->info['parent_id']) ? 'selected' : ''?>>
        <?=preg_replace(array('/^0;\d+;/', '/\d+;/'), array('', ' &nbsp; &nbsp; &nbsp;'), $item['path']) . $item['cate_name']?>
        </option>
        <? } ?>
        </select></td></tr>
        <tr><td><b>分类名称</b></td><td><input type="text" name="cate_name" size="30" value="<?=$this->info['cate_name']?>"/></td></tr>
        <tr><td><b>排序</b></td><td><input type="text" name="sort_order" value="<?=$this->info['sort_order']?>" size="4"/></td></tr>
        <tr><td><b>是否显示</b></td><td><select name="is_show">
        <option value="1" <?=$this->info['is_show'] ? 'selected' : ''?>>是</option>
        <option value="0" <?=$this->info['is_show'] ? '' : 'selected'?>>否</option></select></td></tr>
        <tr><td colspan="2">
        <? if (empty($this->cate_id)) { ?>
        <input type="button" value="新增分类" onclick="add();" />
        <? } else { ?>
        <input type="button" value="保存编辑" onclick="update();" />
        <input type="button" value="删除分类" onclick="if (confirm('一旦删除将无法恢复，您确认要删除该记录吗？')) {window.location='<?=$this->url(array('action' => 'del'))?>'}" />
        <? } ?>
        </td></tr>
        </table>
    </div> <!-- end #action -->
    <div class="clearfloat"></div>
</div> <!-- end #main -->
</form>
<script type="text/javascript">
function add() {
    $("form:first").attr('action', '<?=$this->url(array('action' => 'add'))?>');
    $("form:first").submit();
};
function update() {
    $("form:first").attr('action', '<?=$this->url(array('action' => 'update'))?>');
    $("form:first").submit();
};
</script>
<?=$this->render('footer.php');?>