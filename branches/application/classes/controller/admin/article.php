<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台图书文章列表
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Article extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('books.list')) {
            $this->show_message('对不起，您没有权限执行该操作' );
        }
        $this->template->layout = array(
            'title' => '图书馆管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/article/list',
                    'text' => '图书列表',
                ),

            ),
            'current' => $this->request->action
        );
    }

    /*
     * 首页
     */
    public function action_list()
    {

         $this->template->description = '<ul>
<li>首页置顶：<img style="cursor: pointer;" src="/images/yes.gif">表示在首页显示</li>
<li>美文推荐：<img style="cursor: pointer;" src="/images/yes.gif">表示为美文推荐，如需要在图书馆首页显示  也需要“首页置顶”</li>
<li>最新文章：<img style="cursor: pointer;" src="/images/yes.gif">表示为最新文章，如需要在图书馆首页显示  也需要“首页置顶”</li>
<li>热门文章：<img style="cursor: pointer;" src="/images/yes.gif">表示为热门文章，如需要在图书馆首页显示  也需要“首页置顶”</li>
</ul>';
        $select = DB::select('a.*', 'u.username')->from(array('articles', 'a'))
            ->join(array('users', 'u'), 'LEFT')
            ->on('u.uid', '=', 'a.uid')
            ->order_by('a.article_id','DESC');
        $this->template->keyword = $keyword = trim($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('a.title', 'like', "%$keyword%");
        }
        // 分类
        $this->template->cate_id = $cate_id = (int)$this->getQuery('cate_id');
        if ($cate_id > 0) {
            $select->where('a.cate_id', '=', $cate_id);
        }

        $this->template->username = $username = trim($this->getQuery('username'));
        if (!empty($username)) {

            $select->where('u.username', 'like', "%$username%")
                ->or_where('u.uid', '=', $username);
        }

        // 美文推荐
        $this->template->is_recommend = $is_recommend = (int) $this->getQuery('is_recommend', 0);
        if ($is_recommend) {
            $select->where('a.is_recommend', '=',1);
        }
        $this->template->index_top = $index_top = (int) $this->getQuery('index_top', 0);
        if ($index_top) {
            $select->where('a.index_top', '=',1);
        }
        $this->template->is_hot = $is_hot = (int) $this->getQuery('is_hot', 0);
        if ($is_hot) {
            $select->where('a.is_hot', '=',1);
        }
        $this->template->is_new = $is_new = (int) $this->getQuery('is_new', 0);
        if ($is_new) {
            $select->where('a.is_new', '=',1);
        }


        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE));
    }

     /*
     * 编辑状态 fred
     */
      public function action_edit()
    {
        $article_id = (int) $this->getQuery('id');
        $rows = DB::select()->from('articles')->where('article_id', '=', $article_id)->execute()->current();
        $this->template->listInfo = $rows;
        $this->template->article_id = $article_id;
        //数组否与是；
        $arr_yesOrNo=array("否","是");
        $this->template->arr_yesOrNo=$arr_yesOrNo;

        //获取分类信息
        $cate = new Bookcategory();
        $this->template->type = $categories = $cate->getCates($rows['uid']);


        if ($this->isPost()) {
            $set = array(
                'title' => trim($this->getPost('title')),
                'cate_id' => (int) $this->getPost('cate_id'),
                'channel_top' =>  $this->getPost('channel_top'),
                'index_top'   => $this->getPost('index_top'),

                'index_recommend' => trim($this->getPost('index_recommend')),
                'is_show' => (int) $this->getPost('is_show'),
                'allow_comment' =>  $this->getPost('allow_comment'),
                'excerpt'   => trim($this->getPost('excerpt')),
                'content'   => trim($this->getPost('content'))
            );
                $set['edit_username'] = $this->auth['username'];
                $set['edit_date'] = time();

            if ($article_id > 0) {
                DB::update('articles')->set($set)->where('article_id', '=', $article_id)->execute();
                $links[] = array(
                    'text' => '返回列表',
                    'href' => '/admin/article/list',
                );
                $this->show_message('修改资料成功', 1, $links, true);
            }
        }
    }



    /**
     * 设置图书状态
     */
    public function action_setStat()
    {
        $type = trim($this->getQuery('type'));
        $val = $this->getQuery('val');
        $id = (int) $this->getQuery('article_id');

        DB::update('articles')->set(array($type => $val))->where('article_id', '=', $id)->execute();
        $this->auto_render = false;
    }


}
