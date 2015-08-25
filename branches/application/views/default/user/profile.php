<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<style type='text/css'>
#content{width:750px; float:left;}
.user_ziliao_A {background:url("/images/user/user_ziliao_A.gif") no-repeat scroll 0 0 transparent;height:325px;
margin-top:20px;padding-left:40px;padding-top:75px;}
#title_sub{background: url(/images/user/user_banjia_tijiao.gif) repeat scroll 0% 0% transparent; width: 64px; height: 27px; border: 0px none;}
.upload_note{width:270px; float:left; margin-top:10px; text-align:left;}
.shop_add{border:1px solid #CCCCCC;height:70px;width:265px;}
.zxxx {background:url("/images/user/zxxx.gif") no-repeat scroll 0 0 transparent;height:30px;line-height:30px;margin-bottom:0;padding-left:85px;width:660px;}
.user_anquan {background:url("/images/user/user_anquan.gif") no-repeat scroll 0 0 transparent;height:260px;line-height:24px;margin-top:20px;padding-left:230px;padding-top:60px;text-align:left;}
</style>
<div id="body">
    <?php include(dirname(dirname(__FILE__)).'/menu.php'); ?>
  <div id="content">
    <div class="zxxx">
        <marquee aligh='left' direction='left' behavior='scroll' onmouseover='this.stop();' onmouseout='this.start();' scrolldelay='150'>
            <span id="newgoals"><?php echo $configs['marquee_message']; ?></span>
        </marquee>
    </div>
    <div><img src="/images/user/user_ziliao_top_2.gif" /></div>
    <form enctype="multipart/form-data" action="" method="post" id="profile">
    <div class="user_ziliao_A">
       <table>
           <tr>
               <td style="width:85px;">用户头像：</td>
               <td style="width:125px; ">
                   <div style="height:100px;"><img src="<?=(!empty($auth['avatar'])) ? $auth['avatar'] : '/images/album/img/no_avatar.png';?>" class="user_head2"  width="92" height="92"/></div>
                   <p> 当前头像预览</p>
               </td>
               <td style="width:440px; text-align:left; padding-left:20px;">
               头像上传：
                <input type="file" id="upload_file" name="upload_file" style="border:1px solid #ccc; width:270px; color: #576d07;" />
                <input type="submit" name="sbm_album" value=" " id="sbm_album" style="background:url(/images/user/user_shangchuan_btn.gif); width:64px; height:27px; border:0px;" />
               <br />
               <div class="upload_note">
                    <p>图片标准大小：92*92像素</p>
                    <p>支持图片格式：jpg或gif</p>
                    <p>图片文件大小：不得超过100k</p>
               </div>
               <div class="clear tleft" style="width:410px;"> 如需要换头像图片，请点击<span class="green">“浏览”</span>，
               选择好本地图片后点击<span class="green">“上传”</span>按钮待图片上传成功后，将在“当前头像预览”处进行显示并立即生效出现在您的个人信息里。</div>
               </td>
           </tr>
       </table>
           <p>签名修改：<input type="text" id="title" name="sign" size="80" value="<?=(!empty($auth_field['sign'])) ? $auth_field['sign']: '这家伙好懒，什么也没留下';?>" >
            <input type="submit" style="" id="title_sub" value=" " name="title_sub">
           </p>
           <div style="width: 240px;float:left;margin:15px 0 0 0;">
               <p><span style="width: 63px;"><img src="/images/user/icon_qq.gif"> QQ号：</span>
               <input type="text" value="<?=$auth_field['qq']?>" style="width: 135px;" name="qq" ></p>
               <p style="margin-top: 7px;"><span style="width: 63px;"><img src="/images/user/icon_ww.gif"> 旺 旺：</span>
               <input type="text" value="<?=$auth_field['msn']?>" style="width: 135px;" name="msn" ></p>
           </div>
          <div style="width: 440px;float:left;margin:10px 0 0 0;">
           店铺地址：<textarea name="shopadd" class="shop_add"><?=$auth_field['address']?></textarea>
        <input type="submit" style="background: url(/images/user/user_banjia_tijiao.gif) repeat scroll 0% 0% transparent; width: 64px; height: 27px; border: 0px none;" id="info_sub" value=" " name="info_sub">

           </div>

        </div>

        <div class="user_anquan">
           <div style="line-height: 30px; height: 30px;" class="green"><img src="/images/user/icon_7.gif"> 如果想使用初始密码，请将“新密码”框留空</div>

               <table>
                   <tbody><tr>
                        <td><img src="/images/user/icon_3.gif"></td>
                        <td>用 户 名：</td>
                       <td class="green"><?=$auth['username']?></td>
                   </tr>
                   <tr><td><img src="/images/user/icon_3.gif"></td>
                       <td>电子邮箱：</td>
                       <td><input type="text" value="<?=$auth['email']?>" name="editemail" ></td>
                   </tr>
                   <tr>
                    <td><img src="/images/user/icon_3.gif"></td>
                    <td>新 密 码：</td>
                    <td><input type="password" name="editpass"></td>
                   </tr>
                    <tr>
                       <td><img src="/images/user/icon_3.gif"></td>
                       <td>确认密码：</td>
                       <td><input type="password" name="editpass_2"></td>
                   </tr>
                   <tr>
                    <td> </td><td></td>
                   <td style="padding-top: 2px;">
                        <input type="submit" style="background: url(/images/user/user_banjia_tijiao.gif) repeat scroll 0% 0% transparent; width: 64px; height: 27px; border: 0px none;" id="priv_sub" value=" " name="priv_sub">
                   </td>
                   </tr>
               </tbody></table>

           </div>
            </form>

   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#profile').submit(function(){
            var title = $('#title').val();
            if(title.length > 35){
                alert('签名不允许多于35个字符');
                return false;
            }

        });
    });
</script>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>