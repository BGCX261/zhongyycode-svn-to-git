<?php
defined('SYSPATH') or die('No direct script access.') ;
/**
 * 文章model
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-18
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Model_Article extends ORM
{

    /**
     * 设置主健
     *
     */
    public $_primary_key = 'article_id';

    /**
     * 自动格式化时间
     */
    protected $_created_column = array('column' => 'post_date', 'format' => TRUE);

    /**
     * 获得用户文章
     *
     */
    public function getUserArticle($uid, $limit = 20, $order_by = 'article_id')
    {
        return $this->where('uid', '=', $uid)->order_by($order_by, 'DESC')->limit($limit)->find_all();
    }

    /**
     * 获取下一个
     */
    public function nextArticle($aid, $uid = 0)
    {
         $select = DB::select()->from('articles')->where('article_id', '>', $aid)
            ->order_by('article_id', 'ASC')->limit(1);
         if ($uid > 0) $select->where('uid', '=', $uid);
        return $select->execute()->current();
    }

    /**
     * 获取上一个
     */
    public function preArticle($aid, $uid = 0)
    {
         $select = DB::select()->from('articles')->where('article_id', '<', $aid)
            ->order_by('article_id', 'DESC')->limit(1);
         if ($uid > 0) $select->where('uid', '=', $uid);

        return $select->execute()->current();
    }
}
?>