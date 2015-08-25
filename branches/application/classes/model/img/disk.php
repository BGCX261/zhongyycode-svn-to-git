<? defined('SYSPATH') or die('No direct script access.');
/**
 * 图片硬盘目录 model
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-6
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_Img_Disk extends ORM
{


    /**
     * 插入数据时自动填充的字段
     *
     * @var array
     */
    protected $_created_column = array('column' => 'add_date', 'format' => TRUE);



}