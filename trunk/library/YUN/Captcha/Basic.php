<?php
/**
 * EGP Framework
 *
 * LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */

!defined('LIB_DIR') && die('Access Deny!');

/**
 * 图形验证码基础驱动类
 *
 * @package    classes
 * @author     Akon(番茄红了) <aultoale@gmail.com>
 * @copyright  Copyright (c) 2008 (http://www.tblog.com.cn)
 * @license    http://www.gnu.org/licenses/gpl.html     GPL 3
 */
class YUN_Captcha_Basic extends YUN_Captcha_Abstract
{

    /**
     * 创建图像
     *
     * @return resource
     */
    protected function _createImage()
    {
        if (!is_resource($this->_image)) {
            extract($this->_options); //解出参数到变量

            $this->_image = imagecreatetruecolor($width, $height);

            $color1 = imagecolorallocate($this->_image, mt_rand(200, 255),
                                         mt_rand(200, 255), mt_rand(150, 255));
            $color2 = imagecolorallocate($this->_image, mt_rand(200, 255),
                                         mt_rand(200, 255), mt_rand(150, 255));
            $color1 = imagecolorsforindex($this->_image, $color1);
            $color2 = imagecolorsforindex($this->_image, $color2);
            $steps = $width;

            $r1 = ($color1['red'] - $color2['red']) / $steps;
            $g1 = ($color1['green'] - $color2['green']) / $steps;
            $b1 = ($color1['blue'] - $color2['blue']) / $steps;

            $x1 = 0; $y1 =& $i; $x2 = $width; $y2 =& $i;

            for ($i = 0; $i <= $steps; $i++) {
                $r2 = $color1['red'] - floor($i * $r1);
                $g2 = $color1['green'] - floor($i * $g1);
                $b2 = $color1['blue'] - floor($i * $b1);
                $color = imagecolorallocate($this->_image, $r2, $g2, $b2);
                imageline($this->_image, $x1, $y1, $x2, $y2, $color);
            }

            for ($i = 0, $count = mt_rand(10, 20); $i < $count; $i++) {
                $color = imagecolorallocatealpha($this->_image, mt_rand(20, 255), mt_rand(20, 255),
                                                 mt_rand(100, 255), mt_rand(80, 120));
                imageline($this->_image, mt_rand(0, $width), 0,
                          mt_rand(0, $width), $height, $color);
            }
        }
        return $this->_image;
    }

    /**
     * 生成图像
     *
     * @param  string  $phrase
     * @return resource
     * @throws Exception
     */
    public function generateImage($phrase = null)
    {
        null == $phrase && $phrase = $this->generatePhrase();

        extract($this->_options); //解出参数到变量
        $image = $this->_createImage(); //创建图像

        $defaultSize = min($width, $height * 2) / (strlen($phrase) + 1);
        $spacing = (integer) ($width * 0.9 / strlen($phrase));

        empty($fonts) && $fonts = YUN_Io::scan(strip($fontDir));
        if (empty($fonts))
            throw new Exception('未找到任何有效的字体文件');

        for ($i = 0, $strlen = strlen($phrase); $i < $strlen; $i++) {
            $font = $fontDir . '/' . $fonts[array_rand($fonts)];
            $color = imagecolorallocate($image, mt_rand(0, 160),
                                        mt_rand(0, 160), mt_rand(0, 160));
            $angle = mt_rand(-30, 30);
            $size = $defaultSize / 10 * mt_rand(12, 14);
            $box = imageftbbox($size, $angle, $font, $phrase[$i]);
            $x = $spacing / 4 + $i * $spacing + 2;
            $y = $height / 2 + ($box[2] - $box[5]) / 4;
            imagefttext($image, $size, $angle, $x, $y, $color, $font, $phrase[$i]);
        }

        $this->_image = $image;

        return $this->_image;
    }

}