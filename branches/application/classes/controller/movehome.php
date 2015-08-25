<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 产品搬家
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-21
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Movehome extends Controller_Base {

    /**
     * 控制器方法执行前操作
     *
     */
    public function before()
    {
        parent::before();
        $this->checkSpace();
        if(!$this->auth){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
        }
    }

    /**
     * 产品搬家
     *
     */
    public function action_index()
    {
        if ($this->isPost()) {
            $title = trim($this->getPost('title'));
            $source = trim($this->getPost('source'));
            $content = trim($this->getPost('code'));

            $result = DB::insert('imgup_moveitem', array('uid','title', 'src_content', 'content', 'update_time'))->values(array($this->auth['uid'], $title, $source, $content, date('Y-m-d H:i:s')))->execute();
            ORM::factory('user')->upcache($this->auth['uid']); //更新缓存
            Session::instance()->delete('movehome_id');
            $this->request->redirect('/movehome?id='. $result[0]);
        }
        $id = (int) $this->getQuery('id');
        $this->template->info = $info = DB::select()->from('imgup_moveitem')->where('id', '=', $id)->execute()->current();

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

        $title = trim($this->getQuery('title'));
        $data = @file_get_contents($source);
        $filename = basename($source);
        $extension = strtolower(strtolower(substr(strrchr($filename, '.'), 1)));

        $saveName =  str_replace('.', '', microtime(true)); // 保存的文件名
        $disk = ORM::factory('img_disk')->where('is_use', '=', 1)->find();
        $save_dir = ORM::factory('user', $this->auth['uid'])->save_dir;
        $savefile =  Io::strip(Io::mkdir(DOCROOT . $disk->disk_name .'/'. $save_dir) . '/' . $saveName . ".$extension");

        $filesize = @file_put_contents($savefile, $data); //保存文件,返回文件的size


        if ($filesize == 0) { //保存失败
            @unlink($savefile);
           throw new Exception('文件保存到本地目录时失败');

        }
        list($w, $h, $t,) = getimagesize($savefile);

        $filetype = image_type_to_mime_type($t);
        if (!preg_match('/^image\/.+/i', $filetype)) {
            throw new Exception('转存文件并非有效的图片文件');
        }

        $category = ORM::factory('img_category')->where('cate_name', '=', '产品搬家')->where('uid', '=', $this->auth['uid'])->find();
        $cate = new Category();
        if (empty($category->cate_name)){
            $cate_id = $cate->add(array('cate_name' => '产品搬家', 'uid' => $this->auth['uid']));
        } else {
            $cate_id = $category->cate_id;
        }
        $movehomeSession = Session::instance()->get('movehome_id', false);

        if (!empty($title)) {
            if(empty($movehomeSession)) {
                $cate_id = $cate->add(array('cate_name' => $title , 'uid' => $this->auth['uid'], 'parent_id' => $cate_id));
                Session::instance()->set('movehome_id', $cate_id);
            } else {
                $cate_id = $movehomeSession;
            }
        }
        $img = ORM::factory('img');
        $img->picname = $saveName . ".$extension";
        $img->filename = $filename;
        $img->filesize = $filesize;
        $img->userid = $this->auth['uid'];
        $img->cate_id = $cate_id;
        $img->disk_id = $disk->disk_domain;
        $img->disk_name = $disk->disk_name . '/' . $save_dir;
        $img->custom_name = $saveName;
        $img->save();
        $url = "http://" . $disk->disk_domain . '.wal8.com/' . $disk->disk_name . '/' . $save_dir . '/' . $saveName . ".$extension";

        // 统计数据
        $num =  $img->where('userid', '=', $this->auth['uid'])
            ->where('cate_id', '=', $cate_id)
            ->count_all();
        DB::update('img_categories')->set(array('img_num' => $num))
            ->where('uid', '=', $this->auth['uid'])
            ->where('cate_id', '=', $cate_id)
            ->execute();

        $rows = DB::select(array('sum("filesize")', 'total_size'),array('count("userid")', 'total_num'))
                ->from('imgs')
                ->where('userid', '=', $this->auth['uid'])
                ->execute()
                ->current();
        DB::update('users')->set(array('use_space' => $rows['total_size'],'count_img' => $rows['total_num']))
            ->where('uid', '=', $this->auth['uid'])
            ->execute();

        $result = array(
            'status' => true,
            'source' => $source,
            'url' => $url,
        );
        echo $url;
        $this->auto_render = false;
     }

    /**
     * 搬家历史记录
     */
    public function action_list()
    {
        $select = DB::select('m.*')->from(array('imgup_moveitem', 'm'))
            ->where('uid', '=', $this->auth['uid'])
            ->order_by('m.id', 'DESC');
        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 2));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();
    }

    /**
     * 删除记录
     */
    public function action_del()
    {
        $id = (int) $this->getQuery('id');
        DB::delete('imgup_moveitem')->where('id', '=', $id)->where('uid', '=', $this->auth['uid'])->execute();
       $this->request->redirect('/movehome/list');
    }

    /**
     * 匹配图片
     */
    public function action_getimg()
    {
        $content = trim($this->getPost('content'));
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


}
