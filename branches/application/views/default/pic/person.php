<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>
<link href="/styles/album/photos_lists.css" rel="stylesheet" type="text/css" />
<div id="body">
  <div id="side">
    <div class="mod_user_info">
      <div class="hd"></div>
      <div class="bd">

            <a href="/u/<?php echo  $userInfo->username; ?>" target="user"> <img class="avatar" src="<?php echo (!empty($userInfo->avatar)) ? $userInfo->avatar : '/images/album/no_avatar.png'; ?>" alt="" width="92" height="92" border="0" /> </a>
        <div class="info" > <span class="icon"></span><a class="name" href="/u/<?php echo $userInfo->username; ?>" >【<?php echo  $userInfo->username; ?>】</a>
          <p> 个性签名：<?php echo (!empty($userInfo->field->sign)) ? Str::slice($userInfo->field->sign, 30, '...') : '这家伙好懒，什么也没留下'; ?></p>
          <a class="friend" href="/friend/apply?uid=<?php echo $userInfo->uid; ?>">[加为好友]</a><!--a class="message" href="#">[我要留言]</a--> </div>

      </div>
      <div class="ft"></div>
    </div>
    <div class="mod_share_album">
      <div class="bd">
        <ul class="album_lists">
            <?php if(empty($shareCateList)) { ?>
            <li style="height:50px;line-height:50px;">暂无共享相册</li>

            <?php }?>
            <?php foreach($shareCateList as $k => $cate ) { ?>
          <li> <a class="photo" href="/u/<?=urlencode($userInfo->username);?>?cate_id=<?=$cate['cate_id'] ?>" > <img src="<?=(!empty($cate['index_img']))? $cate['index_img'] : '/images/user/category.jpg'?>" alt=""  border="0"width="92" height="92" /> </a>
                <a class="photo_id" href="/u/<?=urlencode($userInfo->username);?>?cate_id=<?=$cate['cate_id'] ?>" ><?php echo Str::slice($cate['cate_name'], 15, '...'); ?></a>
              <br />
            <strong>数量：<?=$cate['img_num']?></strong> </li>
            <?php } ?>
        </ul>
      </div>
    </div>
    <div class="book_topics">
      <div class="hd">
        <h2><span class="icon"></span>专题分享</h2>
      </div>
      <div class="bd">
        <ul class="lists">
            <?php foreach ($subjectList as $item) { ?>
            <li> <a href="/picsubject/<?=$item->sid?>.html"  target="_blank"> <span class="icon"></span> <span class="title"><?php echo Str::slice($item->title, 20);?></span> <span class="stat">点击：<?php echo $item->click;?>次</span> </a> </li>
            <?php }?>

        </ul>
      </div>
    </div>
    <div class="book_topics">
      <div class="hd">
        <h2><span class="icon1"></span>图书收藏</h2>
      </div>
      <div class="bd">
        <ul class="lists">
          <?php foreach ($bookist as $item) { ?>
          <li> <a href="/articles/<?=$item->article_id?>.html" target="_blank"> <span class="icon"></span> <span class="title"><?=Str::slice($item->title, 20, '...')?></span> <span class="stat">点击：<?php echo $item->views;?>次</span> </a> </li>
        <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  <div id="content">
    <div class="mod_photo_lists photo_lists">
      <div class="hd">
        <h2><span class="icon"></span><a href="/u/<?=urlencode($userInfo->username);?>" style="color:#83C74E;">我的共享相册列表</a>
            <?php foreach($shareCateList as $k => $cate ) {
                if($cate['cate_id'] == $cate_id) {
                    echo '- ' . $cate['cate_name'];
                }
            }?>
        </h2>
        <div class="info"> <span>数量：<?php echo count($pagination);?></span> </div>
        <ul class="back">
          <li><a href="/">返回首页</a></li>
        </ul>
      </div>
      <div class="bd">
        <ul class="lists">
         <?php foreach($pagination as $k => $img ) { ?>
          <li style="height:200px;">
              <a class="photo" href="/<?php echo $img['id']?>.html" target="photo" style="height:130px; width:130px;">
                  <img src="<?php echo URL::domain() . Str::changeLoad($thumb->create($img['disk_name'].'/' . $img['picname'], 130,130)); ?>" />
               </a>
              <span class="info"> <a class="photo_id" href="/<?php echo $img['id']?>.html" title='查看图片详情'><?php echo Str::slice($img['custom_name'], 15 ,'...');?></a><br />
            <strong>&nbsp;浏览<?php echo $img['click']?>次</strong> </span> </li>

        <?php } ?>
        </ul>
        <div class="clearfloat"></div>
      </div>
      <div class="clearfloat"></div>
      <div class="filp"><?php echo $pagination->render('pagination/digg');?></div>
    </div>
  </div>
</div>
<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
