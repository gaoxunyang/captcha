<?php
namespace Base;
class Img
{
    public $width;
    public $height;

    private $_image;

    const INTERFERING_LINE_COUNT = 5;
    const NOISE_COUNT = 50;

    public function __construct($width, $height)
    {
        $this->width  = $width;
        $this->height = $height;
        $this->_image = imagecreatetruecolor($width, $height);
    }

    public function getCapcha($str)
    {
        //draw rectangle
        $this->_createRectangle();

        //draw line
        $this->_createInterferingLine(self::INTERFERING_LINE_COUNT);

        //draw noise
        $this->_createNoise(self::NOISE_COUNT);

        //draw string
        $this->_createText($str);
    }

    private function _createRectangle()
    {
        $backColor = imagecolorallocate($this->_image, 235, 236, 237);
        imagefilledrectangle($this->_image, 0, 0, $this->width, $this->height, $backColor);
    }

    private function _createInterferingLine($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $fontColor = imagecolorallocate($this->_image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
            imagearc($this->_image, mt_rand(-$this->width, $this->width), mt_rand(-$this->height, $this->height),
                mt_rand(30, $this->width * 2), mt_rand(20, $this->height * 2), mt_rand(0, 360), mt_rand(0, 360), $fontColor);
        }
    }

    private function _createNoise($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $fontColor = imagecolorallocate($this->_image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagesetpixel($this->_image, mt_rand(0, $this->width), mt_rand(0, $this->height), $fontColor);
        }
    }

    private function _createText($str)
    {
        $fontColor = imagecolorallocate($this->_image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
        imagestring($this->_image, 2, 5, 5, $str, $fontColor);
        imagepng($this->_image);
        imagedestroy($this->_image);
    }
}