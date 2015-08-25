<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 店铺搬家
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-21
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Shopmove extends Controller_Base {

    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->checkSpace();
        $this->checklogin();
    }

    /**
     * 首页
     *
     */
    public function action_index()
    {
        if (!empty($_FILES)) {


            $savePath = DOCROOT . 'src_csv/' . $this->auth['uid'] . '/';    // 保存目录
            $upload = new Upload(array('size' => 10240, 'ext' => array('csv')));
            $upload->set_path($savePath);

            try {
                $result = $upload->save($_FILES['upload_file']);
                $date = array($this->auth['uid'], $this->auth['username'], $result['name'], $result['saveName'], $result['size'], date('Y-m-d H:i:s'));
                $row = DB::insert('imgup_movestore',array('uid', 'uname', 'csv_file', 'src_file', 'freesize', 'upload_time'))->values($date)->execute();



           $content = $this->changeCharacter($savePath . $result['saveName']);
           //preg_match_all("/(src)=[\"|'| ]{0,}((https?\:\/\/.*?)([^>]*[^\.htm]\.(gif|jpg|bmp|png)))/i",$content, $match);
           //preg_match_all("/[\"|'| ]{0,}((https?\:\/\/[a-zA-Z0-9_\.\/]*?)([^<\>]*[^\.htm]\.(gif|jpg|bmp|png)))/i", $content, $match);
           preg_match_all("/\<img.*?src\=[\"\']+[ \t\n]*(https?\:\/\/.*?)[ \t\n]*[\"\']+[^>]*>/i", $content, $match);
           $imgArr = array_unique($match[1]);

            foreach ($imgArr as $value) {
                # 去除本站的图片地址
                if (!preg_match("/^http:\/\/[\w\.\-\_]*wal8\.com/i", $value)) {
                    DB::insert('store_imgs',array('sid', 'url', 'add_time', 'uid'))->values(array($row[0], $value, time(), $this->auth['uid']))->execute();
                }
            }

                $link[] = array(
                    'text' => '返回',
                    'href' => '/shopmove'
                );
                $this->show_message('上传' . $result['name'] .'文件成功', 1, $link);
            } catch (Exception $e) {
                $link[] = array(
                    'text' => '返回',
                    'href' => '/shopmove'
                );
                $this->show_message($e->getMessage(), 0, $link);
            }
        }
    }

    /**
     * 历史列表
     */
    public function action_list()
    {
        $select = DB::select()->from(array('imgup_movestore', 's'))
                ->where('uid', '=', $this->auth['uid'])
                ->order_by('id', 'DESC');

        $this->template->pagination = $pagination = Pagination::factory(array(
            'total_items' => count($select->execute()->as_array()),
            'items_per_page' => 6
            )
        );
        $this->template->results = $select->limit($pagination->items_per_page)
            ->offset($pagination->offset)->execute();
    }

    /**
     * 删除
     */
    public function action_del()
    {
        $id = (int) $this->getQuery('id');
        $rows = DB::select()->from('imgup_movestore')->where('id', '=', $id)->execute()->current();
        if (empty($rows)) {
            $this->show_message('文件记录不存在,删除失败');
        }

        if ($rows['uid'] != $this->auth['uid']) {
            $this->show_message('非法操作，你不能删除不属于你的CSV文件');
        }
        DB::delete('imgup_movestore')->where('id', '=', $id)->execute();
        DB::delete('store_imgs')->where('sid', '=', $id)->execute();
        $src_name = DOCROOT . 'src_csv/' . $this->auth['uid'] . '/' . $rows['src_file'];
        $dest_name = DOCROOT . 'dest_csv/' . $this->auth['uid'] . '/' . $rows['dest_file'];
        if(file_exists($src_name)){
            @unlink($src_name);
        }
        if(file_exists($dest_name)){
            @unlink($dest_name);
        }
         $link[] = array(
            'text' => '返回历史记录',
            'href' => '/shopmove/list'
        );
        $this->show_message('删除CSV文件成功', 1, $link);
        $this->auto_render = false;
    }
    # 调整字符集到utf-8.
    public function changeCharacter($filename) {
        $handle = fopen($filename,"r");
        $buffer = fread($handle,100);
        fclose($handle);
        $content = file_get_contents($filename);
        if($buffer[0] == "\xFF" && $buffer[1] == "\xFE"){
            $content = iconv("UCS-2","utf-8//IGNORE",$content);
            $encode = "UCS2";
        }else{
            $encode = mb_detect_encoding($buffer,array('GB2312','UTF-8'));
            if($encode == "EUC-CN"){
                $content = iconv("gb2312","utf-8//IGNORE",$content);
            }else if($encode!="UTF-8"){
                echo "UNknow Character。\n";
                exit();
            }
        }
        return $content;
    }

    /**
     * 空间不足。继续搬家
     */
    public function action_continue()
    {
        $id = (int) $this->getQuery('id');
        $info = DB::select()->from('imgup_movestore')->where('id', '=', $id)->where('uid', '=', $this->auth['uid'])->execute()->current();
        print_r($info);
        if ($info['status'] == 2) {
            $this->checkSpace();
            DB::update('imgup_movestore')->set(array('status' => '0'))->where('id', '=', $id)->where('uid', '=', $this->auth['uid'])->execute();
            $this->request->redirect('/shopmove/list');
        }
        $this->auto_render = false;
    }

}
