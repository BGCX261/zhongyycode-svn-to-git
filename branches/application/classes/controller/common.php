<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 公共操作类
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Common extends Controller_Base {

    /**
     * 图片验证码
     *
     */
    public function action_imgcode()
    {
        $captcha = Captcha::instance();
        exit($captcha->render());
    }

    /**
     * 下载文件
     *
     * @param  integer  $fileId
     * @throws EGP_Exception
     */
    public function action_download()
    {
        $this->checkLogin();
        $id = (int) $this->getQuery('id');
        $app = trim($this->getQuery('app'));
        $info = DB::select()->from('imgup_movestore')->where('id', '=', $id)->where('uid', '=', $this->auth['uid'])->execute()->current();

        $filename = '';
        if ($app == 'source') {
            $filename = $info['src_file'];
            $savaname = Io::strip(DOCROOT . 'src_csv/' . $this->auth['uid'] . '/' . $filename);
        } else {
            $filename = $info['dest_file'];
            $savaname = Io::strip(DOCROOT . 'dest_csv/' . $this->auth['uid'] . '/' . $filename);
        }

        if (empty($info) || !is_readable($savaname)) {
            throw new Exception('指定的文件不存在或者已经被删除');
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header('Content-Length: ' . filesize($savaname));
        header('Content-Disposition: attachment; filename=' . basename($info['csv_file']));
        readfile($savaname);
    }

    /**
     * 举报信息
     */
    public function action_report($app)
    {

        $content = trim($this->getQuery('content'));
        $item_id = (int) $this->getQuery('item_id');
        if (empty($content)) {
            echo '举报内容不能为空';
            die();
        }
        $array = array(
            'content' => $content,
            'app' => $app,
            'item_id' => $item_id,
            'add_time' => time(),
            'add_ip' => Request::$client_ip,
        );
        $result = DB::insert('report', array_keys($array))->values(array_values($array))->execute();
        if ($result[0]) {
            echo '举报内容成功，等待管理员审核，谢谢';
        } else {
            echo '举报内容失败，请联系管理员，谢谢';
        }
        die();
    }
}
