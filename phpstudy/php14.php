<?php
    /**
     * php图像处理
     * 需要安装GD库
     * windows:php.ini中;extension=php_gd2.dll把前面的;去掉....
     *
     * 1.画图（验证码，统计图）
     *         一：创建画布（资源模型、宽高）
     *             resource imagecreate(int $x_size , int $y_size)
     *             resource imagecreatetruecolor(int $x_size , int $y_size)推荐使用
     *         二：绘制图像（矩形、圆、扇形、文字、制定颜色等）
     *         三：输出图像/保存图像
     *             imagegif($imageResource);
     *             imagejpeg($imageResource);
     *             imagepng($imageResource);
     *         四：释放资源
     *
     * 2.处理图片（图片缩放，水印，电子相册）
     *
     * GIF PNG JPG WBMP XPM(主要看服务器安装的格式)
     *
     * FreeType Type1 宋体 黑体...
     */
	//1.创建图像
	$width = 200;
	$height = 200;
	//imagecolorallocate($imageResource, $red, $green, $blue);
	$imageResource = imagecreatetruecolor($width, $height);
	$green = imagecolorallocate($imageResource, 0, 125, 0);
	$blue = imagecolorallocate($imageResource, 0, 0, 125);
	$red = imagecolorallocate($imageResource, 125, 0, 0);
	$green1 = imagecolorallocate($imageResource, 0, 75, 0);
	$blue1 = imagecolorallocate($imageResource, 0, 0, 75);
	$red1 = imagecolorallocate($imageResource, 75, 0, 0);
	$wit = imagecolorallocate($imageResource, 200, 200, 200);
	imagefill($imageResource, 50, 50, $wit);
	//2.画图
    //画一个矩形并填充
    imagefilledrectangle($imageResource, 50, 50, 100, 100, $red);
    //画一个矩形
    imagerectangle($imageResource, 100, 100, 150, 150, $red);
    //线
    imageline($imageResource, 100, 100, 160, 160, $red);
    //点
    imagesetpixel($imageResource, 125, 125, $red);
    //椭圆
    imageellipse($imageResource, 50, 160, 10, 40, $red);
    //3d
    for ($i = 60; $i > 50; $i--) {
        imagefilledarc($imageResource, 50, $i, 100, 50, -160, 40, $green1, IMG_ARC_PIE);
        imagefilledarc($imageResource, 50, $i, 100, 50, 40, 75, $red1, IMG_ARC_PIE);
        imagefilledarc($imageResource, 50, $i, 100, 50, 75, 200, $blue1, IMG_ARC_PIE);
    }
        imagefilledarc($imageResource, 50, $i, 100, 50, -160, 40, $green, IMG_ARC_PIE);
        imagefilledarc($imageResource, 50, $i, 100, 50, 40, 75, $red, IMG_ARC_PIE);
        imagefilledarc($imageResource, 50, $i, 100, 50, 75, 200, $blue, IMG_ARC_PIE);
    //画字符水平
    imagechar($imageResource, 5, 120, 120, "A", $blue);
    //画字符垂直
    imagecharup($imageResource, 8, 130, 130, "C", $blue);
    //画字符串水平
    imagestring($imageResource, 5, 140, 140, "Hello", $blue);
    //画字符串垂直
    imagestringup($imageResource, 8, 180, 180, "Hello", $blue);
    //设置字体（把字体库靠过来）
    $str = iconv("UTF-8", "GB2312", "中国");
    imagettftext($imageResource, 25, 60, 60, 60, $red, "ADOBEHEITISTD-REGULAR.OTF", $str);

//3.输出图像
    header("Content-Type:image/gif");
    imagegif($imageResource);
    //imagejpeg($imageResource);
    //imagepng($imageResource);
//4.释放资源
    imagedestroy($imageResource);    

?>