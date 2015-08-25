<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台框架
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-14
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_Index extends Controller_Admin_Base {

    /*
     * 首页
     */
    public function action_index()
    {

    }

    /**
     * 导航条
     */
    public function action_navigation()
    {
        $navigation = array();

        if(Auth::getInstance()->hasAllow(array('album.list'))){
            $navigation[] = array(
                'text' => '相册管理',
                'class' => 'imgs',
            );
        }
        if(Auth::getInstance()->hasAllow(array('books.list'))){
            $navigation[] = array(
                'text' => '图书馆管理',
                'class' => 'article',
            );
        }
        if(Auth::getInstance()->hasAllow(array('user.list'))){
            $navigation[] = array(
                'text' => '用户管理',
                'class' => 'user',
            );
        }
        if(Auth::getInstance()->hasAllow(array('order.list'))){
            $navigation[] = array(
                'text' => '订单管理',
                'class' => 'order',
            );
        }
        if(Auth::getInstance()->isAllow('system.set')){
            $navigation[] = array(
                'text' => '系统管理',
                'class' => 'system',
            );
        }
        $this->template->navigation = $navigation;

    }

    /**
     * 左边菜单
     */
    public function action_menu()
    {
        $menu = array();
        if(Auth::getInstance()->hasAllow(array('album.list'))){
            //图片管理
            $menu[] = array(
                'text' => '图片列表',
                'url' => '/admin/pics/list?start_date=' .  date('Y-m-d'),
                'class' => 'imgs',
            );
            if(Auth::getInstance()->hasAllow(array('album.set'))){
                $menu[] = array(
                    'text' => '图片分类',
                    'url' =>'/admin/category/list',
                    'class' => 'imgs',
                );
                $menu[] = array(
                    'text' => '图片评论',
                    'url' => '/admin/comments/booklist?app=img',
                    'class' => 'imgs',
                );
                $menu[] = array(
                    'text' => '专题管理',
                    'url' => '/admin/picsubject/list',
                    'class' => 'imgs',
                );
                $menu[] = array(
                    'text' => '流量统计',
                    'url' => '/admin/stat/flowrate?start_date='.date("Y-m-d",strtotime("-1 day")),
                    'class' => 'imgs',
                );
                $menu[] = array(
                    'text' => '搬家文件管理',
                    'url' => '/admin/csvfile',
                    'class' => 'imgs',
                );
            }
        }
        //图书馆管理
        if(Auth::getInstance()->hasAllow(array('books.access', 'books.list'))){
            $menu[] = array(
                'text' => '图书栏目',
                'url' => '/admin/bookcate/list',
                'class' => 'article',
            );
            $menu[] = array(
                'text' => '图书列表',
                'url' => '/admin/article/list',
                'class' => 'article',
            );

            $menu[] = array(
                'text' => '图书评论',
                'url' => '/admin/comments/booklist?app=article',
                'class' => 'article',
            );


        }


        if(Auth::getInstance()->hasAllow(array('user.list'))){
            $menu[] = array(
                'text' => '用户列表',
                'url' => '/admin/user/list',
                'class' => 'user',
            );
            $menu[] = array(
                'text' => '会员组管理',
                'url' => '/admin/group/group',
                'class' => 'user',
            );
            $menu[] = array(
                'text' => '系统管理员管理',
                'url' => '/admin/user/rolelist',
                'class' => 'user',
            );
            $menu[] = array(
                'text' => '屏蔽信息表',
                'url' => '/admin/denyuser/list',
                'class' => 'user',
            );
        }
        if(Auth::getInstance()->hasAllow(array('module.list'))){
            $menu[] = array(
                'text' => '模块与权限',
                'url' => '/admin/module',
                'class' => 'system',
            );
        }
        if(Auth::getInstance()->hasAllow(array('system.set'))){
            $menu[] = array(
                'text' => '系统配置',
                'url' => '/admin/system',
                'class' => 'system',
            );
            $menu[] = array(
                'text' => '缓存状态',
                'url' => '/admin/cache',
                'class' => 'system',
            );
            if(Auth::getInstance()->isAllow(array('order.list'))){
                $menu[] = array(
                    'text' => '订单管理',
                    'url' => '/admin/order/list',
                    'class' => 'order',
                );
                if(Auth::getInstance()->isAllow(array('stat.access'))){
                     $menu[] = array(
                        'text' => '订单统计',
                        'url' => '/admin/stat/order',
                        'class' => 'order',
                    );
                }
            }
            if(Auth::getInstance()->hasAllow(array('disk.access'))){
                $menu[] = array(
                    'text' => '磁盘管理',
                    'url' => '/admin/disk/list',
                    'class' => 'system',
                );
            }

            $menu[] = array(
                'text' => '帮助文档',
                'url' => '/admin/help',
                'class' => 'system',
            );
            $menu[] = array(
                'text' => '邮件模板',
                'url' => '/admin/template/email',
                'class' => 'system',
            );
            $menu[] = array(
                'text' => '邮件调度管理',
                'url' => '/admin/template/sheme',
                'class' => 'system',
            );
            $menu[] = array(
                'text' => '任务审核',
                'url' => '/admin/point',
                'class' => 'system',
            );
            $menu[] = array(
                'text' => '举报审核',
                'url' => '/admin/report',
                'class' => 'system',
            );
            $menu[] = array(
                'text' => '支付配置',
                'url' => '/admin/payment',
                'class' => 'order',
            );
             $menu[] = array(
                'text' => '支付日志',
                'url' => '/admin/payment/logs',
                'class' => 'order',
            );
        }
        $this->template->menu = $menu;
    }

    /**
     * 底部
     */
    public function action_footer()
    {

    }
    /**
     * 中间内容
     */
    public function action_main()
    {
    }

}
