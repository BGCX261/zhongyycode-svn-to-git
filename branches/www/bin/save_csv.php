<?php
 #
 # 生成新的CSV文件
 # @package    Controller
 # @author     zhong(小钟) <regulusyun@gmail.com>
 # @copyright  Copyright (c) 2010-11-11
 # @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 #
require('outside.php');

# 取出下载完图片csv文件
$info = DB::select()->from('imgup_movestore')->where('status', '=', 5)->order_by('id', 'DESC')->limit(1)->execute()->current();

# 获取config信息
$config = DB::select('id','disk_domain', 'disk_name')->from('img_disks')->where('is_use', '=', 1)->execute()->current();
$disk_id = $config['disk_domain'];
$disk_name = $config['disk_name'];

if (!empty($info)) {
        $info['id'] = (int) $info['id'];
        $info['uid'] = (int) $info['uid'];

        $save_dir = ORM::factory('user', $info['uid'])->save_dir;

        $csvFile = 'src_csv/'. $info['uid'] . '/' . $info['src_file'];

        $url = 'http://' . $disk_id . '.wal8.com/' . $disk_name . '/' . $save_dir  . '/';
        $savePath = 'dest_csv/' . $info['uid'] . '/';

        $saveFilename = time() . '_' . rand() . '.csv';
        # 创建目录
        Io::mkdir('../'. $savePath);
        Io::mkdir('../'.$disk_name . '/' . $movestore['uid'] . '/');

        $content = changeCharacter('../' .$csvFile);


        #搬家完毕的图片
        $list = DB::select('m.url', array('imgs.disk_id', 'disk_domain'), 'imgs.userid', 'imgs.picname', array('imgs.disk_name', 'img_dir'))
            ->from(array('store_imgs', 'm'))
            ->join('imgs')->on('imgs.id', '=', 'm.img_id')
            ->where('m.status', '=', '1')
            ->where('m.sid', '=', $info['id'])
            ->execute()->as_array();

        # 存在搬家完毕的图片生成新的CSV文件,不然就改变状态为3即该文件不存在图片或者该文件的图片不能访问
        if (!empty($list)) {
            foreach ($list as $item) {
                $url = "http://" . $item['disk_domain'] . '.wal8.com/' . $item['img_dir'] . '/' . $item['picname'];
                $content = str_replace($item['url'], $url, $content);
                #DB::delete('store_imgs')->where('sid', '=', $completeStore['id'])->where('status', '=', '1')
                #    ->where('img_id', '=', $item['id']);

            }

            $content=iconv("utf-8","UCS-2LE",$content);
            @file_put_contents( '../'. $savePath . $saveFilename, $content);
            //file_put_contents('../'. $savePath . $saveFilename, "\xFF\xFE" . mb_convert_encoding($content, 'UTF-16LE', 'UTF-8'));



            DB::update('imgup_movestore')->set(array('status' => 1, 'finish_time' => date('Y-m-d H:i:s'), 'dest_file' => $saveFilename))->where('id', '=', $info['id'])->execute();
        } else {
            #改变不存在的图片
            DB::update('imgup_movestore')->set(array('status' => '3'))->where('id', '=', $info['id'])->execute();

        }
        //echo 'no job';
        die();


}


# 调整字符集到utf-8.
function changeCharacter($filename) {
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
function url_ping($url)
{
    $headers = @get_headers($url);
    if (isset($headers[0])) {
        preg_match('/ (\d{3}) /', $headers[0], $matches);
        if (isset($matches[1]) && $matches[1] < 400) {
            return true;
        }
    }
    return false;
}


function mkdirs($dir, $mode = 0777)
{
    $dir = preg_replace('/[\\\\\/]+/', DIRECTORY_SEPARATOR, (string) $dir);;

    if ( ! is_dir($dir))
    {
        $mk = @mkdir($dir, 0777, TRUE);
        if ($mk === FALSE)
        {
            return FALSE;
        }
    }

    return $dir;
}

die();
?>