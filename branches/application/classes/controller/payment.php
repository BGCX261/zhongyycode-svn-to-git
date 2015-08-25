<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 支付处理
 *
 * @package    class
 * @author     zhongyy <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-12-30
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class Controller_Payment extends Controller_Base
{

    /**
     * 是否合并付款
     */
    protected $_is_merged = FALSE;

    /**
     * 付款通知
     *
     * @param  string  $adapter
     */
    public function action_notify($adapter)
    {
        try
        {
            $respond = $this->_respond($adapter);
            exit('success');
        }
        catch (Exception $e)
        {
            exit('fail');
        }
    }

    /**
     * 付款返回
     *
     * @param  string  $adapter
     */
    public function action_return($adapter)
    {
        try {
            $respond = $this->_respond($adapter);

            $this->template->result =  '
                        <div class="sjTop"><img src="/images/user/img3.gif" />选择支付方式→<span><img  src="/images/user/img4.gif"/><b>支付成功</b></span></div>
                        <div class="sjCheng"><img src="/images/user/sjCheng.gif" /><p><a href="/user/logout">请重新登录后生效！</a></p></div>
                    ';
       } catch (Exception $e) {
            $links[] = array(
                    'text' => '返回付费中心',
                    'href' => '/pay/upgrade',
                );
            $this->show_message($e->getMessage(), 0, $links, TRUE);
        }
    }

    /**
     * 支付响应
     *
     * @param  string  $adapter
     * @return Payment_Respond_Abstract
     * @throws Exception
     */
    protected function _respond($adapter)
    {
        if(empty($adapter))
        {
            throw new Exception('发生错误');
        }

        Payment::log($adapter);

        $config = Payment::config($adapter); // 读取配置

        $respond = Payment::respond($adapter); // 创建支付响应实例

        $respond->set_key($config->pay_key)->parse($_REQUEST);

        if ($respond->is_paid() OR $respond->is_success()) // 订单已付款或已完成
        {
            $order_sn = $order_merged_id = $respond->get_id(); // 获取订单编号

            // 判断存在
            $row = DB::select('*')->from('imgup_upgrade')
                ->where('orderno','=',$order_sn)
                ->fetch_row();
            $uid = (int) $row['uid'];
            if(empty($row)) {
                throw new Exception('订单号不存在！');
            } else {
                if ($row['status'] == 1) {
                    return;
                }
                if($row['month'] == 12){
                    $fee_day = DB::select(DB::expr("(fee_year / 365) AS count"))
                        ->from('imgup_group')
                        ->where('id', '=', $row['dest_group'])
                        ->execute()
                        ->get('count');
                } else {
                    $fee_day = DB::select(DB::expr("(fee_month / 30) AS count"))
                        ->from('imgup_group')
                        ->where('id', '=', $row['dest_group'])
                        ->execute()
                        ->get('count');
                }

                # 修改订单状态
                $order_data = array(
                    'status' => 1,
                    'submit_time' => date('Y-m-d H:i:s'),
                    'operator' => $respond->get_pay_user(),
                    'trade_no' => $respond->get_payment_no(),
                    'notify_id' => $respond->get_id(),
                );
                DB::update('imgup_upgrade')->set($order_data)->where('id', '=', $row['id'])->execute();
                $user_time = ORM::factory('user',$uid)->expire_time;
                    $order_data = array(
                        'status' => 'approved',
                        'expire_time' => strtotime($row['will_exceed']),
                        'fee_day' => round($fee_day, 2),
                        'rank' => $row['dest_group'],
                    );
                    // 赠送空间数
                    switch ($row['dest_group']) {

                        default:
                            $gift = 0;break;
                    }
                    $order_data['gift'] = $gift;
                    DB::update('users')->set($order_data)->where('uid', '=', $row['uid'])->execute();
                    # 处理屏蔽表数据
                    DB::update('imgup_deny_user')->set(array('status' => 0))->where('uid', '=', $row['uid'])->execute();


                    # 发送通知邮件
                    $ret = DB::select('username', 'email', 'expire_time')
                        ->from('users')
                        ->where('uid', '=', $row['uid'])
                        ->fetch_row();

                    $receiver = $ret['username'];
                    $receiver_email = $ret['email'];
                    $exceed_date=date("Y-m-d",strtotime($ret['expire_time']));

                    $ret = DB::select('group_name')
                        ->from('imgup_group')
                        ->where('id', '=', $row['current_group'])
                        ->fetch_row();

                    $v_email = $ret['group_name'].',';
                    $ret = DB::select('group_name')
                        ->from('imgup_group')
                        ->where('id', '=', $row['dest_group'])
                        ->fetch_row();
                    $v_email=$v_email.$ret['group_name'].','. $row['will_exceed'];
                    $email_template='F1';
                    $this->send_email($email_template,$receiver,$receiver_email,$v_email);


                # 开放屏蔽帐号
                $disks = ORM::factory('img_disk')->find_all();
                foreach ($disks as $disk) {
                  $dir = '/server/wal8/www/'. $disk->disk_name . '/' . ORM::factory('user', $row['uid'])->save_dir;
                   if(@substr(sprintf('%o', fileperms($dir)), -4) == '0000') {
                        @chmod($dir, 0777);
                   }
                }
            }
            return $respond;
        } else {
            throw new Exception('支付失败,请联系联系客服..');
        }

    }




    /**
     * 发送邮件
     */
    public function send_email($email_template,$receiver,$receiver_email,$v_email)
    {
        $ret = DB::select()->from('imgup_email')->where('name', '=', $email_template)->execute()->current();
        if (!empty($ret)){
            $email_info = $ret;
            $sender_email=iconv("utf-8","gb2312//IGNORE",$email_info['sender_email']);
            $sender=iconv("utf-8","gb2312//IGNORE",$email_info['sender']);
            $subject=iconv("utf-8","gb2312//IGNORE",$email_info['subject']);
            $template=stripcslashes($email_info['template']);
            # 替换变量
            if(!empty($receiver)) $template=str_replace('$NAME$',$receiver,$template);

            $v_email_ret=explode(",",$v_email);
            //echo "\ncount:".count($v_email_ret);
            for($i=0;$i<count($v_email_ret);$i++){
                $template=str_replace('$v'.$i.'$',$v_email_ret[$i],$template);
                //echo '\n $v'.$i.'$'.'='.$v_email_ret[$i];
            }

            $template=iconv("utf-8","gb2312//IGNORE",$template);

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
            $mail->AddAddress($receiver_email,$receiver);
            //$mail->AddReplyTo("service@wal8.com","service");
            $mail->AddReplyTo($sender_email,$sender);
            $mail->IsHTML(true);  // send as HTML
            // 邮件主题
            $mail->Subject = $subject;
            // 邮件内容
            $mail->Body =$template;
            $mail->AltBody ="text/html";
            if($mail->Send()){
                $data = array(
                    'uname' => $receiver,
                    'email' => $receiver_email,
                    'email_template' => $email_template,
                    'send_date' => date('Y-m-d H:i:s'),
                    'status' => 1
                );
                DB::insert('imgup_email_log', array_keys($data))->values(array_values($data))->execute();

            } else {
                $data = array(
                    'uname' => $receiver,
                    'email' => $receiver_email,
                    'email_template' => $email_template,
                    'send_date' => date('Y-m-d H:i:s'),
                    'status' => 0
                );
                DB::insert('imgup_email_log', array_keys($data))->values(array_values($data))->execute();
            }
        }


    }

}