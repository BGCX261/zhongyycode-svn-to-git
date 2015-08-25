<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 积分任务
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-21
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Job extends Controller_Base {

    /**
     * 初始化
     *
     */
    public function before()
    {
        parent::before();
        if(!$this->auth){
            $links[] = array(
                'text' => '去登录',
                'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
            );
            $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
        }
    }

    /**
     * 首页
     *
     */
    public function action_index()
    {
        $select = DB::select()->from('imgup_docs')
            ->limit(1);
        $select->where('id', '=', 20);
        $this->template->job_content = $select->execute()->current();
        $select = DB::select()->from('imgup_job')
                    ->where('uid', '=', $this->auth['uid'])
                    ->order_by('id', 'DESC');
        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
    }

    /**
     * 提交积分任务
     */
    public function action_sumbit()
    {
        if ($this->isPost()) {
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('job_title', 'not_empty')
                ->rule('job_url', 'not_empty');
           if ($post->check()) {
                $job_title = trim($this->getPost('job_title'));
                $job_url = trim($this->getPost('job_url'));

                if(!eregi('^https?://',$job_url)){
                    $job_url='http://'.$job_url;
                }
                $rows = DB::select()->from('imgup_job')
                    ->where('title', '=', $job_title)
                    ->where('url', '=', $job_url)
                    ->execute()->current();

                if (!empty($rows)) {
                    $note = '';
                    if ($rows['uid'] != $this->auth['uid']) {
                        $note .= '此帖已被其他会员提交,<br />';
                    }
                    $note .='请勿重复提交任务';
                    $this->show_message($note, 0, array(), true, 10000);
                }
                $date = array(
                    'uid' => $this->auth['uid'],
                    'uname' => $this->auth['username'],
                    'submit_date' => date('Y-m-d H:i:s'),
                    'title' => $job_title,
                    'url' => $job_url
                );
                DB::insert('imgup_job',array_keys($date))->values(array_values($date))->execute();
                $links[] = array(
                    'text' => '查看任务列表',
                    'href' => '/job#list',
                );
                $this->show_message('提交任务成功', 1, $links, true);

           } else {
                $this->show_message($post->errors(''));
           }
        }
    }


}
