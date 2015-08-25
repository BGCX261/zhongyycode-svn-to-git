<? defined('SYSPATH') or die('No direct script access.');
/**
 * 图片分类 model
 * @author     zhong(小钟) <regulusyun@gmail.com>
 * @copyright  Copyright (c) 2010-10-6
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

class Model_Img_Category extends ORM
{
    /**
     * 设置主健
     *
     */
    protected $_primary_key = 'cate_id';

    /**
     * 插入数据时自动填充的字段
     *
     * @var array
     */
    protected $_created_column = array('column' => 'create_date', 'format' => TRUE);

    /*
     * 与img一对一关系
     */
    protected $_belongs_to = array('imgs' => array('foreign_key' => 'cate_id'));

}