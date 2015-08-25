<?php
/**
 * file Model
 *
 * @package    model
 * @author     yun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009 (http://www.yunphp.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class FileModel extends YUN_Abstract
{

    /**
     * 取出文件信息
     * @param  string  $where
     * @return EGP_Db_Select
     */
    public function infoSql($where)
    {
        return $this->db->select()
            ->from('file')
            ->where($where);
    }

    /**
     * 下载文件
     * @param  integer  $fileId
     * @throws Exception
     */
    public function download($fileId)
    {
        $where = $this->db->quoteInto('file_id=?', (integer) $fileId);
        $info = $this->infoSql($where);
        $info = $this->db->fetchRow($info);

        if (empty($info) || !is_readable(WWW_DIR . $info['savename'])) {
            throw new Exception('指定的文件不存在或者已经被删除');
        }

        $set = array(
            'download' => $info['download'] + 1
        );
        $this->db->update('file', $set, $where);

        $filename = WWW_DIR . $info['savename'];

        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header('Content-Length: ' . filesize($filename));
        header('Content-Disposition: attachment; filename=' . basename($info['filename']));
        readfile($filename);
        $this->isload = false;
    }

}