<?php
/**
 * file Model
 *
 * @package    model
 * @author     regulusyun(轩辕云) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2009
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class FileModel extends YUN_Abstract
{

    /**
     * 文件存放基本路径
     *
     * @var string
     */
    public $fileBasePath = null;

    /**
     * 构造方法
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileBasePath = $this->config->upload->savePath;
    }

    /***************************************************************************
     * 文件
     **************************************************************************/

    /**
     * 获取文件列表的 SQL
     *
     * @return EGP_Db_Select
     */
    public function listSql()
    {
        return $this->db->select()
            ->from('file')
            ->join(
                array('cate' => 'file_category'),
                'file.cate_id=cate.cate_id',
                array('cate_name', 'allow_delete')
            )
            ->joinLeft(
                'user',
                'user.uid=file.uid',
                'username'
            )
            ->order('file.upload_time DESC');
    }

    /**
     * 查询文件信息的 SQL
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
     * 查询文件是否存在
     * @param  string  $where
     * @return boolean
     */
    public function exists($where)
    {
        $select = $this->infoSql($where);
        $info = $this->fetchRow($select);
        return empty($info) ? false : true;
    }

    /**
     * 添加文件上传数据
     * @param  array    $postData
     * @param  array    $fileData
     * @param  boolean  $onlyImage
     * @return array
     * @throws Exception
     */
    public function add(array $postData, array $fileData, $onlyImage = false)
    {

        $validator = $this->_validate($postData);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }

        $where = $this->db->quoteInto('cate_id=?', $postData['cate_id']);
        $cateInfo = $this->cateInfoSql($where);

        if (empty($cateInfo)) {
            throw new Exception('指定的分类不存在');
        }

        if (!$cateInfo['allow_upload']) {
            throw new Exception('该分类被设置为禁止上传');
        }

        $config = $this->config->upload;
        $path = trim($cateInfo['filepath'], '\\/');
        $config->savePath = $config->savePath . "/$path/" . date('ym');


        $upload = new YUN_File_Upload($config);

        if ($onlyImage && !$upload->isImage($fileData['name'])) {
            throw new Exception('仅允许上传图片文件');
        }

        $result = $upload->save($fileData);

        if ($result === false) {
            throw new Exception($upload->getMessage());
        }

        $result = $upload->getResult();

        //判断数据库中是否记录了同样的文件
        $md5Hash = md5_file($result['savename']);
        $info = $this->db->select()->from('file')->where('md5_hash=?', $md5Hash)->limit(1);
        $info = $this->db->fetchRow($info);
        if (!empty($info)) {
            @unlink($result['savename']);
            return $info;
        }

        $data = array(
            'cate_id'       => $postData['cate_id'],
            'uid'           => $postData['uid'],
            'upload_time'   => time(),
            'download'      => 0,
            'description'   => htmlspecialchars($postData['description']),
            'filename'      => $result['filename'],
            'filesize'      => $result['filesize'],
            'filetype'      => $result['filetype'],
            'extension'     => $result['extension'],
            //'savename'      => str_replace(array(WEB_DIR, '\\'), array('', '/'), $result['savename']),
            'savename'      => str_replace(array(strip(WWW_DIR), '\\'), array('', '/'), $result['savename']),
            'is_image'      => (int) $upload->isImage($result['filename']),
            'md5_hash'      => $md5Hash
        );

        $this->db->insert('file', $data);
        $fileId = $this->db->lastInsertId();
        $data['file_id'] = $fileId;
    }

    /**
     * 删除上传的文件
     * @param  integer  $fileId
     * @throws Exception
     */
    public function delete($fileId)
    {
        $where = $this->db->quoteInto('file_id=?', (integer) $fileId);
        $select = $this->infoSql($where);
        $info = $this->db->fetchRow($select);

        if (empty($info)) {
            throw new Exception('指定的文件不存在或者已经被删除');
        }

//        if (!$info['allow_delete']) {
//            throw new Exception('受分类限定，无法删除该文件');
//        }

        $abspath = WWW_DIR . $info['savename'];
        if (!$info['is_image']) {
            //TODO: 删除所有缩略图
        }
        @unlink($abspath);

        $this->db->delete('file', $where);
    }


    /**
     * 验证文件上传 POST 数据
     *
     * @param  array  $data
     * @return EGP_Validator
     */
    protected function _validate(array $data)
    {
        $validator = new YUN_Validator();
        return $validator->check(
                @$data['cate_id'],
                array(
                    array('NotEmpty', '文件分类 ID 不能为空'),
                    array('Integer', '文件分类 ID 必须是一个数字')
                )
            )
            ->check(
                @$data['description'],
                array(
                    array('StringLength' => array(0, 250), '文件描述不能超过 250 个字符')
                )
            );
    }

    /***************************************************************************
     * 文件分类
     **************************************************************************/

    /**
     * 获取分类列表的SQL
     *
     * @return EGP_Db_Select
     */
    public function cateListSql()
    {
        return $this->db->select()
            ->from(array('cate' => 'file_category'));
    }

    /**
     * 根据条件获取分类信息的SQL
     *
     * @param  string  $where
     * @return array
     */
    public function cateInfoSql($where)
    {
        $select = $this->db->select()
            ->from(array('cate' => 'file_category'))
            ->where($where);
        return    $this->db->fetchRow($select);
    }

    /**
     * 根据条件查询分类是否存在
     * @param  string  $where
     * @return boolean
     */
    public function cateExists($where)
    {
        $cateInfo = $this->cateInfoSql($where);
        return empty($cateInfo) ? false : true;
    }

    /**
     * 添加分类
     * @param  array  $data
     * @return integer
     * @throws Exception
     */
    public function cateAdd(array $data)
    {
        $validator = $this->_validateCate($data);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }

        $data = array(
            'cate_name' => htmlspecialchars($data['cate_name']),
            'filepath' => strip_tags($data['filepath']),
            'description' => htmlspecialchars($data['description']),
            'allow_upload' => (integer) @$data['allow_upload'],
            'allow_delete' => (integer) @$data['allow_delete'],
        );

        $where = $this->db->quoteInto('cate.cate_name=?', $data['cate_name']);
        if ($this->cateExists($where)) {
            throw new Exception("指定的分类名称 '{$data['cate_name']}' 已经存在");
        }

        $where = $this->db->quoteInto('cate.filepath=?', $data['filepath']);
        if ($this->cateExists($where)) {
            throw new Exception("指定的路径 '{$data['filepath']}' 已经被占用");
        }

        $abspath = $this->fileBasePath . "/" . $data['filepath'];
        if (!is_dir($abspath)) {
            $mk = YUN_Io::mkdir($abspath);
            if ($mk === false) {
                throw new Exception("无法创建分类目录 '{$data['filepath']}'");
            }
        }

        $this->db->insert('file_category', $data);
        return $this->db->lastInsertId();
    }

    /**
     * 编辑分类
     * @param  array  $set
     * @throws Exception
     */
    public function cateEdit(array $set)
    {
        if (isset($set['cate_id'])) {
            $cateId = (integer) $set['cate_id'];
            $where = $this->db->quoteInto('cate.cate_id=?', $cateId);
            if (!$this->cateExists($where)) {
                throw new Exception('指定的分类不存在');
            }
        }

        $validator = $this->_validateCate($set);
        if (!$validator->isValid()) {
            throw new Exception($validator->getMessage());
        }

        $set = array(
            'cate_name' => htmlspecialchars($set['cate_name']),
            'filepath' => strip_tags($set['filepath']),
            'description' => htmlspecialchars($set['description']),
            'allow_upload' => (integer) @$set['allow_upload'],
            'allow_delete' => (integer) @$set['allow_delete'],
        );

        $where = $this->db->quoteInto('cate.cate_name=?',
                                      $set['cate_name']);
        if ($this->cateExists($where)) {
            throw new Exception("指定的分类名称 '{$set['cate_name']}' 已经存在");
        }

        $where = $this->db->quoteInto('cate.filepath=?',
                                      $set['filepath']);
        if ($this->cateExists($where)) {
            throw new Exception("指定的路径 '{$set['filepath']}' 已经被占用");
        }

        $abspath = $this->fileBasePath . "/" . $set['filepath'];
        if (!is_dir($abspath)) {
            $mk = YUN_Io::mkdir($abspath);
            if ($mk === false) {
                throw new Exception("无法创建分类目录 '{$set['filepath']}'");
            }
        }

        $where = $this->db->quoteInto('cate_id=?', $cateId);
        $this->db->update('file_category', $set, $where);
    }

    /**
     * 清空分类目录
     * @param integer $cateId
     * @throws Exception
     */
    public function cateClean($cateId)
    {
        $where = $this->db->quoteInto('cate_id=?', $cateId);
        $cateInfo = $this->cateInfoSql($where);

        if (empty($cateInfo)) {
            throw new Exception('指定的分类不存在');
        }

        if (!$cateInfo['allow_delete']) {
            throw new Exception('该分类被设置为禁止删除');
        }

        $abspath = $this->fileBasePath . "/" . $cateInfo['filepath'];
        if (is_dir($abspath)) {
            $result = EGP_Io::rmdir($abspath);
            if ($result == false) {
                throw new Exception('部分文件无法清除，请手动清除');
            }
        }

        @mkdir($abspath, 0777, true); //重建目录
    }

    /**
     * 删除分类
     * @param  integer  $cateId
     * @throws Exception
     */
    public function cateDel($cateId)
    {
        $where = $this->db->quoteInto('cate_id=?', $cateId);
        $cateInfo = $this->cateInfoSql($where);

        if (empty($cateInfo)) {
            throw new Exception('指定的分类不存在');
        }

        if (!$cateInfo['allow_delete']) {
            throw new Exception('该分类被设置为禁止删除');
        }

        $abspath = $this->fileBasePath . "/" . $cateInfo['filepath'];
        if (is_dir($abspath)) {
            $files = YUN_Io::scan($abspath);
            if (!empty($files)) {
                throw new Exception('分类目录不为空，无法删除');
            }
            rmdir($abspath);
        }

        $this->db->delete('file_category', $where);
        $this->db->delete('file', $where);
    }

    /**
     * 验证分类 POST 数据
     * @param  array  $data
     * @return EGP_Validator
     */
    protected function _validateCate(array $data)
    {
        $validator = new YUN_Validator();
        return $validator->check(
                $data['cate_name'],
                array(
                    array('NotEmpty', '分类名称不能为空'),
                    array('StringLength' => array(1, 50), '分类名称不能超过 50 个字符'),
                )
            )
            ->check(
                $data['filepath'],
                array(
                    array('NotEmpty', '分类存放路径不能为空'),
                    array('Regex' => '/^[a-z_][\w\/]+$/i', '分类存放路径包含非法字符'),
                    array('StringLength' => array(1, 100), '分类存放路径不能超过 100 个字符')
                )
            )
            ->check(
                $data['description'],
                array(
                    array('StringLength' => array(0, 250), '分类描述不能超过 250 个字符')
                )
            )
            ->check(
                intval(@$data['allow_upload']),
                array(
                    array('Boolean', '分类是否允许上传文件必须是一个布尔值'),
                )
            )
            ->check(
                intval(@$data['allow_delete']),
                array(
                    array('Boolean', '分类是否允许删除文件必须是一个布尔值'),
                )
            );
    }

}