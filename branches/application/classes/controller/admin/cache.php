<?php
/**
 * 缓存管理
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-11-17
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Cache extends Controller_Admin_Base
{
    /**
     * ORM::factory('acl_role')
     *
     * @var acl_role
     */
    public $role = null;

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        if (!Auth::getInstance()->isAllow('role.list')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        $this->template->layout = array('title' => '缓存管理');

    }

    /**
     * 规则列表
     */
    public function action_index()
    {
        $this->template->description = '<ul>
<li>缓存管理：更新网站首页，公共社区，图书馆首页静态页面</li>
</ul>';
    }


    /**
     * 更新首页，公共社区，图书馆首页
     */
    public function action_clean()
    {
        $cid = (int) $this->getQuery('cid');
        switch($cid) {
            case 1:
                @unlink(DOCROOT . 'cache/index.html');
                shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/index.html');
                break;
            case 2:
                @unlink(DOCROOT . 'cache/pic.html');
                shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/pic.html');
                break;
            break;
            case 3:
                @unlink(DOCROOT . 'cache/book.html');
                shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/book.html');
                break;
            break;
            case 4:
                Cache::instance()->delete();
                break;
            break;
    }
        $links[] = array(
                'text' => '缓存状况',
                'href' => '/admin/cache',
        );
        $this->show_message('缓存更新成功', 1, $links, true);
        $this->auto_render = false;
    }




}
