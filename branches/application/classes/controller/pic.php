<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 图片
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-15
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Pic extends Controller_Base {

    /**
     * 控制器方法执行前操作
     *
     */
    public function before()
    {
        parent::before();
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
    }

    /**
     * 个人相册首页
     */
    public function action_index()
    {
        //$this->request->redirect('/');
        $this->template->pageTitle = '免费淘宝相册';
        $this->_add_script('scripts/album/index.js');
        $this->_add_css('styles/album/album_home.css');


        // 明星用户
       $this->template->topUser = $topUser = DB::select()->from('users')
            ->where('index_top', '=', 1)
            ->order_by('uid', 'DESC')
            ->limit(12)
            ->fetch_all();
        // 美图推荐
        $this->template->recommend = DB::select('i.id', 'i.uploadtime', 'i.picname', 'i.userid','i.disk_id', 'i.picname', 'i.custom_name', array('i.disk_id','disk_domain'), array('i.disk_name', 'img_dir'))
            ->from(array('imgs', 'i'))
            ->where('i.is_top', '=', 1)
            ->order_by('i.id', 'DESC')
            ->limit(10)
            ->fetch_all();

      // 图片滚动
      $this->template->flash = DB::select('i.id', 'i.uploadtime', 'i.picname', 'i.userid','i.disk_id', 'i.picname', 'i.custom_name',array('i.disk_id','disk_domain'), array('i.disk_name', 'img_dir'))
            ->from(array('imgs', 'i'))
            ->where('i.is_flash', '=', '1')
            ->order_by('i.id', 'DESC')
            ->limit(9)
            ->fetch_all();

      // 推荐专题
      $this->template->specialpic_list = DB::select()->from(array('specialpics', 's'))
                    ->where('s.is_top', '=', 1)
                    ->limit(4)
                    ->order_by('s.sid', 'DESC')
                    ->fetch_all();      
    }

    /**
     * 显示用户共享相册
     */
    public function action_person()
    {

        $username = $this->request->param('username');
        if(!$this->auth || !empty($username)) {
            $user = ORM::factory('user');
            $this->template->userInfo = $userInfo = $user->where('username', '=', $username)->find();
            if(empty($userInfo->username)) {
                $this->show_message('非法访问');
            }
            $this->auth['username'] = $userInfo->username;
            $uid = $userInfo->uid;
        } else {
            $uid = $this->auth['uid'];
            $this->template->userInfo = $userInfo = new ArrayObj($this->auth);
        }

        $user = ORM::factory('user', $uid);
        if ($user->status != 'approved'  || $user->expire_time < time()) {
            $links[] = array(
                'text' => '返回首页',
                'href' => '/',
            );
            $this->show_message('该用户已经过期或者禁止,不允许访问其所属的图片', 1, $links, true, 10000);
        }
        $this->template->pageTitle = $this->auth['username'] . '的相册';

        $this->template->shareCateList = DB::select('cate.cate_id', 'cate.cate_name', 'cate.index_img', 'cate.img_num', 'cate.is_share')
            ->from(array('img_categories', 'cate'))
            ->where('uid', '=', $uid)
            ->where('is_share', '=', 1)
            ->order_by('cate.cate_id','DESC')
            ->fetch_all();
        $select = DB::select('i.id', 'i.picname', 'i.custom_name', 'i.disk_id', 'i.userid', 'i.click', 'i.is_share', array('i.disk_id', 'disk_domain'), 'i.disk_name')
            ->from(array('imgs', 'i'))
            ->where('i.userid', '=', (int) $uid)
            ->where('i.is_share', '=', 1)
            ->order_by('i.cate_id','ASC');
        $this->template->cate_id = $cate_id = (int) $this->getQuery('cate_id');
        if ($cate_id > 0) {
            $select->where('i.cate_id', '=', (int) $cate_id);
        }


        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE), array('items_per_page' => 15));

        // 专题图片
        $this->template->subjectList = $category = ORM::factory('specialpic')
            ->where('uid', '=', (int) $uid)
            ->where('is_share', '=', 1)
            ->limit(6)
            ->order_by('sid', 'DESC')
            ->find_all();
        // 共享文章
        $this->template->bookist = $bookist = ORM::factory('article')
            ->where('uid', '=', (int)$uid)
            ->where('is_show', '=', 1)
            ->limit(6)
            ->order_by('article_id', 'DESC')
            ->find_all();
        // 更新访问量
        DB::update('users')->set(array('visit' => DB::expr("visit + 1")))->where('uid', '=', (int)$uid)->execute();
    }


    /**
     * 查看相片
     */
    public function action_view()
    {

        $tag = new Tags();
        $this->template->pid = $pid  = $this->request->param('id');

        $imgSelect = DB::select('i.id', 'i.cate_id', 'i.uploadtime', 'i.picname', 'i.userid','i.disk_id', 'i.picname',
            'i.custom_name',array('i.disk_id', 'disk_domain'), 'i.click','i.comment_num', 'i.support', 'i.oppose', array('i.disk_name', 'img_dir'))
            ->from(array('imgs', 'i'))
            ->order_by('i.id', 'DESC');

        $imgInfo = $imgSelect->where('i.id', '=', (int) $pid)->fetch_row();
        $this->template->pageTitle = $imgInfo['custom_name'];

        $imgInfo['cate_name'] = DB::select('cate_name')->from('img_categories')->where('cate_id', '=', (int) $imgInfo['cate_id'])->fetch_one();
        $user = ORM::factory('user', $imgInfo['userid']);
        $imgInfo['username'] = $user->username;
        $imgInfo['avatar'] = $user->avatar;
        $imgInfo['uid'] = $user->uid;
        $imgInfo['sign'] = ORM::factory('user_field', (int) $imgInfo['userid'])->sign;

        $this->template->imgInfo = $imgInfo;
        if (empty($imgInfo)) {
           $this->show_message('非法访问', 0, array() , true);
        }

        if ($user->status != 'approved'  || $user->expire_time < time()) {
            $links[] = array(
                'text' => '返回首页',
                'href' => '/',
            );
            $this->show_message('该用户已经过期或者禁止,不允许访问其所属的图片', 1, $links, true, 10000);
        }


        $this->template->tags = $tags = $tag->get($pid, 'img');
        $select = DB::select('c.*', 'u.username', 'u.avatar')
            ->from(array('comments', 'c'))
            ->where('c.item_id', '=', (int) $pid)
            ->where('c.app', '=', 'img')
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'c.author');
        $this->template->commentList = $select->execute()->as_array();


        if ($this->isPost()) {
            $tags = trim($this->getPost('tags'));
            $pid = (int) $this->getPost('pid');
            $tags = explode(' ', $tags);
            $tag->add($pid, 'img', $tags, $imgInfo['userid']);
            $this->request->redirect('/'. $pid . '.html');
        }

         // 更新访问量
        DB::update('users')->set(array('visit' => DB::expr("visit + 1")))->where('uid', '=', (int)$imgInfo['userid'])->execute();
        DB::update('imgs')->set(array('click' => DB::expr('click + 1')))->where('id', '=', (int)$pid)->execute();

    }

    /**
     * ajax获取三张共享图片
     */
    public function action_ajaxSharePic()
    {

        $cate_id = (int) $this->getQuery('cate_id');
        $uid = (int) $this->getQuery('uid');
        $id = (int) $this->getQuery('id');
        // 该分类下的其它共享图片
        $select = DB::select('i.id', 'i.cate_id', 'i.uploadtime', 'i.picname', 'i.userid','i.disk_id', 'i.picname','i.custom_name',array('i.disk_id', 'disk_domain'), 'i.click', array('i.disk_name', 'img_dir'))
            ->from(array('imgs', 'i'))
            ->where('i.is_share', '=', 1)
            ->where('i.cate_id', '=', $cate_id)
            ->where('i.userid', '=', $uid);
        $select2 = clone $select;
        $select3 = clone $select;

        $row = $select->where('i.id', '>', $id)->fetch_row();
        $row2 = $select2->where('i.id', '=', $id)->fetch_row();
        $row3 = $select3->where('i.id', '<', $id)->fetch_row();
        $str = $this->return_data($row);
        $str .= $this->return_data($row2);
        $str .= $this->return_data($row3);
        if (empty($row2)) $str = '<li style="width:160px; text-align:center;">暂无其它共享图片</li>';
        $arr = array(
            'pic_list' => $str,
            'prev_id' => $row['id'],
            'next_id' => $row3['id'],

        );

        echo json_encode($arr);

        $this->auto_render = false;
    }

    public function return_data($item)
    {
        if(!is_array($item)) return '<li>这是最后一张</li>';
        $str = '';
        $str .= '<li><p><a class="photo" href="/'. $item['id']. '.html"> <img src="'.  URL::domain() . Str::changeLoad($this->thumb->create( $item['img_dir'] .'/' . $item['picname'], 65, 65)).'"  alt="查看图片详情" border="0" /> </a></p>';
            $str .= '<p><a class="photo_id" href="/'. $item['id'] .'.html" title="查看">' . Str::slice($item['custom_name'],10, '..') . '</a></p><p>浏览'. $item['click'] .'次</p></li>';
            return $str ;
    }

    /**
     * 图片心情操作
     */
    public function action_mood()
    {

        $item_id = (int) $this->getQuery('item_id');
        $do = trim($this->getQuery('app', 'support'));
        $moodSession = Session::instance()->get('item_id_' . $item_id, false);
        if(empty($moodSession)) {
            $arr = array('item_id' => $item_id, 'app' => $do);
            Session::instance()->set('item_id_' . $item_id, $arr);
            DB::update('imgs')->set(array($do => DB::expr(" $do + 1")))->where('id', '=', $item_id)->execute();
        } else {
            echo '您已经赞过或者鄙视过这张图片了，请不要重复。谢谢!';
        }

        $this->auto_render = false;
    }

    /**
     * 图片评论操作
     */
     public function action_comment()
     {
        $comment = ORM::factory('comment');
        if($this->isPost()) {
             $pid = (int) $this->getPost('pid');
             $content = trim($this->getPost('content'));
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('pid', 'not_empty')
                ->rule('content', 'not_empty');
            // 登录不需要验证码
            if (!$this->auth ) {
                $post = $post->rule('captcha', 'not_empty')->rule('captcha','Captcha::valid');
            }

            if ($post->check()) {
                $comment->item_id = $pid;
                $comment->app = 'img';
                $comment->author = $this->auth['uid'];
                $comment->author_ip = Request::$client_ip;
                $comment->anonymous = (int) $this->getPost('anonymous');
                $comment->values($post);
                $comment->save();
                DB::update('imgs')->set(array('comment_num' => DB::expr('comment_num + 1')))->where('id', '=', $pid)->execute();
                $this->request->redirect('/'. $pid . '.html');
            } else{
                $str = '';
                $this->template->registerErr = $errors = $post->errors('default/pic/pic');
                    foreach($errors as $item) {
                        $str .= $item  . '<br>';
                    }
                $this->show_message($str);
            }
        }
        $this->auto_render = false;
     }

    /**
     * 图片评论回复
     *
     */
    public function action_replay()
    {
        $comment = ORM::factory('comment');
        if($this->isPost()) {
             $cid = (int) $this->getPost('replay_cid');
             $pid = (int) $this->getPost('pid');
             $content = trim($this->getPost('content'));
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('pid', 'not_empty')
                ->rule('content', 'not_empty');
            // 图片信息
            $imgInfo = DB::select()
                    ->from(array('imgs', 'i'))
                    ->where('i.id', '=', (int)$pid)
                    ->execute()
                    ->current();
            if($this->auth['uid'] != $imgInfo['userid']) {
                    $this->show_message('你不能回复不是你的图片的评论');
            }

            if ($post->check()) {

                $comment->item_id = $pid;
                $comment->quote_id = $cid;
                $comment->app = 'img';
                $comment->author = $this->auth['uid'];
                $comment->author_ip = Request::$client_ip;
                $comment->values($post);
                $comment->save();

                $rows = DB::select('content', 'u.username')
                    ->from(array('comments', 'c'))
                    ->where('cid', '=', $cid)
                    ->join(array('users', 'u'), 'LEFT')
                    ->on('u.uid', '=', 'c.author')
                    ->execute()
                    ->current();
                empty($rows['username']) && $rows['username'] = '匿名';
                $arr = array(
                    'quote_id' => $cid,
                    'quote' => '&nbsp;&nbsp;&nbsp;&nbsp;<i><b>回复 ' . $rows['username'] . ' 的内容:' . $rows['content'] . '</b></i>',
                );
                DB::update('comments')->set($arr)->where('cid', '=', $comment->cid)->execute();
                $count = DB::select(DB::expr('COUNT(*) AS count'))
                    ->from('comments')
                    ->where('quote_id', '=', $cid)
                    ->execute()
                    ->get('count');
                DB::update('comments')->set(array('replies' => $count))->where('cid', '=', $cid)->execute();
                DB::update('imgs')->set(array('comment_num' => DB::expr('comment_num + 1')))->where('id', '=', $pid)->execute();
                $this->request->redirect('/'. $pid. '.html');
            } else{
                $str = '';
                $this->template->registerErr = $errors = $post->errors('default/pic/pic');
                    foreach($errors as $item) {
                        $str .= $item  . '<br>';
                    }
                $this->show_message($str);
            }
        }
        $this->auto_render = false;
    }

    /**
     * 图片集合
     */
    public function action_zoom()
    {
        $this->template->pid = $pid = (int) $this->getQuery('id');
        $this->template->zoom = $zoom = trim($this->getQuery('zoom'));

        $this->template->info =  $info = ORM::factory('img')->select('imgs.*', 'u.username', 'd.disk_domain')
            ->join(array('users', 'u'))
            ->on('u.uid', '=', 'imgs.userid')
            ->join(array('img_disks', 'd'))
            ->on('d.disk_domain', '=', 'imgs.disk_id')
            ->where('imgs.id', '=', (int) $pid)->find();
        if (empty($info->picname)) {
            $this->show_message('非法访问', 0, array(), true);
        }
        $url = URL::domain();
        $picname =  $info->disk_name . '/'. $info->picname;
        $imRule = Str::changeLoad($picname, true);
        if ($zoom == 'medium') {
            $picname = $this->thumb->create($picname, 640, 640, 's');
            $imRule = Str::changeLoad($picname);
        } elseif ($zoom == 'thumb') {
            $picname = $this->thumb->create($picname, 130, 130);
            $imRule = Str::changeLoad($picname);
        }


        $this->template->picinfo = $picinfo = @getimagesize($picname);
        $this->template->picname =   $url . $imRule;
    }


    /**
     * 编辑图片
     */
    public function action_picedit()
    {
        $this->checklogin();
        $this->template->pid = $pid = (int) $this->getRequest('pid');
        $this->template->zoom = $zoom = trim($this->getQuery('zoom'));
        $this->template->info =  $info = ORM::factory('img')
            ->where('imgs.userid', '=', (int)$this->auth['uid'])
            ->where('imgs.id', '=', $pid)->find();

        if (empty($info->picname)) {
           $this->show_message('非法访问', 0, array(), true);
        }
        $url = "http://" . $info->disk_id . '.wal8.com/';

        $picname =  $info->disk_name  . '/'. $info->picname;
        $thumb = new Thumb();
        if ($zoom == 'medium') {
            $picname = $thumb->create($picname, 640, 640, 's');
        } elseif ($zoom == 'thumb') {
            $picname = $thumb->create($picname, 130, 130);
        }
        $this->template->picname =   $url . $picname;

        if ($this->isPost()) {
            $editName = trim($this->getPost('name'));
            $pid = (int) $this->getPost('pid');
            $set['custom_name'] = $editName;
            if (!empty($_FILES['newfile']['name'])) {

                $disks = ORM::factory('img_disk')->where('is_use', '=', 1)->find();
                $save_dir = ORM::factory('user', (int) $this->auth['uid'])->save_dir;
                $savePath = DOCROOT . '' . $disks->disk_name . '/' . $save_dir . '/';
                $upload = new Upload(array('size' => 2024));

                try {
                    $upload->set_path($savePath);
                    $result = $upload->save($_FILES['newfile']);

                    //$set['picname'] = $result['saveName'];
                    $set['filename'] = $result['name'];
                    $set['custom_name'] = $result['name'];
                    $set['filesize'] = $result['size'];

                    $picPath = pathinfo($info->disk_name .'/'. $info->picname);
                    $img_dir = '/s/';
                    $img_dir2 = '/thumbnails/';
                    if (!empty($this->img_size)) {
                    foreach($this->img_size as $key => $v) {
                        //标准图路径
                        $zoomPath = $picPath['dirname'] . $img_dir. $picPath['filename'] . $v ;
                        @unlink(Io::strip(DOCROOT.  $zoomPath. $picPath['extension']));
                        @unlink(Io::strip(DOCROOT.  $zoomPath . 'jpg'));
                        //缩略图路径
                        $thumbPath = $info->disk_name . $img_dir2. $picPath['filename']. $v ;
                        @unlink(Io::strip(DOCROOT . $thumbPath . $picPath['extension']));
                        @unlink(Io::strip(DOCROOT . $thumbPath . 'jpg'));
                        @unlink(Io::strip(DOCROOT . $thumbPath. 'gif'));
                    }
                    @unlink(Io::strip(DOCROOT. $info->disk_name .'/'. $info->picname));

                    $saveName = $disks->disk_name . '/' . $save_dir . '/' .$result['saveName'];
                    rename($saveName, DOCROOT. $info->disk_name .'/'. $info->picname);
                    $saveName = $disks->disk_name . '/' . $save_dir . '/' . $info->picname;
                    $url = 'http://'.$info->disk_id . '.wal8.com/';
                    $data = array(
                        'img_url' => $url . $this->thumb->create($saveName, 130, 130),
                        'add_time' => time(),
                        'uid' => $this->auth['uid']
                    );
                    $this->squid_img($data);
                    $data['img_url'] = $url . $this->thumb->create($saveName, 640, 640, 's');
                    $this->squid_img($data);
                    $data['img_url'] = $url . $this->thumb->create($saveName, 120, 120);
                    $this->squid_img($data);

                    $data['img_url'] = $url . $saveName;
                    $this->squid_img($data);
                  }
                } catch(Exception $e) {
                    $this->show_message($e->getMessage(), 0, array(), true);
                }
            }
            DB::update('imgs')->set($set)->where('id', '=', $pid)->execute();
            $sum = DB::select(DB::expr("sum(filesize) as sums"))->from('imgs')->where('userid', '=', $this->auth['uid'])->execute()->get('sums');
            DB::update('users')->set(array('use_space' => $sum))->where('uid', '=', $this->auth['uid'])->execute();
            ORM::factory('user')->upcache($this->auth['uid']);
            $links[] = array(
                'text' => '重载图片编辑',
                'href' => '/pic/picedit?pid='. $pid,
            );
            $this->show_message('修改图片处理成功', 1, $links, true);
        }
    }

    public function squid_img($data)
    {
        if (!empty($data)) {
            DB::insert('squid.reset_img_cache',array_keys($data))->values(array_values($data))->execute();
        }
    }

}
