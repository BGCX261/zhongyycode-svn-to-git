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

<form name="articlePost" action="" method="post">
    <input type="hidden" name="uid" value="<?=$info['uid']?>" />
    <input type="hidden" name="sid" value="<?=$info['sid']?>" />
    <table width="100%" border="0" cellpadding="0" cellspacing="2" class="dataedit">
        <tr>
            <th align="left">标题</th>
            <td><input name="title" type="text" size="80" value="<?=$info['title']?>" />
                <font color="red">*</font>
                <input name="post_date" type="text" value="<?=date('Y-m-d H:i:s', $info['add_time'])?>" size="20" /></td>
        </tr>
        <tr>
            <th align="left" valign="top"><div style="line-height:22px">标签</div></th>
            <td><div style="line-height:22px">
                    <input name="tags" type="text" size="100" value="<?=implode(' ', $tags)?>" />
                    <font color="gray">多个标签请使用空格 进行分隔</font> &nbsp;</div>
            </td>
        </tr>
        <tr>
            <th align="left">作者</th>
            <td><input name="from" type="text" size="25" value="<?=$info['username']?>" />

                &nbsp;&nbsp; &nbsp;是否分享<input class="np" name="is_share" value="<?=$info['is_share']?>" type="checkbox" <?=($info['is_share'] == 1)? ' checked="checked"' : '' ?>/></td>
        </tr>

        <tr>
        <tr>
            <th align="left" valign="top"><div style="line-height:22px">专题内容</div></th>
            <td><?= Editor::create('XH', array('name' => 'content', 'value' => $info['content'],'width' => '700', 'height' => 500))?>
                <div style="line-height:22px">
                    <font color="red"><?=$info['click']?></font>次浏览，
                    <font color="red"><?=$info['comment']?></font> 条评论
            </div>
            </td>
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
