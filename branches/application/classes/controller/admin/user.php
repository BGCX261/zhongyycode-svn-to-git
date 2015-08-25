<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 管理后台用户
 *
 * @package    controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-9
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Admin_User extends Controller_Admin_Base {

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        $this->template->layout = array(
            'title' => '用户管理',
            'action' => array(
                'list' => array(
                    'url' => '/admin/user/list',
                    'text' => '用户列表',
                ),
                'group' => array(
                    'url' => '/admin/group/group',
                    'text' => '会员组管理',
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

        $select = DB::select('u.*', 'g.group_name', 'g.max_space')->from(array('users', 'u'))
            ->join(array('imgup_group', 'g'), 'LEFT')
            ->on('g.id', '=', 'u.rank')
            ->order_by('u.uid','DESC');
        $this->template->username = $username = trim($this->getQuery('username'));
        $this->template->dim = $dim = (int) $this->getQuery('dim', 0);
        if (!empty($username)) {

            if ($dim > 0) {
            $select->where('u.username', 'like', "%$username%")
                ->or_where('u.uid', '=', $username);
            } else {
                 $select->where('u.username', '=', $username);
            }
        }

        //用户等级
        $this->template->rank = $rank = (int)$this->getQuery('rank', '-1');
        if ($rank > 0) {
            $select->where('u.rank', '=', $rank);
        }

        //用户状态
        $this->template->status = $status = trim($this->getQuery('status', '-1'));
        if (!empty($status) && $status != '-1') {
            $select->where('u.status', '=', $status);
        }
        //用户邮箱, 目录
        $this->template->email = $email = trim($this->getQuery('email'));
        if (!empty($email)) {
            $select->where('u.email', '=', $email);
        }
        $this->template->save_dir = $save_dir = trim($this->getQuery('save_dir'));
        if (!empty($save_dir)) {
            $select->where('u.save_dir', '=', $save_dir);
        }

        // 明星用户
        $this->template->index_top = $index_top = (int) $this->getQuery('index_top', 0);
        if ($index_top > 0) {
            $select->where('u.index_top', '=',1);
        }


         // 积分搜索
        $this->template->sign = $sign = $this->getQuery('sign', '-1');
        $this->template->points = $points = (int) $this->getQuery('points', 0);
        if ($sign != '-1') {
            $select->where('u.points', $sign, $points);
        }
        $time_type = $this->template->time_type = $this->getQuery('time_type', '-1');
        $startDate = $this->template->start_date = $this->getQuery('start_date', '');
        $end_date = $this->template->end_date = $this->getQuery('end_date', '');
        if ($time_type != '-1') {
            if (!empty($startDate)) {
                $select->where("u.".$time_type, '>=', strtotime($startDate));
            }
            if (!empty($end_date)) {
                $select->where("u.".$time_type, '<=', strtotime($end_date));
            }
        }

        $this->template->pagination = $pagination = new Pager($select->distinct(FALSE), array('items_per_page' => 20));
        $this->template->group = DB::select('g.*')->from(array('imgup_group', 'g'))->execute()->as_array();
    }



    /**
     * 编辑用户
     */
    public function action_edit()
    {
        $uid = (int) $this->getRequest('uid');
        $user = ORM::factory('user');
        $this->template->description = '<ul>
<li>注：不需要修改密码请保留空白（密码至少6位）</li>

</ul>';
        $this->template->userInfo = $userInfo = $user->getInfo($uid);
        $this->template->layout['title'] = '编辑 ' . $userInfo['username'] . ' 的信息';
        $this->template->group = DB::select('g.*')->from(array('imgup_group', 'g'))->execute()->as_array();

        if ($this->isPost()) {
            $set = array(
                'email' => trim($this->getPost('email')),
                'rank' => (int) $this->getPost('group'),
                'status' =>  $this->getPost('status'),
                'memo'   => trim($this->getPost('memo'))
            );

            $password = trim($this->getPost('password'));
            if (!empty($password)){
                $set['password'] = base64_encode($password);
            }
            $expire_time = trim($this->getPost('expire_time'));
            $set['expire_time'] = strtotime($expire_time);

            /*
             * 过期，禁止，冻结状态
             * 取消明星用户
             * 所有图书取消：最新文章、热门文章、美文推荐、首页置顶、显示；
             * 所有图片取消：美图推荐、分享、图片滚动；
             * 专题取消推荐
             */
            $status_array = array('overtime', 'disapproval', 'forbid');
            if (in_array($set['status'], $status_array))
            {

                $set['index_top'] = 0;
                $artData = array(
                    'is_hot' => 0,
                    'is_new' => 0,
                    'is_recommend' =>0,
                    'index_top' => 0,
                    'is_show' => 0,
                );
                DB::update('articles')->set($artData)->where('uid', '=', $uid)->execute();
                $imgData = array(
                    'is_top' => 0,
                    'is_share' => 0,
                    'is_flash' =>0,
                );
                DB::update('imgs')->set($imgData)->where('userid', '=', $uid)->execute();
                DB::update('specialpics')->set(array('is_top' => 0))->where('uid', '=', $uid)->execute();
                // 删除缓存
                @unlink(DOCROOT . 'cache/index.html');
                shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/index.html');

                @unlink(DOCROOT . 'cache/pic.html');
                shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/pic.html');

                @unlink(DOCROOT . 'cache/book.html');
                shell_exec('. /server/wal8/www/bin/clearcache.sh http://www.wal8.com/cache/book.html');
            }


           /* if (!empty($expire_time) && $set['status'] == $userInfo['status']){
                $set['expire_time'] = strtotime($expire_time);
                if (strtotime($expire_time) > time()){
                    $set['status'] = 'approved';
                } elseif (strtotime($expire_time) < time()) {
                    $set['status'] = 'overtime';
                }
            }
            */
            // 过期时间超过七天, 需要减去七天时间
            if ($set['expire_time']  > time()) {
               $expire = time() - $userInfo['expire_time'];
               if ($expire > 604800 ) {
                    $set['expire_time'] = $set['expire_time'] - 604800;
               }
            }


            if ($uid > 0) {

                DB::update('users')->set($set)->where('uid', '=', $uid)->execute();
                $disks = ORM::factory('img_disk')->find_all();
                /*
                 *disapproval 冻结状态：网站功能失效，将用户目录权限设置为000；
                 *approved  通过状态：网站功能恢复，将用户目录权限设置为0777；
                 *forbid 禁止状态：网站功能失效，将用户目录权限设置为000， 将该用户注册ip添加到禁止注册imgup_denyip表中；
                 */
                if ($set['status'] == 'disapproval') {
                    foreach ($disks as $disk) {
                     $dir = '/server/wal8/www/'. $disk->disk_name . '/' . ORM::factory('user', $uid)->save_dir;
                     @chmod($dir, 0000);
                    }
                } elseif ($set['status'] == 'approved') {
                    foreach ($disks as $disk) {
                     $dir = '/server/wal8/www/'. $disk->disk_name . '/' . ORM::factory('user', $uid)->save_dir;
                     @chmod($dir, 0777);
                    }
                }elseif ($set['status'] == 'forbid') {
                    $user = ORM::factory('user', $uid);
                    foreach ($disks as $disk) {
                     $dir = '/server/wal8/www/'. $disk->disk_name . '/' . $user->save_dir;
                     @chmod($dir, 0000);
                    }
                    $deny = array(
                        'uid' => $uid,
                        'ip_add' => $user->reg_ip,
                        'username' => $user->username,
                    );
                    DB::insert('imgup_denyip',array_keys($deny))->values(array_values($deny))->execute();

                }

                $links[] = array(
                    'text' => '返回列表',
                    'href' => '/admin/user/list',
                );
                $this->show_message('修改资料成功', 1, $links, true);
            }
        }
    }

    /**
     * 查看用户信息
     */
    public function action_view()
    {

        $uid = (int) $this->getQuery('uid');
        $user = ORM::factory('user');
        $this->template->userInfo = $userInfo = $user->getInfo($uid);
        $this->template->layout['title'] = $userInfo['username'] .'的信息';
    }

    /**
     * 设置明星用户
     *
     */
    public function action_indextop()
    {
        if ($this->isPost()) {
            $uid = $this->getPost('uid');
            $app =  $this->getQuery('app');
            if (empty($uid)) {
                $this->show_message('请选择要设置的用户', 0, $links, true);
            }
            if (!is_array($uid)) {
                $uid = array($uid);
            }
            foreach ($uid as $value) {
                if ($app == 'del') {
                    DB::update('users')->set(array('index_top' => 0))->where('uid', '=', $value)->execute();
                } elseif ($app == 'add') {
                    DB::update('users')->set(array('index_top' => 1))->where('uid', '=', $value)->execute();
                } else {
                    $this->show_message('非法操作', 0, array(), true);
                }
            }

            $this->request->redirect('/admin/user/list');

        }
        $this->auto_render = false;
    }


    /**
     * 角色指派
     */
    public function action_role()
    {
        $this->template->description = '<ul>
<li>角色指派:用户后台权限登录角色</li>

</ul>';
        $this->template->layout['title'] = '用户管理-角色指派';
        if (!Auth::getInstance()->isAllow('privilege.assign')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        $this->template->uid = $uid = (int) $this->getQuery('uid');
        if ($this->isPost()) {
            $roles = $this->getPost('roles');
            DB::delete('user_roles')->where('uid', '=', $uid)->execute();
            foreach ($roles as $module => $roleId) {
                DB::insert('user_roles',array('uid', 'role_id','mod_name'))->values(array($uid, $roleId, $module))->execute();
            }
            $this->request->redirect('/admin/user/list');
        }

        $module = ORM::factory('module');
        $this->template->modules = $module->getAll();
        $this->template->rolesGroup = $rolesGroup =  ORM::factory('user_role')->getRolesGroup();
        $this->template->userRoles = ORM::factory('user_role')->getUserRoles($uid);

    }

    /**
     * 升级用户
     */
    public function action_upgrade()
    {
        $uid = (int) $this->getQuery('uid');
        $user = ORM::factory('user');
        $this->template->orderInfo = DB::select('u.*', 'g.group_name')
            ->from(array('imgup_upgrade', 'u'))
            ->join(array('imgup_group', 'g'))->on('g.id', '=', 'u.dest_group')
            ->where('uid', '=', $uid)
            ->order_by('u.id', 'DESC')->fetch_all();
        $this->template->userInfo = $userInfo = $user->getInfo($uid);

        $this->template->group = DB::select('g.*')->from(array('imgup_group', 'g'))->execute()->as_array();

        if ($this->isPost()) {

            $uid = (int) $this->getPost('uid');
            $groupId = (int) $this->getPost('group');
            $time = (int) $this->getPost('time');
            $status = (int) $this->getPost('status');
            if ($status) {
                $time = $time * 12;
            }
            $userInfo = DB::select()->from('users')->where('uid', '=', $uid)->execute()->current();
            $upgrade = new Upgrade($userInfo, $groupId, $time);
            $payPrice = $upgrade->calculate()->getMoney(); // 订单金额
            //$data = array($uid, $groupId, date('Y-m-d H:i:s'), ceil($payPrice), $userInfo['rank'], $upgrade->generateOrderSn(), 1, $time);

            $data = array(
                'uid' => $uid,
                'dest_group' => $groupId,
                'save_time' => date('Y-m-d H:i:s'),
                'fee' => ceil($payPrice),
                'current_group' => $userInfo['rank'],
                'orderno' => $upgrade->generateOrderSn(),
                'consume_type' => 1,
                'trade_no' => trim($this->getPost('trade_no')),
                'month' => $time,
            );

            # 创建订单
            $row = DB::insert('imgup_upgrade', array_keys($data))->values(array_values($data))->execute();
            $this->request->redirect('/admin/user/upgrade?uid='. $uid);
        }

    }

    /**
     * 计算升级用户所需费用
     */
    public function action_fee()
    {
        $uid = (int) $this->getQuery('uid');
        $groupId = (int) $this->getQuery('group');
        $time = (int) $this->getQuery('time');
        $status = (int) $this->getQuery('status');
        if ($status) {
            $time = $time * 12;
        }


        $userInfo = DB::select()->from('users')->where('uid', '=', $uid)->execute()->current();
        $upgrade = new Upgrade($userInfo, $groupId, $time);
        $payPrice = $upgrade->calculate()->getMoney(); // 订单金额
        echo json_encode(array('price' => ceil($payPrice)));
        $this->auto_render = false;
    }

    /**
     * 处理付款定单
     */
    public function action_pay()
    {
        if (!Auth::getInstance()->isAllow('order.edit')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        if ($this->isPost()) {

             $id = (int) $this->getPost('upgrade_id');
             $orderInfo = DB::select('u.*', 'g.group_name')
                ->from(array('imgup_upgrade', 'u'))
                ->join(array('imgup_group', 'g'))->on('g.id', '=', 'u.dest_group')
                ->where('u.id', '=', $id)->execute()->current();
             $userInfo = DB::select()->from('users')->where('uid', '=', $orderInfo['uid'])->fetch_row();
             #计算付款后到期时间
             if ($orderInfo['dest_group'] == $orderInfo['current_group']) {

                // 过期时间超过七天, 需要减去七天时间
               $expire = time() - $userInfo['expire_time'];
               if ($expire > 604800 ) {
                  $will_exceed = date('Y-m-d', (strtotime(date('Y-m-d H:i:s') . ' + ' . $orderInfo['month'] .' '. 'month') - 604800));
               } else {
                  $will_exceed = date('Y-m-d', strtotime(date('Y-m-d H:i:s', $userInfo['expire_time']) . ' + ' . $orderInfo['month'] .' '. 'month'));
               }

            } else{
                $will_exceed = date('Y-m-d', strtotime('+' . $orderInfo['month'] . ' month '));
            }

             # 计算day_fee
           if($orderInfo['month'] % 12 == 0){
               $fee_day = DB::select(DB::expr("(fee_year / 365) AS count"))->from('imgup_group')->where('id', '=', $orderInfo['dest_group'])->execute()->get('count');
            } else {
               $fee_day = DB::select(DB::expr("(fee_month / 30) AS count"))->from('imgup_group')->where('id', '=', $orderInfo['dest_group'])->execute()->get('count');
            }
            # 修改订单状态
            $order_data = array(
                'status' => 1,
                'submit_time' => date('Y-m-d H:i:s'),
                'operator' => $this->auth['username'],
                'will_exceed' => $will_exceed
            );
            DB::update('imgup_upgrade')->set($order_data)->where('id', '=', $orderInfo['id'])->execute();
            #修改用户状态
            $order_data = array(
                'status' => 'approved',
                'expire_time' => strtotime($will_exceed),
                'fee_day' => round($fee_day, 2),
                'rank' => $orderInfo['dest_group'],
            );
            // 赠送空间数
            switch ($orderInfo['dest_group']) {
                case 14:
                    $gift = 30;break;
                case 17:
                    $gift = 50;break;
                case 21:
                    $gift = 80;break;
                default:
                    $gift = 0;break;
            }
            $order_data['gift'] = $gift;

            DB::update('users')->set($order_data)->where('uid', '=', $orderInfo['uid'])->execute();
            # 处理屏蔽表数据
            DB::update('imgup_deny_user')->set(array('status' => 0))->where('uid', '=', $orderInfo['uid'])->execute();


            $disks = ORM::factory('img_disk')->find_all();

            // 开启用户状态
            foreach ($disks as $disk) {
             $dir = '/server/wal8/www/'. $disk->disk_name . '/' . ORM::factory('user', $orderInfo['uid'])->save_dir;
             @chmod($dir, 0777);
            }


            $this->request->redirect('/admin/user/upgrade?uid='. $orderInfo['uid']);
        }
        $this->auto_render = false;
    }


    /**
     * 取消订单
     */
    public function action_cancel()
    {
        if (!Auth::getInstance()->isAllow('order.delete')) {
            $this->show_message("对不起，您没有权限执行该操作");
        }
        $id = (int) $this->getQuery('id');
        $uid = (int) $this->getQuery('uid');
        DB::update('imgup_upgrade')->set(array('operator' => $this->auth['username'], 'status' => 2))->where('id', '=', $id)->execute();
        $this->request->redirect('/admin/user/upgrade?uid='. $uid);
    }

    /**
     * 管理 员列表
     */
    public function action_rolelist()
    {
        $this->template->layout['title'] = '用户管理-管理员列表';
        $select = DB::select('u.username', 'u.uid', 'ar.role_desc')
            ->from(array('user_roles', 'ur'))
            ->join(array('users','u'))
            ->on('u.uid', '=', 'ur.uid')
            ->join(array('acl_roles','ar'))
            ->on('ar.role_id', '=', 'ur.role_id')
            ->where('ur.mod_name', '=', 'admin');
        $this->template->list = $list = $select->fetch_all();

    }

    /**
     * 涮新用户空间状况
     */
    public function action_upcache()
    {
        $uid = (int) $this->getQuery('uid');
        ORM::factory('user')->upcache($uid, false);
        $this->request->redirect('/admin/user/view?uid=' . $uid);
    }
}
