<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 图片专题
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-15
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Picsubject extends Controller_Base {

    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->checkSpace();
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
    }


    /**
     * 查看专题相片
     */
    public function action_view()
    {
        $this->_add_css('styles/album/topics_display.css');
        $this->template->sid = $sid  = $this->request->param('sid');

        $select = DB::select('s.*', 'users.username', 'f.sign')->from(array('specialpics', 's'))
            ->join('users')
            ->on('users.uid', '=', 's.uid')
            ->join(array('user_fields', 'f'))
            ->on('f.uid', '=', 'users.uid')
            ->where('s.sid', '=', $sid);
        $this->template->results = $results = $select->execute()->current();
        if (empty($results)) {
              $this->show_message('非法访问', 0, array() , true);
        }

        $tag = new Tags();
        $spe = ORM::factory('Specialpic');

        // 评论列表
        $select = DB::select('c.*', 'u.username', 'u.avatar')
            ->from(array('comments', 'c'))
            ->where('c.item_id', '=', $sid)
            ->where('c.app', '=', 'img_subject')
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'c.author');
        $this->template->commentList = $select->execute()->as_array();

        // 添加标签
        if ($this->isPost()) {
            $tags = trim($this->getPost('tags'));
            $sid = (int) $this->getPost('sid');
            $tags = explode(',', $tags);
            $tag->add($sid, 'img_subject', $tags);
            $this->request->redirect('/picsubject/'. $sid . '.html');
        }

        $this->template->tags = $tags = $tag->get($sid, 'img_subject');
        $this->template->nextSpecial =  $nextSpecial = $spe->nextSpecial($sid, $results['uid']);
        $this->template->preSpecial =  $preSpecial = $spe->preSpecial($sid, $results['uid']);
        $this->template->newSpecial =  $newSpecial = $spe->newSpecial($results['uid']);
        $this->template->pageTitle =  $results['title'];
         // 更新访问量
        DB::update('users')->set(array('visit' => DB::expr("visit + 1")))->where('uid', '=', $results['uid'])->execute();
        DB::update('specialpics')->set(array('click' => DB::expr('click + 1')))->where('sid', '=', $sid)->execute();


    }


    /**
     * 专题心情操作
     */
    public function action_mood()
    {

        $item_id = (int) $this->getQuery('item_id');
        $do = trim($this->getQuery('app', 'support'));
        if (empty($item_id)) {
            echo '非法操作';
            die();
        }
        $moodSession = Session::instance()->get('spec_item_id' . $item_id, false);
        if(empty($moodSession)) {
            $arr = array('spec_item_id' => $item_id, 'app' => $do);
            Session::instance()->set('spec_item_id' . $item_id, $arr);
            DB::update('specialpics')->set(array($do => DB::expr(" $do + 1")))->where('sid', '=', $item_id)->execute();
        } else {
            echo '您已经赞过或者鄙视过这张图片了，请不要重复。谢谢!';
        }

        $this->auto_render = false;
    }

    /**
     * 专题评论操作
     */
     public function action_comment()
     {
        $comment = ORM::factory('comment');
        if($this->isPost()) {
             $sid = (int) $this->getPost('sid');
             $content = trim($this->getPost('content'));
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('sid', 'not_empty')
                ->rule('content', 'not_empty');
            if (!$this->auth) {
                $post = $post->rule('captcha', 'not_empty')->rule('captcha','Captcha::valid');
             }

            if ($post->check()) {
                $comment->item_id = $sid;
                $comment->app = 'img_subject';
                $comment->author = $this->auth['uid'];
                $comment->author_ip = Request::$client_ip;
                $comment->anonymous = (int) $this->getPost('anonymous');
                $comment->values($post);
                $comment->save();
                DB::update('specialpics')->set(array('comment' => DB::expr('comment + 1')))->where('sid', '=', $sid)->execute();
                $this->request->redirect('/picsubject/'. $sid . '.html#comment_list');
            } else{
                $errors = $post->errors('default/pic/pic');
                $this->show_message($errors);
            }
        }
        $this->auto_render = false;
     }

    /**
     *  专题评论回复
     *
     */
    public function action_replay()
    {
        $this->checklogin();
        $comment = ORM::factory('comment');
        if($this->isPost()) {
             $cid = (int) $this->getPost('replay_cid');
             $sid = (int) $this->getPost('sid');
             $content = trim($this->getPost('content'));

            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('sid', 'not_empty')
                ->rule('content', 'not_empty');
            // 专题信息
            $info = DB::select()
                    ->from(array('specialpics', 's'))
                    ->where('s.sid', '=', $sid)
                    ->execute()
                    ->current();
            if($this->auth['uid'] != $info['uid']) {
                    $this->show_message('你不能回复不是你的专题的评论', 0, array(), true);
            }

            if ($post->check()) {

                $comment->item_id = $sid;
                $comment->quote_id = $cid;
                $comment->app = 'img_subject';
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
                $name = (empty($rows['username'])) ? '匿名' : $rows['username'];

                $arr = array(
                    'quote_id' => $sid,
                    'quote' => '<i><b>回复 ' . $name . ' 的内容:' . $rows['content'] . '</b></i>',
                );
                DB::update('comments')->set($arr)->where('cid', '=', $comment->cid)->execute();
                $count = DB::select(DB::expr('COUNT(*) AS count'))
                    ->from('comments')
                    ->where('quote_id', '=', $sid)
                    ->execute()
                    ->get('count');
                DB::update('comments')->set(array('replies' => $count))->where('cid', '=', $cid)->execute();
                DB::update('specialpics')->set(array('comment' => DB::expr('comment + 1')))->where('sid', '=', $sid)->execute();
                $this->request->redirect('/picsubject/'. $sid . '.html#comment_list');
            } else{
                $errors = $post->errors('default/pic/pic');
                $this->show_message($errors);
            }
        }
        $this->auto_render = false;
    }


    /**
     * 图片专题列表
     *
     */
    public function action_list()
    {
        $this->_add_script('scripts/copy.js');
        $this->checklogin();
        $this->template->pageTitle = $this->auth['username'] . ' 图片专题管理';
        $this->_add_css('styles/album/topics_manage.css');
        $count = DB::select(DB::expr('COUNT(*) AS count'))
            ->from('specialpics')
            ->where('uid', '=', $this->auth['uid'])
            ->execute()
            ->get('count');
        $this->template->pagination = $pagination = Pagination::factory(array(
            'total_items' => $count,
            )
        );
        $this->template->results = DB::select()->from('specialpics')
            ->order_by('sid','DESC')
            ->where('uid', '=', $this->auth['uid'])
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)->execute();
    }

    /**
     * 添加专题
     *
     */
    public function action_add()
    {
        $this->checklogin();
        $this->template->pageTitle = '添加专题';
        $this->_add_css('styles/album/add_topics.css');
        $this->_add_script('scripts/copy.js');
        $specialpic = ORM::factory('specialpic');
        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('title', 'not_empty')
                ->rule('content', 'not_empty');
            if ($post->check()) {
                $specialpic->values($post);
                $specialpic->uid = $this->auth['uid'];
                $specialpic->save();
                $specialpic->sid;
                // 添加专题标签
                $tag = new Tags();
                $tags = trim($this->getPost('tags'));
                $tags = explode(' ', $tags);
                $tag->add($specialpic->sid, 'img_subject', $tags, $this->auth['uid']);

                $links[] = array(
                    'text' => '返回专题列表',
                    'href' => '/picsubject/list',
                );
                $this->show_message('发现专题图片操作成功。', 1, $links, true);
            } else {
                // 校验失败，获得错误提示
                $str = '';
                $this->template->registerErr = $errors = $post->errors('default/pic/pic');
                    foreach($errors as $item) {
                        $str .= $item  . '<br>';
                    }
                $this->show_message($str);
            }
        }

        $pid = $this->getQuery('id');
        $arr = explode('-',$pid);
        $select = DB::select('imgs.picname','imgs.userid', 'imgs.custom_name', 'd.disk_domain', 'd.disk_name', array('imgs.disk_name', 'img_dir'))
            ->from('imgs')
            ->join(array('img_disks', 'd'))
            ->on('d.disk_domain', '=', 'imgs.disk_id')
            ->where('imgs.id', 'in', $arr)
            ->where('imgs.userid', '=', $this->auth['uid']);

        $rows = $select->execute()->as_array();
        $str = '';

        foreach ($rows as $item) {
              $temp_img = $item['img_dir'] .'/' . $item['picname'];
                list($width, $height) = getimagesize($temp_img);

                if ($width >= 640 ) {
                    $temp_img = $this->thumb->create($temp_img, 640, 640, 's');
                    $temp_img = Str::changeLoad($temp_img, false);
                } else {
                    $temp_img = Str::changeLoad($temp_img, true);
                }
            $str .= '<p>' . "<img src=\"" . URL::domain() . $temp_img  . '" alt="' .$item['custom_name'] . '"/></p><p style="text-align:center;">'. $item['custom_name'] . '</p>';

        }
        $this->template->content = $str;
    }

    /**
     * 编辑专题
     */
    public function action_edit()
    {
        $this->checklogin();
        $this->template->pageTitle = '编辑专题';
        $this->_add_css('styles/album/add_topics.css');
        $this->_add_script('scripts/copy.js');
        $sid = (int) $this->getQuery('sid');
        $specialpic = ORM::factory('specialpic');
        $tag = new Tags();

        if ($this->isPost()) {
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('title', 'not_empty')
                ->rule('content', 'not_empty');
            if ($post->check()) {

                $set = array(
                    'title' => trim($this->getPost('title')),
                    'content' => trim($this->getPost('content'))
                );
                $sid = (int) $this->getPost('sid');
                DB::update('specialpics')->set($set)->where('sid', '=', $sid)->where('uid', '=', $this->auth['uid'])->execute();
                $tags = $this->getPost('tags');
                $tags = explode(' ', $tags);

                $tag->set($sid, 'img_subject', $tags, $this->auth['uid']);
                $links[] = array(
                    'text' => '返回专题列表',
                    'href' => '/picsubject/list',
                );
                $this->show_message('编辑专题操作成功。', 1, $links);
            }
        }
        $this->template->tags = $tags = $tag->get($sid, 'img_subject', $this->auth['uid']);
        $this->template->info = ORM::factory('specialpic')->where('sid', '=', $sid)->where('uid', '=', $this->auth['uid'])->find();

    }

    /**
     * 删除专题
     *
     */
    public function action_delsubject()
    {
        $this->checklogin();
        $sid = (int) $this->getQuery('sid');
        if (empty($sid)) {
            $this->show_message('请选择要删除的专题');
        }
        DB::delete('specialpics')->where('sid', '=', $sid)->execute();
        $go_url = '/picsubject/list';
        $tag = new Tags();
        $tag->del($sid, 'img_subject');
        $this->request->redirect($go_url);
        $this->auto_render = false;
    }

    /**
     * 设置专题共享
     */
    public function action_picshare()
    {

        $this->checklogin();
        if ($this->isPost()) {
            $sid = $this->getPost('sid');
            if (!is_array($id)) {
                $id = array($id);
            }
            foreach ($id as $value) {
                DB::update('specialpics')->set(array('is_share' => 1))->where('sid', '=', $value)->execute();
            }
            $url = '';
            $cate_id = $this->getPost('cate_id');
            if ($cate_id > 0) {
                $url .= '?cate_id=' .$cate_id;
            }
            $this->request->redirect('/pic/list' .$url);
        }
        $this->auto_render = false;
    }

}
