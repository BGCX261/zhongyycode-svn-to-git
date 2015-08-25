<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type="text/css">
#art_list li{margin:12px 2px 2px 10px;}
#art_list li a{font-size:14px; font-weight:bold;}
#art_list li p{color:#000;}

</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="main">
        <div class="mod_editor articles">
            <div class="title">
                <h2><span class="icon"></span>文章编辑</h2>
                <span class="back"> <a href="/book">图书馆首页</a> <a href="/book/user">我的图书馆</a> </span> </div>
            <div class="main">
                <?php include(dirname(dirname(__FILE__)).'/article/bookmenu.php'); ?>
                <br />
                <div class="hd"></div>
                <div class="bd">
                    <table width="100%" cellspacing="0" style="margin-left:10px;">
                      <tr>
                        <td width="250">
                        <div style="margin:10px 5px;"><a href="javascript:d.openAll();">展开</a> | <a href="javascript:d.closeAll();">收起</a></div>
                        <div style="height:400px; overflow-y:auto; background:#F8F8FF; padding:5px; border:1px solid #555;">
                        <script type="text/javascript">
                        d = new dTree('d');
                        d.add(0, -1, '<?=$auth['username']?>的图书目录');
                        <? foreach ($categories as $item) { ?>
                        d.add(<?=$item['cate_id']?>, <?=$item['parent_id']?>, '<?=$item['cate_name']?>[<?=$item['art_num']?>]', '/book/category/list?cate_id=<?=$item['cate_id']?>', '<?=$item['cate_name']?>');
                        <? } ?>
                        document.write(d);
                        </script></div></td>
                        <td valign="top" align="left"><div style="margin-left:15px;width:400px;">
                        <form action="/book/category/cate<?=$cateInfo?'edit':'add'?>" method="post">
                        <h3 style="border-bottom:2px solid #C3D9FF; margin:15px 0 8px 0; padding-bottom:5px;"><?=$cateInfo?'编辑分类 - '.$cateInfo['cate_name']:'添加分类'?></h3>
                        <table width="100%" class="dataedit" cellspacing="3">
                          <tr>
                            <th width="100" align="left">上级分类</th>
                            <td><select name="parent_id">
                            <option value="0">图书馆</option>
                            <? foreach ($categories as $item) { ?>
                            <option value="<?=$item['cate_id']?>" <?=(@$cateInfo['parent_id'] == $item['cate_id'])?'selected':''?>>
                            <? if ($item['parent_id'] > 0) {
                                echo preg_replace(array('/0;\d+;/', '/\d+/', '/;/'), array('', '', '&nbsp; &nbsp; '), $item['path']);
                                echo '|--';
                            } ?> <?=$item['cate_name']?></option><? } ?>
                            </select></td>
                          </tr>
                          <tr>
                            <th align="left">分类名称</th>
                            <td><input name="cate_name" type="text" size="20" value="<?=@$cateInfo['cate_name']?>" /> <font color="red">*</font></td>
                          </tr>

                          <tr  style="display:none">
                            <th align="left" valign="top">栏目描述</th>
                            <td><textarea name="description" style="width:260px;height:100px;" rows="2">默认</textarea><br /></td>
                          </tr>


                          <tr  style="display:none">
                            <th align="left">显示顺序</th>
                            <td><input name="sort_order" type="text" size="4" value="0" /></td>
                          </tr>
                          <tr  style="display:none">
                            <th align="left">是否显示</th>
                            <td><label><input name="is_show" value="1" type="hidden"  /> 是</label>&nbsp;
                            </td>
                          </tr>
                        </table>
                        <p style="margin:10px 0 0 88px;">
                          <input type="submit" value="<?=$cateInfo?'保存修改':'添加分类'?>" class="botton" />
                          <? if ($cateInfo) { ?><input type="button" value="删除分类" class="botton" onclick="cateDel('<?=$cateInfo['cate_id']?>');" /><input type="hidden" name="cate_id" value="<?=$cateInfo['cate_id']?>" /> &nbsp; <a href="/book/category/list">添加分类</a><? } ?>
                        </p>
                        </form>
                        </div></td>
                      </tr>
                    </table>

                </div>
                <div class="ft"></div>
            </div>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function() {
    $('form:last').submit(function() {
        $(this).ajaxSubmit({
            success: function(text){
                if (text == 'succeed') {
                    alert('分类<?=$cateInfo?'修改':'添加'?>成功！');
                    location.reload();
                } else {
                    alert(text);
                }
            }
        });
        return false;
    });
});
function cateDel(id) {
    if (confirm('确认要删除该分类吗？')) {

        $.get('/book/category/catedel', {cate_id : id}, function(text){
            if (text == 'succeed') {
                alert('分类删除成功！');
                location.replace('/book/category/list');
            } else {
                alert(text);
            }
        })
    }
}
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>