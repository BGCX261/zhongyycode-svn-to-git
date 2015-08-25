<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 用户中心
 * @package    Controller
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-9-15
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_User extends Controller_Base {


    /**
     * 控制器方法执行前，添加css，js
     *
     */
    public function before()
    {
        parent::before();
        $arr = array('login', 'register', 'hasuser','checkemail', 'forget','resetpass');
        if (!in_array($this->request->action, $arr)) {
            if(!$this->auth){
                $links[] = array(
                    'text' => '去登录',
                    'href' => '/user/login?forward='.urlencode($_SERVER['REQUEST_URI']),
                );
                $this->show_message('你尚未登录,请登录后再进行操作。。。', 0, $links);
            }
        }
    }

    /**
     * 首页
     */
    public function action_index()
    {
        $data = ORM::factory('user')->upcache($this->auth['uid']);
        $this->template->auth = $this->auth = Session::instance()->get('user', false);
    }

    /**
     * 用户注册
     */
    function action_register()
    {

        if ($_POST) {
            $ip = Request::$client_ip;
            $ipInfo = DB::select()->from('imgup_denyip')->where('ip_add', '=', $ip)->fetch_row();
            if (!empty($ipInfo)) {
                $this->show_message('IP: '. $ip . ' 禁止注册,请联系客服!!');
            }
            //数据验证
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->rule('username', 'regex', array('/^[^\'\"\:;,\<\>\?\/\\\*\=\+\{\}\[\]\)\(\^%\$#\!`\s]+$/'))
                ->rule('username', 'min_length', array('2'))
                ->rule('username', 'max_length', array('10'))
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array('6'))
                ->rule('password', 'max_length', array('20'))
                ->rule('email', 'not_empty')
                ->rule('email', 'email')
                ->rule('captcha', 'not_empty')
                ->rule('captcha','Captcha::valid');

            $user = ORM::factory('user');
            // 验证
            if ($post->check()) {
                $exists =  ORM::factory('user')->where('username', '=', $post['username'])->find();
                $exists_email =  ORM::factory('user')->where('email', '=', $post['email'])->find();


                if(!empty($exists->username)){
                    $this->show_message('该用户名已经存在，请换另一个' . $post['username']);
                    die();
                }
                if(!empty($exists_email->email)){
                    $this->show_message('该邮箱已经存在，请换一个邮箱');
                    die();
                }

                $field = $user->field;
                $user->reg_ip = Request::$client_ip;
                $user->expire_time = strtotime(date('Y-m-d H:i:s', strtotime('+1 month')));
                $user->values($post);
                $user->reg_ip = Request::$client_ip;
                $user->rank = 1;
                $user->password = base64_encode($post['password']);
                $user->save();

                //存储其它信息
                $field->uid = $user->uid;
                $field->values($post)->save();
                DB::update('users')->set(array('save_dir' => $user->uid . '_' . date('YmdHis')))->where('uid', '=', $user->uid)->execute();
                // 首次登录
                $userData = $user->login($user->uid);
                $user->session_save('user', $userData);

               /* $category = ORM::factory('img_category');
                $category->uid = $user->uid;
                $category->cate_name = '我的图册';
                $category->description = '系统默认目录';
                $category->type = 1;
                $category->save();
                */
                // 发邮件
                Email::Send($post['username'], $post['email']);

               $this->request->redirect('/user/success');

            } else {
                // 校验失败，获得错误提示
                $str = '';
                $this->template->registerErr = $errors = $post->errors('default/user/login');
                    foreach($errors as $item) {
                        $str .= $item  . '<br>';
                    }
                $this->show_message($str);
            }
        }
    }

    /**
     * 注册成功
     */
    public function action_success()
    {

    }

    /**
     * 用户登录
     */
    public function action_login()
    {
        if ($this->isPost()) {
            //数据验证
            $post = Validate::factory($this->getPost())
                ->filter(TRUE, 'trim')
                ->rule('username', 'not_empty')
                ->rule('password', 'not_empty');
            if ($post->check()) {
                $user = ORM::factory('user');
                $exists = $user->where('username', '=', $post['username'])
                    ->where('password', '=', base64_encode($post['password']))
                    ->find();
                if($exists->uid) {
                    // 登录成功存储用户信息
                    $userData = $user->login($exists->uid);
                    $user->session_save('user', $userData);

                    $forward = urldecode($this->getQuery('forward'));
                    if (!empty($forward)) {
                        $this->request->redirect($forward);
                    }
                    $links[] = array('text' => '用户中心操作', 'href' => '/user');
                    $this->show_message('欢迎你来到我们的网站', 1, $links);
                } else{
                    $this->show_message('用户名或者密码错误，请检查');
                }
            }
            $errors = $post->errors('default/user/login');
            if(!empty($errors)) {
                $this->show_message($errors, 0, array('text' => '返回登录页','href' => '/user/login'));
            }
        }
    }

    /**
     * 用户退出
     *
     */
    public function action_logout()
    {
        Session::instance()->delete('user');
        $this->show_message('成功退出，欢迎你再次登录', 1, '', true);
        $this->auto_render = false;
    }

     /**
     * 设置登录hash值
     */
    public function action_asyncLogin()
    {
        $uid = (int) $this->getQuery('uid');
        $user_key = trim($this->getQuery('key'));
        $user = ORM::factory('user');
        $hasRow = $user->where('uid', '=', $uid)
            ->where('password', '=', $user_key)
            ->find();
        if (!empty($hasRow->uid)){
            $userData = $user->login($hasRow->uid);
            $user->session_save('user', $userData);
        }
        $this->auto_render = false;
    }

    /**
     * ajax验证是否存在相同用户名
     *
     */
    public function action_hasuser()
    {

        $username = trim($this->getQuery('username'));
        $user = ORM::factory('user');
        $exists = $user->where('username', '=', $username)->find();
        if(!empty($exists->username)){
            echo '用户已经存在';
        }
        $this->auto_render = false;
    }


    /**
     * ajax 验证邮箱
     */
    public function action_checkemail()
    {
        $email = trim($this->getQuery('email'));
        $user = ORM::factory('user');
        $exists = $user->where('email', '=', $email)->find();
        if(!empty($exists->email)){
            echo '用户邮箱已经存在';
        }
        die();
        $this->auto_render = false;
    }




    /**
     * 设置资料
     */
    public function action_profile()
    {
        if ($this->isPost()) {
            //处理头像
            if (!empty($_FILES['upload_file']['name'])) {
                $disk = ORM::factory('img_disk');
                $disks = $disk->where('is_use', '=', 1)->find();
                //图片保存目录
                $save_dir = ORM::factory('user', $this->auth['uid'])->save_dir;
                $savePath = DOCROOT . '' . $disks->disk_name . '/' . $save_dir . '/';
                $upload = new Upload(array('size' => 100));

                try {
                    $upload->set_path($savePath);
                    $result = $upload->save($_FILES['upload_file']);

                    $saveName = $disks->disk_name . '/' . $save_dir . '/' .$result['saveName'];
                    $save = '/' .$this->thumb->create($saveName, 92,92);
                    DB::update('users')->set(array('avatar' => $save))->where('uid', '=', $this->auth['uid'])->execute();
                    ORM::factory('user')->upcache($this->auth['uid']);
                    @unlink($savePath. $result['saveName']);
                    $links[] = array(
                        'text' => '返回个人资料',
                        'href' => '/user/profile',
                    );
                    $this->show_message('上传头像处理成功', 1, $links, true);
                } catch(Exception $e) {
                    $this->show_message($e->getMessage(), 0, array(), true);
                }
            }
            $editpass = trim($this->getPost('editpass'));
            $editpass_2 = trim($this->getPost('editpass_2'));
            $editemail = trim($this->getPost('editemail'));
            $qq = trim($this->getPost('qq'));
            $sign = trim($this->getPost('sign'));
            $msn = trim($this->getPost('msn'));
            $shopadd = trim($this->getPost('shopadd'));
            if ($editpass != $editpass_2) {
                 $this->show_message('两次输入的密码不一致', 0, array(), true);
            }
            $set = array(
                'email' => $editemail,
            );
            if (!empty($editpass)) {
                $set['password'] = base64_encode($editpass);
            }
            $check_email = DB::select()->from('users')->where('email','=', $editemail)->where('uid', '!=', $this->auth['uid'])->fetch_row();
            if(!empty($check_email)) {
               $this->show_message('该邮箱地址已有别的用户在使用');
            }
            $field['qq'] = $qq;
            $field['sign'] = $sign;
            $field['msn'] = $msn;
            $field['address'] = $shopadd;
            DB::update('users')->set($set)->where('uid', '=', $this->auth['uid'])->execute();
            DB::update('user_fields')->set($field)->where('uid', '=', $this->auth['uid'])->execute();
            ORM::factory('user')->upcache($this->auth['uid']);
            $links[] = array(
                'text' => '返回个人资料',
                'href' => '/user/profile',
            );
            $this->show_message('修改资料成功', 1, $links);

        }
    }
    /**
     * 忘记密码
     */
    public function action_forget()
    {
        # 邮件中：响应处理的服务器主机名
        $website='http://'.$_SERVER['HTTP_HOST'];
        # 邮件中：响应处理的页面地址
        $url=$website .'/user/resetpass';

        if ($this->isPost()) {
            $username = trim($this->getPost('user'));
            $email = trim($this->getPost('email'));

            if (empty($email) || empty($username)) {
                $this->template->note = '<p>出错了</p>
                    <p>对不起，你填写的信息不完整</p>
                    <p>如果您输入了正确的邮件地址，却没有收到通知，请联系管理员</p>
                    <p>如果您已经忘记了注册的邮件地址，请重新注册。 </p>
                    <p>每小时只能取回一次。</p>';
            } else {
                if(!eregi("[^[:punct:][:space:][:blank:]]$", $username)) {
                    $note = '<p>用户名包含不合法字符</p>';
                }
                if(!eregi("^.+@.+\..+$", $email)) {
                    $note = '<p>邮箱地址不合法</p>';
                }
                $user = ORM::factory('user');
                $rows = $user->where('username', '=', $username)->where('email', '=', $email)->find();
                if (empty($rows->username)) {
                    $note = '<p>用户名不存在,或用户名与邮箱不相符！</p>';
                } else {
                    $x = md5($rows->username . '+' . $rows->password);
                    $String = base64_encode($rows->username.".".$x);
                    $link='<a href='. $url . '?' . $String . '>' . $url . '?' . $String . '</a>';

                    $email_info = DB::select('subject', 'template', 'sender', 'sender_email')
                            ->from('imgup_email')
                            ->where('name', '=', 'G2')
                            ->execute()->current();
                    if (!empty($email_info)) {
                        $sender_email=iconv("utf-8", "gb2312//IGNORE", $email_info['sender_email']);
                        $sender=iconv("utf-8", "gb2312//IGNORE", $email_info['sender']);
                        $subject=iconv("utf-8", "gb2312//IGNORE", $email_info['subject']);
                        $template=stripcslashes($email_info['template']);
                        $template=str_replace('$NAME$', $username, $template);
                        $template=str_replace('$LINK$', $link, $template);
                        $template=iconv("utf-8", "gb2312//IGNORE", $template);

                        $mail=new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host="mail.wal8.com";
                        $mail->SMTPAuth = true;         // turn on SMTP authentication
                        $mail->Username = "service@wal8.com";   // SMTP username  注意：普通邮件认证不需要加 @域名
                        $mail->Password = "tqs1234";        // SMTP password
                        //$mail->From = "service@wal8.com";      // 发件人邮箱
                        $mail->From = $sender_email;
                        //$mail->FromName =  "service";  // 发件人
                        $mail->FromName = $sender;
                        $mail->CharSet = "GB2312";            // 这里指定字符集！
                        $mail->Encoding = "base64";
                        //$mail->AddAddress($sendto_email,$user_name);  // 收件人邮箱和姓名
                        $mail->AddAddress($_POST['email'],$_POST['user']);
                        //$mail->AddReplyTo("service@wal8.com","service");
                        $mail->AddReplyTo($sender_email,$sender);
                        $mail->IsHTML(true);  // send as HTML
                        // 邮件主题
                        $mail->Subject = $subject;
                        // 邮件内容
                        $mail->Body =$template;
                        $mail->AltBody ="text/html";
                        $mail->Send();
                        $send_mess=1;
                    }
                    if($send_mess){
                        $note = '<br><br><p>成功</p>';
                        $note .= '<p>已将找回密码的邮件发送到您的邮箱，请查收！</p>';
                    }
                }

                $this->template->note = $note;
            }
        }
    }

    /**
     * 重设置密码
     */
    public function action_resetpass()
    {
        $i=$_SERVER["QUERY_STRING"];
        if(isset($i)){
            $array = explode('.',base64_decode($i));
            $name=$array[0];
            $this->template->info = $info = ORM::factory('user')->where('username', '=', $name)->find();

            /**
              * 产生配置码
             */
            $checkCode = md5($info->username.'+'.$info->password);
            if( $array['1'] != $checkCode ){
                $this->show_message('页面已经过期');
            } else {
                if ($this->isPost()) {
                    $password = trim($this->getPost('password'));

                    DB::update('users')->set(array('password' => base64_encode($password)))
                        ->where('uid', '=',$info->uid)
                        ->execute();

                    $links[] = array(
                        'text' => '返回登录页面',
                        'href' => '/user/login',
                    );
                    $this->show_message('重设密码成功', 1, $links);
                }

            }
        }

    }

}
