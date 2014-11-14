<?php

    class ValidationCode{
        private $width;
        private $height;
        private $codeNum;
        private $image;
        private $disturbColorNum;
        private $checkCode;
        
        function __construct($width=80,$height=20,$codeNum=4){
            $this->width = $width;
            $this->height = $height;
            $this->codeNum = $codeNum;
            $this->checkCode = $this->createCode();
            //取整数
            $this->disturbColorNum = floor($width*$height/15);
        }
    
        /**
         * 向浏览器中输出验证码
         */
        function showImage($fontface=""){
            //第一步：创建图像背景
            $this->getCreateImage();
            //第二步：设置干扰元素
            $this->setDisturColor();
            //第三步：想图像中画出文本
            $this->outPutText($fontface);
            //第四部：输出图像
            $this->outPutImage();
        }
        /**
         * 获取验证码上的字符串
         */
        function getCheckCode(){
            return $this->checkCode;
        }
        /**
         * 创建图像
         */
        private function getCreateImage(){
            //创建图像资源
            $this->image = imagecreatetruecolor($this->width, $this->height);
            //随即背景色
            $backColor = imagecolorallocate($this->image, rand(180, 225), rand(180, 225), rand(180, 225));
            //填充背景颜色
            imagefill($this->image, 0, 0, $backColor);
            //设置边框颜色
            $border = imagecolorallocate($this->image, 0, 0, 0);
            //画出边框
            imagerectangle($this->image, 0, 0, $this->width-1, $this->height-1, $border);
        }
        /**
         * 创建干扰元素
         */
        private function setDisturColor(){
            for ($i = 0; $i < $this->disturbColorNum; $i++) {
                //设置颜色
                $color = imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
                imagesetpixel($this->image, rand(1, $this->width-2), rand(1, $this->height-2), $color);
            }
            for ($i = 0; $i < 10; $i++) {
                //设置颜色
                $color = imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
                imagearc($this->image, rand(-10, $this->width), rand(-10, $this->height), rand(30, 300), rand(30, 200), 50, 40, $color);
            }
        }
        /**
         * 创建输出文本
         */
        private function outPutText($fontface=""){
            for ($i = 0; $i < $this->codeNum; $i++) {
                $color = imagecolorallocate($this->image, rand(0, 150), rand(0, 150), rand(0, 150));
                if ($fontface==""){
                    $font = rand(3, 5);
                    $x = floor($this->width/$this->codeNum)*$i+3;
                    $y = rand(0, $this->height-15);
                    imagechar($this->image, $font, $x, $y, $this->checkCode{$i}, $color);
                }else{
                    $size = rand(12, 15);
                    $angle = rand(-30, 30);
                    $x = floor(($this->width-8)/$this->codeNum)*$i+8;
                    $y = rand($size, $this->height);
                    imagettftext($this->image, $size, $angle, $x, $y, $color, $fontface, $this->checkCode{$i});
                }
            }
        }
        private function createCode(){
            $code = "23456789qwertyuipkjhgfdsazxcvbnmQWERTYUPLKJHGFDSAZXCVBNM";
            $str = '';
            for ($i = 0; $i < $this->codeNum; $i++) {
                $char = $code{rand(0, strlen($code)-1)};
                $str .= $char;
            }
            return $str;
        }
        /**
         * 创建输出图像
         */
        private function outPutImage(){
            if (imagetypes() & IMG_GIF){
                header("Content-Type:image/gif");
                imagegif($this->image);
            }else if (imagetypes() & IMG_JPG){
                header("Content-Type:image/jpeg");
                imagejpeg($this->image);
            }else if (imagetypes() & IMG_PNG){
                header("Content-Type:image/png");
                imagepng($this->image);
            }else{
                die("php不支持图片创建");
            }
        }
        /**
         * 析构函数
         */
        function __destruct(){
            imagedestroy($this->$image);
        }
    }
?>

