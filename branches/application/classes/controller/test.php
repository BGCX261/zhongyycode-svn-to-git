<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 测试
 */
class Controller_Test extends Controller_Base {


    public function action_index()
    {
        $this->request->redirect('/');
        $this->checkSpace();

        // 图片分类列表
        $this->template->cate_list = $cate_list =  DB::select()->from('img_categories')
            ->where('uid', '=', @$this->auth['uid'])
            ->execute()
            ->as_array();
        $img = ORM::factory('img');
        if (!empty($_FILES)) {
            // 取得硬盘目录
            $disks = ORM::factory('img_disk')->where('is_use', '=', 1)->find();
            $uid = (int) $this->getQuery('uid');

            //图片保存目录
            $save_dir = ORM::factory('user', $uid)->save_dir;
            $savePath = DOCROOT . '' . $disks->disk_name . '/' . $save_dir . '/';
            $upload = new Upload();
            $upload->set_path($savePath);
            $result = $upload->save($_FILES['Filedata']);
            $cate_id = (int) $this->getQuery('cate_id');

            $img->picname = $result['saveName'];
            $img->filename = $result['name'];
            $img->filesize = $result['size'];
            $img->userid =  $uid;
            $custom = pathinfo($result['name']);
            $img->custom_name = $custom['filename'];
            $img->disk_id = $disks->disk_domain;
            $img->cate_id = $cate_id;
            $img->disk_name = $disks->disk_name . '/' . $save_dir;
            $img->save();

            $picname = $savePath . $result['saveName'];
            $thumb = new Thumb();


            $select_width = (int) $this->getQuery('select_width', 640);
            $thumb->create($picname, 130, 130);
            $thumb->create($picname, $select_width, $select_width, 's');
            // 统计数据


            foreach($cate_list as $item) {
                $num =  $img->where('userid', '=', $uid)
                    ->where('cate_id', '=', $item['cate_id'])
                    ->count_all();
                DB::update('img_categories')->set(array('img_num' => $num))
                    ->where('uid', '=', $uid)
                    ->where('cate_id', '=', (int) $item['cate_id'])
                    ->execute();
            }
            $rows = DB::select(array('sum("filesize")', 'total_size'),array('count("userid")', 'total_num'))
                    ->from('imgs')
                    ->where('userid', '=', (int)$uid)
                    ->execute()
                    ->current();
            DB::update('users')->set(array('use_space' => $rows['total_size'],'count_img' => $rows['total_num']))
                ->where('uid', '=', $uid)
                ->execute();
            ORM::factory('user')->upcache($uid);
        }

    }

    public function action_bmp()
    {
        $source = '128919316276.jpg';
        $thumb = new Thumb();

        $thumb->create($source, 130, 130);
       // $img = $thumb->imagecreatefrombmp($source);

        $this->auto_render = false;
    }

    /**
     * 测试读取CSV
     */
    public function action_csv()
    {
        $source = 'imeelee-tabao-100924014238.csv';
        $content = Str::character($source);
        $arr = explode("\n", $content);


        foreach ($arr as  $key => $item) {

            if ($key == 0) {continue;}


                $childs = explode("\t", trim($item));
                foreach ($childs as $i => $value) {
                    $child[$i] = $this->_format($value);
                }

                $child = array_pad($child, 45, ' ');
                $child[] = '5';
                $filed = array('t_a' ,'t_b' ,'t_c' ,'t_d' ,'t_e' ,'t_f' ,'t_g' ,'t_h' ,'t_i' ,'t_j' ,'t_k','t_l' ,'t_m' ,'t_n' ,'t_o' ,'t_p' ,'t_q' ,'t_r' ,'t_s' ,'t_t' ,'t_u' ,'t_v' ,'t_w' ,'t_x' ,'t_y' ,'t_z' ,'t_aa' ,'t_ab' ,'t_ac' ,'t_ad' ,'t_ae' ,'t_af' ,'t_ag' ,'t_ah' ,'t_ai' ,'t_aj' ,'t_ak' ,'t_al' ,'t_am' ,'t_an' ,'t_ao' ,'t_ap' ,'t_aq' ,'t_ar' ,'t_as','uid' );

                $row = DB::insert('taobaos',$filed)->values($child)->execute();
                $child = array();


        }
        $this->auto_render = false;

    }

    /**
     * 生成CSV
     */
    public function action_createcsv()
    {


    }

    /**
     * 去除多余的双引号
     *
     * @param  string  $str
     * @return string
     */
    protected function _format($str)
    {


        if (!empty($str) && $str[0] == '"') $str = substr($str, 1);
        if (!empty($str) && $str[strlen($str)-1] == '"') $str = substr($str, 0, -1);
        return str_replace(array('""', "\r\n", "\n"), array('"', '', ''), $str);
    }

    /**
     * 测试cache
     */
    public function action_cache()
    {

         /* 获取网站配置变量 */
        $config = Cache::instance()->get('site_config');
        if ($config === NULL)
        {

            Cache::instance()->set('site_config', array('t' => time()), 86400);
        }
        $this->auto_render = false;

    }

    public function action_php()
    {

    }

    public function action_echoimg()
    {
        $img = 'http://album.wal8.com/images/user/user_shangchuan.gif';
        echo readfile($img);
        $this->auto_render = false;
    }

    public function action_xml()
    {
        $this->template->xml_id = '2_2';
    }


}