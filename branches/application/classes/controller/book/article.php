<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台框架
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-14
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Book_Article extends Controller_Book_Base {

    /**
     * 图书分类obj
     */
    public $cate = '';

    /**
     * 标签obj
     */
    public $tag = '';

    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->_add_css('styles/album/public.css');
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
        $this->cate = new Bookcategory();
        $this->tag = new Tags();
    }

    /**
     * 验证登录
     */
    public function checkLogin()
    {
        if(!$this->auth){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links, true);
        }
    }
    /*
     * 首页
     */
    public function action_index()
    {

    }

    /**
     * 图书管理列表
     */
    public function action_list()
    {
        $this->checkLogin();
        $this->_add_css('styles/album/book_manage.css');
        $this->template->pageTitle = '我的图书馆管理';

        $select = DB::select('a.*', 'cate.cate_name')->from(array('articles', 'a'))
            ->join(array('article_categories', 'cate'), 'LEFT')
            ->on('cate.cate_id', '=', 'a.cate_id')
            ->where('a.uid', '=', $this->auth['uid'])
            ->where('a.recycle', '=', 0)
            ->order_by('a.article_id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('a.title', 'like', "%$keyword%")
                ->or_where('a.uid', '=', $keyword);
        }
        $this->template->cate_id = $cate_id = (int) $this->getQuery('cate_id', 0);
        if ($cate_id > 0) {
            $select->where('a.cate_id', '=', $cate_id);
        }

       $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));

    }


    /**
     * 文章阅读页
     */
    public function action_reading()
    {

        $this->_add_css('styles/album/reading.css');
        $this->template->aid = $aid = $this->request->param('aid');;
        $article = ORM::factory('article');
        $select = DB::select('a.*', 'users.username', 'users.avatar', 'f.sign')->from(array('articles', 'a'))
            ->join('users')
            ->on('users.uid', '=', 'a.uid')
            ->join(array('user_fields', 'f'),'LEFT')
            ->on('f.uid', '=', 'users.uid')
            ->where('a.article_id', '=', $aid);
        $this->template->info = $info = $select->execute()->current();
        if (empty($info)) {
            $this->show_message('非法访问', 0, array() , true);
        }

        $this->template->channel_top = $article->where('uid', '=', $info['uid'])->where('channel_top', '=', 1)->limit(10)->order_by('article_id', 'DESC')->find_all();
        $this->template->tags = $tags = $this->tag->get(0, 'article', $info['uid']);
        $this->template->getHotTags = $getHotTags = $this->tag->getHotTags('article');
        $this->template->preArticle = $article->preArticle($aid, $info['uid']);  // 上一页
        $this->template->nextArticle = $article->nextArticle($aid, $info['uid']);  // 下一页

        // 评论
        $select = DB::select('c.*', 'u.username', 'u.avatar')
            ->from(array('comments', 'c'))
            ->where('c.item_id', '=', $aid)
            ->where('c.app', '=', 'article')
            ->where('c.is_show', '=', '1')
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'c.author');
        $this->template->commentList = $select->execute()->as_array();
        $this->template->pageTitle = $info['title'];
        DB::update('articles')->set(array('views' => DB::expr('views + 1')))->where('article_id', '=', $aid)->execute();

    }

    /**
     * 图书添加
     */
    public function action_add()
    {
        $this->checkLogin();
        $this->_add_css('styles/album/edit_articles.css');
        $this->template->pageTitle = '添加图书';
        $this->template->categories = $categories = $this->cate->getCates($this->auth['uid']);

        $article = ORM::factory('article');
        if ($this->isPost()) {
            //数据验证

            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('title', 'not_empty')
                ->rule('cate_id', 'not_empty')
                ->rule('content', 'not_empty');
            if ($post->check()) {

                preg_match_all("/(src)=[\"|'| ]{0,}((https?\:\/\/.*?)([^>]*[^\.htm]\.(gif|jpg|bmp|png)))/i", $this->getPost('content'), $match);
                $img = preg_replace("/^http:\/\/[\w\.\-\_]*wal8\.com\//i", '', $match[2][0]);
                $article->thumb = $img;
                $article->excerpt = Str::slice(Str::strip_html($this->getPost('content')), 30 , '...');
                $article->uid = $this->auth['uid'];
                $article->userip = Request::$client_ip;
                $aid = $article->values($post)->save();

                $tags = trim($this->getPost('tags'));
                $tags = explode(' ', $tags);
                $this->tag->add($aid, 'article', $tags, $this->auth['uid']);

                $select = DB::select(DB::expr("count(0)"))->from('articles')->where('cate_id', '=', $post['cate_id']);
                DB::update('article_categories')->set(array('art_num' => $select))->where('cate_id', '=', $post['cate_id'])->execute();

                $links[] = array(
                    'text' => '图书管理',
                    'href' => '/book/article/list',
                );
                $this->show_message('添加图书成功', 1, $links, true);
            } else {
                $this->show_message($post->errors('book/article'));
            }
        }
    }

    /**
     * 匹配图片
     */
    public function action_getimg()
    {
        $content = ($this->getPost('content'));

        preg_match_all("/[\"|'| ]{0,}((https?\:\/\/[a-zA-Z0-9_\.\/]*?)([^<\>]*[^\.htm]\.(gif|jpg|bmp|png)))/i", $content, $match);
        $arr = array();
        $imgArr = array_unique($match[1]);
        foreach ($imgArr as $value) {
            # 去除本站的图片地址
            if (!preg_match("/^http:\/\/[\w\.\-\_]*wal8\.com/i", $value)) {
               $arr[] = $value;
            }
        }

       echo implode(',', $arr);
       $this->auto_render = false;
    }
    /**
     * 自动远程保存图片
     *
     */
     public function action_saveimg()
     {

        $source = $this->getQuery('src');
        if(!URL::ping($source)) {
            echo $source;
            die();
        }
        $savePath =  "books_img/" . $this->auth['uid'] . '/';
        Io::mkdir(DOCROOT . $savePath);
        $data = @file_get_contents($source);
        $filename = basename($source);
        $extension = strtolower(strtolower(substr(strrchr($filename, '.'), 1)));

        $saveName =  str_replace('.', '', microtime(true)) . '.'. $extension; // 保存的文件名
        $filename = $savePath . $saveName;


        $filesize = @file_put_contents(DOCROOT .$filename, $data); //保存文件,返回文件的size
        if ($filesize == 0) { //保存失败
            @unlink($savefile);
            throw new Exception('文件保存到本地目录时失败');
        }
        list($w, $h, $t) = getimagesize(DOCROOT .$filename);
        $filetype = image_type_to_mime_type($t);
        if (!preg_match('/^image\/.+/i', $filetype)) {
            throw new Exception('转存文件并非有效的图片文件');
        }
        $filename = $this->thumb->create($filename, 640, 640);
        echo URL::domain() . $filename;
        $this->auto_render = false;
     }

    /**
     * 编辑内容
     */
    public function action_edit()
    {
        $this->checkLogin();
        $this->_add_css('styles/album/edit_articles.css');
        $this->template->pageTitle = '编辑图书内容';
        $tag = new Tags();
        $article = ORM::factory('article');

        $this->template->aid = $aid = (int) $this->getQuery('aid');
        $this->template->categories = $categories = $this->cate->getCates($this->auth['uid']);
        $this->template->info = $info = $article->where('article_id', '=', $aid)->find();
        $tags = $tag->get($aid, 'article',$this->auth['uid']);
        $this->template->tags = implode(' ', $tags);

        if ($this->isPost()) {
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('title', 'not_empty')
                ->rule('cate_id', 'not_empty')
                ->rule('content', 'not_empty');

            if ($post->check()) {
                $aid = (int) $this->getPost('aid');
                $set = array(
                    'title' => trim($this->getPost('title')),
                    'cate_id' => (int) $this->getPost('cate_id'),
                    'content' => trim($this->getPost('content')),
                );
                if ($this->auth['uid'] != $info->uid) {
                    $this->show_message('你不能编辑不是你的文章', 0, $array, true);
                }

                DB::update('articles')->set($set)->where('article_id', '=', $aid)->execute();

                if ($info->cate_id != $set['cate_id']) {
                    // 修改原图书分类文章数
                    $select = DB::select(DB::expr("count(0)"))->from('articles')->where('cate_id', '=', $info->cate_id);
                    DB::update('article_categories')->set(array('art_num' => $select))->where('cate_id', '=', $info->cate_id)->execute();
                }
                // 修改图书分类文章数
                $select = DB::select(DB::expr("count(0)"))->from('articles')->where('cate_id', '=', $set['cate_id']);
                DB::update('article_categories')->set(array('art_num' => $select))->where('cate_id', '=', $set['cate_id'])->execute();
                $tags = trim($this->getPost('tags'));
                $tags = explode(' ', $tags);
                $this->tag->set($aid, 'article', $tags, $this->auth['uid']);
                $links[] = array(
                    'text' => '图书管理',
                    'href' => '/book/article/list',
                );
                $this->show_message('编辑图书文章成功', 1, $links, true);
            } else {
                $this->show_message($post->errors('book/article'));
            }
        }
    }

    /**
     * 把文章移到回收站
     */
    public function action_recycle()
    {
        $this->checkLogin();
        $article = ORM::factory('article');
        $aid = (int) $this->getQuery('aid');
        $recycle = (int) $this->getQuery('recycle');

        $info = $article->where('article_id', '=', $aid)->find();
        if ($this->auth['uid'] != $info->uid) {
            $this->show_message('你不能操作不是你的文章', 0, array(), true);
        }
        DB::update('articles')->set(array('recycle'=> $recycle))->where('article_id', '=', $aid)->execute();

        $this->request->redirect('/book/article/list');
        $this->auto_render = false;
    }

    /**
     * 回收站文章列表
     */
    public function action_recyclelist()
    {
        $this->checkLogin();
        $this->_add_css('styles/album/book_manage.css');
        $this->template->pageTitle = '我的图书馆管理';

        $select = DB::select('a.*', 'cate.cate_name')->from(array('articles', 'a'))
            ->join(array('article_categories', 'cate'), 'LEFT')
            ->on('cate.cate_id', '=', 'a.cate_id')
            ->where('a.uid', '=', $this->auth['uid'])
            ->where('a.recycle', '=', 1)
            ->order_by('a.article_id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {

            $select->where('a.title', 'like', "%$keyword%")
                ->or_where('a.uid', '=', $keyword);
        }
        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();
    }

    /**
     * 删除图书
     */
    public function action_del()
    {
        $aid = (int) $this->getQuery('aid');
        $info = ORM::factory('article')->where('article_id','=', $aid)->find();
        if($info->uid != $this->auth['uid']) {
            $this->show_message('非法操作，你不能删除不是你的图书');
        } else {
            DB::delete('articles')->where('article_id','=', $aid)->execute();
            // 修改原图书分类文章数
            $select = DB::select(DB::expr("count(0)"))->from('articles')->where('cate_id', '=', $info->cate_id);
            DB::update('article_categories')->set(array('art_num' => $select))->where('cate_id', '=', $info->cate_id)->execute();
            $this->request->redirect('/book/article/list');

        }

    }

    /**
     * 图书评论操作
     */
     public function action_comment()
     {
        $comment = ORM::factory('comment');
        if($this->isPost()) {
             $aid = (int) $this->getPost('aid');
             $content = trim($this->getPost('content'));
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('aid', 'not_empty')
                ->rule('content', 'not_empty');
            if (!$this->auth) {
                $post = $post->rule('captcha', 'not_empty')->rule('captcha','Captcha::valid');
            }

            if ($post->check()) {
                $comment->item_id = $aid;
                $comment->app = 'article';
                $comment->author = $this->auth['uid'];
                $comment->author_ip = Request::$client_ip;
                $comment->anonymous = (int) $this->getPost('anonymous');
                $comment->values($post);
                $comment->save();
                DB::update('articles')->set(array('comments' => DB::expr('comments + 1')))->where('article_id', '=', $aid)->execute();
                //$this->show_message('评论成功', 1, array(), true);
                $this->request->redirect('/articles/'. $aid .'.html');
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
     * 图书评论回复
     *
     */
    public function action_replay()
    {
        $this->checkLogin();
        $comment = ORM::factory('comment');
        if($this->isPost()) {
             $replay_cid = (int) $this->getPost('replay_cid');
             $aid = (int) $this->getPost('aid');
             $content = trim($this->getPost('content'));
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('aid', 'not_empty')
                ->rule('content', 'not_empty');
            // 文章信息
            $info = DB::select()
                    ->from(array('articles', 'a'))
                    ->where('a.article_id', '=', $aid)
                    ->execute()
                    ->current();
            if($this->auth['uid'] != $info['uid']) {
                    $this->show_message('你不能回复不是你的图书的评论');
            }

            if ($post->check()) {
                $comment->item_id = $aid;
                $comment->quote_id = $replay_cid;
                $comment->app = 'article';
                $comment->author = $this->auth['uid'];
                $comment->author_ip = Request::$client_ip;
                $comment->values($post);
                $comment->save();

                $rows = DB::select('content', 'u.username')
                    ->from(array('comments', 'c'))
                    ->where('cid', '=', $replay_cid)
                    ->join(array('users', 'u'), '')
                    ->on('u.uid', '=', 'c.author')
                    ->execute()
                    ->current();
                $arr = array(
                    'quote_id' => $replay_cid,
                    'quote' => '&nbsp;&nbsp;&nbsp;&nbsp;<i><b>回复 ' . $rows['username'] . ' 的内容:' . $rows['content'] . '</b></i>',
                );
                DB::update('comments')->set($arr)->where('cid', '=', $comment->cid)->execute();
                $count = DB::select(DB::expr('COUNT(*) AS count'))
                    ->from('comments')
                    ->where('quote_id', '=', $replay_cid)
                    ->execute()
                    ->get('count');
                DB::update('comments')->set(array('replies' => $count))->where('cid', '=', $replay_cid)->execute();
                DB::update('articles')->set(array('comments' => DB::expr('comments + 1')))->where('article_id', '=', $aid)->execute();
                $this->request->redirect('/articles/'. $aid. '.html');
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
     * 设置图书状态
     */
    public function action_setStat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $id = (int) $this->getQuery('article_id');

        DB::update('articles')->set(array($type => $val))->where('article_id', '=', $id)->where('uid', '=', $this->auth['uid'])->execute();
        $this->auto_render = false;
    }
}
