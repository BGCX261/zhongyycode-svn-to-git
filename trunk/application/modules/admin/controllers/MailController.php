<?php
/**
 * 群发邮件
 *
 * @package    controller
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @license     http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Admin_MailController extends YUN_Controller_Action_Admin
{
    private $_transport = null;

    /**
     * 初始化操作
     */
    public function init()
    {
        parent::init();
        if (!$this->auth->isAllow('mail.send')) {
            $this->view->feedback(array(
                'message' => "对不起，您没有权限执行该操作",
            ));
        }

        $this->_transport = new Zend_Mail_Transport_Smtp(
            $this->config->mail->host,
            $this->config->mail->config->toArray()
        );

        $this->view->layout = array(
            'title' => '邮件管理',
            'action' => array(
                'index' => array(
                    'url' => array('module' => 'admin', 'controller' => 'mail', 'action' => 'index'),
                    'text' => '发送邮件',
                ),

                'set' => array(
                    'url' => array('module' => 'admin', 'controller' => 'mail', 'action' => 'set'),
                    'text' => '设置邮件'
                ),
            ),
            'current' => $this->module['action'],
        );
    }

    /**
     * 发送邮件
     */
    public function indexAction()
    {
        $this->view->layout['description'] = array('<ul>
<li>邮件列表文件的格式应该为每行一个邮件</li>
<li>内容文件可以是html格式，但是图片地址必须是指向服务器地址的</li>
<li>文件的编码必须是UTF8</li>
<li>邮件的标题请自行填写，系统不会自动生成标题</li>
</ul>');

        if ($this->_request->isPost()) {
            $msg = '';
            $title = $this->_request->getPost('title');
            $emails = file($_FILES['email']['tmp_name']);
            $content = file_get_contents($_FILES['content']['tmp_name']);

            foreach ($emails as $email) {
                $email = trim($email);
                $pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
                if (empty($email) || !preg_match($pattern, $email)) continue;

                try {
                    $mail = new YUN_Mail('utf-8');
                    $mail->addTo($email)
                        ->setFrom($this->config->mail->config->username)
                        ->setSubject($title)
                        ->setBodyHtml($content)
                        ->send($this->_transport);
                } catch (Exception $e) {
                    echo '发送邮件到' . $email . '失败：' . $e->getMessage() . "<br>\n";
                }
            }

            $this->view->feedback(array(
                'title'     => '发送成功',
                'message'   => '邮件发送完毕。 ',
            ));
        }

    }

    /**
     * 邮件设置
     */
    public function setAction()
    {
        if ($this->_request->isPost()) {
            $value = array(
                'host' => $this->_request->getPost('host'),
                'config' => array(
                    'auth' => 'login',
                    'username' => $this->request->getPost('username'),
                    'password' => $this->request->getPost('password'),
                ),
            );
            $info = array(
                'option_name' => 'mail',
                'option_value' => serialize($value)
            );
            $this->db->replace('settings', $info);
            $this->cache->remove('settings');
        }
        $this->view->mail = $this->config->mail;
    }

    /**
     * 测试验证类
     *
     */
    public function test()
    {
        $validator = new YUN_Validator();
        $email = 'dddd..*';
        $validator->check(
                $email,
                array(
                    array('NotEmpty', '用户名不允许为空'),
                    array('StringLength' => array(4, 60), '用户名必须介于 4~60 个字符之间'),
                    array('Regex' => "/^[^\'\"\:;,\<\>\?\/\\\*\=\+\{\}\[\]\)\(\^%\$#\!`\s　]+$/", '用户名包含非法字符')
                )
        );
        //数据校验
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }
    }


}