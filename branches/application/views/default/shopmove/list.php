<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:0;padding-left:85px;width:660px;}
.bj_A {background:url("/images/user/user_banjia_B_bg.gif") no-repeat scroll 0 0 transparent;height:639px;padding-left:67px;padding-top:57px;}
.user_banjia {margin-top:10px;position:relative;}
input{border:0px;}
.bj_A p {margin-top:5px;}
.tcent {text-align:center;}
p {line-height:20px;}
.fright{float:right;}
.user_banjia .user_banjia_btn {left:36px;position:absolute;top:5px;padding-left:25px;width:300px;height:30px;line-height:30px; text-align:left;color:#FFF;}
.user_banjia .user_banjia_btn a {color:#FFF;font-weight:bold}
.user_dianpu_B{width:600px;}
.user_dianpu_B li p {height:30px;}
</style>

<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
    <div id="content">
        <div class="zxxx">
            <marquee scrolldelay="150" onmouseout="this.start();" onmouseover="this.stop();" behavior="scroll" direction="left" aligh="left">
                <?=$configs['marquee_message']?>
            </marquee>
        </div>
        <div><img src="/images/user/user_banjia_top_2.gif"></div>
        <div class="user_banjia_btn"><a href="move_item.php">&nbsp;</a> <a style="margin-left: 10px;" href="move_item_hist.php">&nbsp;</a></div>
        <div class="user_banjia bj_A">
            <ul class="user_dianpu_B" >
                <?php foreach ($results as $item) {

                    $down_c = "/dest_csv/" .$item['uid'] . '/' . $item['dest_file'];
                    $down_sroure = "/src_csv/" . $item['uid'] . '/' . $item['src_file'];
                    switch($item['status']){
                            case 0:
                                $status='排队中...';
                                $new_file='尚未完成...';
                                break;
                            case 1:
                                $status='已完成';
                                $new_file='<a href="'.$down_c.'" target="_blank" class="ahuang">
                                '.$item['dest_file'].'【下载】</a>';
                                break;
                            case 2:
                                $status =' 空间不足,部分完成' . '<a href="/shopmove/continue?id='. $item['id'].'"  class="ahuang">
                                '.'【点击继续】</a>';
                                $new_file='';
                                break;
                            case 3:
                                $status ='<a href="/help?k=25" title="查看帮助" target="_blank">图片地址不符合搬家规则</a>';
                                $new_file='';
                                break;
                            case 4:
                                $status='正在搬家...';
                                $new_file='尚未完成...';
                                break;
                        }

                ?>
                <li>
                       <p> <span class="fright" style="padding-right:20px;">状态：<?=$status?>
                        <a href="/shopmove/del?id=<?=$item['id']?>" onclick="return confirm('您确定要删除此记录？');" >
                        <img src="/images/user/icon_6.gif" alt="删除" /></a></span><span class="green"><?=$item['csv_file']?></span>  </p>
                            <div class="clear"></div>
                            <table>
                                <tr>
                                    <td>上传时间：<?=$item['upload_time']?></td>
                                    <td>完成时间：<?=$item['finish_time']?></td>
                                </tr>
                                <tr >
                                    <td >源文件：<a href="<?=$down_sroure?>" target="_blank" class="ahuang"><?=$item['csv_file']?></a>
                                    </td>
                                    <td >新文件：<?=$new_file?>
                                    </td>
                                </tr>
                            </table>
                        </li>
                <?php } ?>
                </ul>
                <div style="margin-top: 20px;"><?php echo $pagination->render('pagination/digg');?></div>
                <div class="user_banjia_btn"><a href="/shopmove" style="color:#4FAF03;">店铺搬家</a> <a style="margin-left: 60px;color:#FFF" href="/shopmove/list">历史记录</a></div>

           </div>

    </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>