<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 图书馆首页
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Book_Search extends Controller_Book_Base {

    public $tag = null;

    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $this->_add_css('styles/album/public.css');
        $this->_add_script('scripts/jquery/jquery-1.3.2.min.js');
        $this->tag = new Tags();
    }

    /*
     * 首页
     */
    public function action_index()
    {
        $this->_add_css('styles/album/my_library.css');
        $this->_add_script('scripts/dtree.js');
        $this->template->pageTitle = '图书搜索';

        $select = $select = DB::select('a.*', 'cate.cate_name')->from(array('articles', 'a'))
            ->join(array('article_categories', 'cate'))
            ->on('cate.cate_id', '=', 'a.cate_id')
            ->where('a.recycle', '=', 0)
            ->order_by('a.article_id','DESC');

        $this->template->keyword = $keyword = urldecode($this->getQuery('keyword'));
        if (!empty($keyword)) {
            $select->where('a.title', 'like', "%$keyword%")
                ->or_where('a.content', 'like', "%$keyword%");
        }

        $this->template->searchTag = $tag = urldecode($this->getQuery('tags'));
        if (!empty($tag)) {

            $tag_id = DB::select('tag_id')->from('tags_name')->where('tag_name', '=', $tag)->execute()->get('tag_id');
            if ($tag_id > 0) {
                $result = DB::select('tags.item_id')->from('tags')->where('tags.tag_id', '=', $tag_id)->execute()->as_array();
                $item_id = array();
                foreach ($result as $item) {$item_id[] = $item['item_id'];}
                $select->where('a.article_id', 'in', $item_id);
                $this->template->pageTitle = '标签搜索';
            }
        }
        $this->template->pagination = $pagination = Pagination::factory(array('total_items' => count($select->execute()->as_array()),'items_per_page' => 30));
        $this->template->results =  $select->limit($pagination->items_per_page)->offset($pagination->offset)->execute();



        $this->template->tags = $tags = $this->tag->getHotTags('article');



    }
}
