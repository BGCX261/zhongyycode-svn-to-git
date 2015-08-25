<?php include(dirname(dirname(__FILE__)).'/header.php'); ?>

<div id="body">
    <div id="content">
        <div class="focus">
            <div class="slide">
               <ul class="slide-list">
                    <?php foreach ($flash as $k => $item) { ?>
                    <li <?php if ($k == 0) echo 'class="current"';?>>

                        <a href="/<?php echo $item['id']?>.html" target="_blank"><img src="<?php echo URL::domain() . Str::changeLoad($thumb->create($item['img_dir'] .'/' . $item['picname'], 315,315)); ?>" /></a>
                    </li>
                    <?php } ?>
                </ul>
                <ul class="slide-trigger">
                    <?php foreach ($flash as $k => $item) { ?>
                    <li <?php if ($k == 0) echo 'class="current"';?>>
                        <img src="<?php echo URL::domain() . Str::changeLoad($thumb->create( $item['img_dir'] .'/' . $item['picname'], 100,100)); ?>" />
                    </li>
                    <?php } ?>
                </ul>
           </div>

        </div>
         <div class="clearfloat"></div>
        <div class="recommended_topics">
            <div class="title">
                <h2><span class="icon"></span>推荐专题</h2>
                <span class="english">+Recommended topics</span>
            </div>
            <div class="body">
                <ul class="lists">
                <?php foreach ($specialpic_list as $key => $item) { ?>
                    <li>
                        <a class="pic" href="/picsubject/<?php echo $item['sid']?>.html" target="_blank">
                            <?php
                                preg_match_all("/(src)=[\"|'| ]{0,}((https?\:\/\/.*?)([^>]*[^\.htm]\.(gif|jpg|bmp|png)))/i",$item['content'], $match);
                                $img = preg_replace("/^http:\/\/[\w\.\-\_]*wal8\.com\//i", '', $match[2][0]);
                            ?>
                            <img src="<?=URL::domain() . $img?>"  width="92" height="92" border="0" alt="<?php echo  $item['title'] ?>"/>
                        </a>
                        <span  style="float:right;width:200px;">
                            <p><b><a  href="/picsubject/<?php echo $item['sid']?>.html" target="_blank"><?php echo  Str::slice($item['title'], 20, '...');?></a></b></p>
                              <p><?php echo Str::slice(Str::strip_html($item['content']), 50, '...');?></p>

                        </span>
                    </li>
                <?php } ?>
                </ul>

            </div>
                <div class="clearfloat"></div>
        </div>
    </div>

    <div id="side">
        <script  language="javascript" src="/js/pic"></script>


        <div class="user_lists">
            <div class="hd">
                <span class="title">
                    <h2>明星用户</h2>
                    <strong>STAR&nbsp;USERS</strong>
                </span>
            </div>
            <div class="bd">
                <ul class="lists">
                    <?php foreach($topUser as $key => $item) { ?>
                    <li>
                        <a class="avatar" href="/u/<?php echo $item['username'] ?>" target="_blank">
                            <img src="<?=(!empty($item['avatar'])) ? $item['avatar']: '/images/album/no_avatar.png';?>" border="0" alt="" title="" />
                        </a>
                        <a class="name" href="/u/<?php echo $item['username'] ?>">
                            <?php echo Str::slice($item['username'],8); ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="ft"></div>
        </div>

    </div>

</div>

<div class="mod_photo_lists recommended_picture">
    <div class="hd">
        <h2><span class="icon"></span>美图推荐</h2>
        <sup class="english">+Recommended&nbsp;picture</sup>
    </div>
    <div class="bd">

        <ul class="lists">
            <?php foreach($recommend as $key => $item) { ?>
            <li>

                <a class="photo" href="/<?php echo $item['id']?>.html" target="photo">

                    <img src="<?php echo URL::domain() . Str::changeLoad($thumb->create($item['img_dir'] .'/' . $item['picname'], 130,130)); ?>" />
                </a>
                <span class="info">
                    <a class="photo_id" href="/<?php echo $item['id']?>.html" title="<?php echo $item['custom_name']?>"target="photo"><?php echo Str::slice($item['custom_name'],15, '...')?></a><br />
                    会员：<?php echo ORM::factory('user', $item['userid'])->username?><br />

                    上传时间：<?php echo date('Y-m-d', $item['uploadtime']);?>
                </span>
            </li>

            <?php } ?>
        </ul>
    </div>
</div>

<?php include(dirname(dirname(__FILE__)).'/footer.php'); ?>
