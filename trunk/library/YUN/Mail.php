<?php
/**
 * 邮件发送类
 *
 * 修复 Zend_Mail 发送邮件时标题过长的 BUG
 *
 * @author     regulusyun(軒轅雲) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_Mail extends Zend_Mail
{

    /**
     * Encode header fields
     *
     * Encodes header content according to RFC1522 if it contains non-printable
     * characters.
     *
     * @param  string $value
     * @return string
     */
    protected function _encodeHeader($value)
    {
        if (Zend_Mime::isPrintable($value)) {
            return $value;
        } else {
            $quotedValue = Zend_Mime::encodeQuotedPrintable($value, 400);
            $quotedValue = str_replace(array('?', ' ', '_'), array('=3F', '=20', '=5F'), $quotedValue);
            return '=?' . $this->_charset . '?Q?' . $quotedValue . '?=';
        }
    }

    /**
     * Sends this email using the given transport or a previously
     * set DefaultTransport or the internal mail function if no
     * default transport had been set.
     *
     * @param  Zend_Mail_Transport_Abstract $transport
     * @return Zend_Mail                    Provides fluent interface
     */
    public function send($transport = null)
    {
        try {
            parent::send($transport);
        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }

}