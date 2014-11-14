<?php
    /**
     * 图片处理
     * 缩放、旋转、透明、锐化、翻转、裁剪
     *
     * 一、创建资源
            $imagejpg = imagecreatefromjpeg($jpg);
            $imagepng = imagecreatefrompng($png);
            $imagegif = imagecreatefromgif($gif);
     * 二、获取图片的属性
     *         imagesx(resource)
     *         imagesy(resource)
     *         
     *         getimagesize(filename)
     *         
     * 三、缩放thum()
     *         自己实现的imagecopyresampled方法
     *         可以加入判断图片格式，然后做不同的缩放，一万年设计了图名处理
     *
     * 四、透明处理thum()
     *         png、jpeg透明色都是正常的，只有gif的处理之后透明色不正常
     *         imagecolortransparent()将某个颜色指定为透明色
     *         imagecolorstotal()判断颜色是否在调色板的颜色上
     *         imagecolorsforindex()
     *
     * 五、图片的裁剪
     *         imagecopyresampled
     *         imagecopyresized
     *
     * 六、加水印（文字水印、图片水印）
     *         imagettftext
     *         imagecopy
     *
     * 七、图片的旋转
     *         imagerotate
     *
     * 八、图片的翻转（水平、垂直）
     *         imagecopy
     *
     * 九、锐化
     *         //获取某个像素的颜色索引值
     *         imagecolorat($image, $x, $y);
     *         //根据索引值取出数组
     *         imagecolorsforindex($image, $index);
     */


//图片的基本修改
$jpg = "image/b.jpg";
$png = "image/c.png";
$gif = "image/a.gif";
$imagejpg = imagecreatefromjpeg($jpg);
$imagepng = imagecreatefrompng($png);
$imagegif = imagecreatefromgif($gif);
$green = imagecolorallocate($imagejpg, 0, 255, 0);
imageline($imagejpg, 0, 0, 111, 111, $green);
//输出宽度和高度
echo "imagejpg width:".imagesx($imagejpg)."height:".imagesy($imagejpg)."<br>";
echo "imagepng width:".imagesx($imagepng)."height:".imagesy($imagepng)."<br>";
echo "imagegif width:".imagesx($imagegif)."height:".imagesy($imagegif)."<br>";
//返回图片信息（宽、高、类型等）
$arr = getimagesize($jpg);
var_dump($arr);
//保存更改后的图片
imagejpeg($imagejpg,"image/jpg.jpg");
imagepng($imagepng,"image/png.jpg");
imagegif($imagegif,"image/gif.gif");
//释放资源
imagedestroy($imagejpg);
imagedestroy($imagepng);
imagedestroy($imagegif);

//缩放图片50%
$filename =  "image/b.jpg";
$per = 0.5;
list($width,$height) = getimagesize($filename);
$n_w = $width*$per;
$n_h = $height*$per;
$new = imagecreatetruecolor($n_w, $n_h);
$img = imagecreatefromjpeg($filename);
//拷贝原图片到新图片，并设置宽高
imagecopyresized($new, $img, 0, 0, 0, 0, $n_w, $n_h, $width, $height);
//等比例缩放
imagejpeg($new,"image/new.jpg");
//资源释放
imagedestroy($new);
imagedestroy($img);


$filename =  "image/a.gif";
/**
 * 等比例缩放
 * @param 源 $res
 * @param 缩放后的最大宽 $width
 * @param 缩放后的最大高 $height
 * @param 目标 $new
 */
function thum($res,$width,$height,$newname){
    list($s_w,$s_h) = getimagesize($res);
    if ($width && ($s_w < $s_h)) {
        $width = ($height / $s_h) * $s_w;
    } else {
        $height = ($width / $s_w) * $s_h;
    }
    $newfile = imagecreatetruecolor($width, $height);
    $img = imagecreatefromgif($res);
    
    $otsc = imagecolortransparent($img);
    //如果存在透明色
    if ($otsc>=0 && $otsc < imagecolorstotal($img)){
        //查找索引颜色的值
        $tran = imagecolorsforindex($img, $otsc);
        //去除透明色的背景颜色
        $newcolor = imagecolorallocate($newfile, $tran["red"], $tran["green"], $tran["blue"]);
        imagefill($newfile, 0, 0, $newcolor);
        //将新图片的地方指定透明色
        imagecolortransparent($newfile,$newcolor);
    }
    //开始拷贝，透明色的时候用imagecopyresized才没有雪花
    imagecopyresized($newfile, $img, 0, 0, 0, 0, $width, $height, $s_w, $s_h);
    imagegif($newfile,$newname);
    imagedestroy($img);
    imagedestroy($newfile);
}
thum($filename, 100, 200, "image/thum.gif");

/**
 * 裁剪图片
 * @param 源 $res
 * @param 从源的x哪里开始裁剪 $c_x
 * @param 从源的y哪里开始裁剪 $c_y
 * @param 裁剪的宽度 $c_w
 * @param 裁剪的高度 $c_h
 * @param 目标 $newname
 */
$filename =  "image/b.jpg";
function cut($res,$c_x,$c_y,$c_w,$c_h,$newname){
    $img = imagecreatefromjpeg($res);
    $new = imagecreatetruecolor($c_w, $c_h);
    imagecopyresized($new, $img, 0, 0, $c_x, $c_y, $c_w, $c_h, $c_w, $c_h);
    imagejpeg($new,$newname);
    imagedestroy($img);
    imagedestroy($new);
}
cut($filename, 12, 12, 50, 50, "image/cut.jpg");

/**
 * 设置文字水印
 * @param 源 $res
 * @param 文字 $text
 * @param 设置文字位置x $x
 * @param 设置文字位置y $y
 * @param 设置新图片的名字 $newname
 */
function mark_text($res,$text,$x,$y,$newname){
    $img = imagecreatefromjpeg($res);
    $color = imagecolorallocate($img, 0, 255, 0);
    $text = iconv("UTF-8", "GB2312", $text);
    imagettftext($img, 20, 0, $x, $y, $color, "ADOBEHEITISTD-REGULAR.OTF", $text);
    imagejpeg($img,$newname);
    imagedestroy($img);
}
mark_text($filename, "我操", 51, 53,"image/mark_text.jpg");

/**
 * 设置图片水印
 * @param 源 $res
 * @param 图片水印 $text
 * @param 设置文字位置x $x
 * @param 设置文字位置y $y
 * @param 设置新图片的名字 $newname
 */
function mark_pic($res,$pic,$x,$y,$newname){
    $img = imagecreatefromjpeg($res);
    $water = imagecreatefromjpeg($pic);
    
    $w_w = imagesx($water);
    $w_h = imagesy($water);
    //将图片拷贝到另一个图片之上
    imagecopy($img, $water, $x, $y, 0, 0, $w_w, $w_h);
    imagejpeg($img,$newname);
    
    imagedestroy($water);
    imagedestroy($img);
}
mark_pic($filename, "image/new.jpg", 51, 53,"image/mark_pic.jpg");

/**
 * 旋转角度
 * @param 文件源 $res
 * @param 旋转角度 $angle
 * @param 新颜色的背景颜色 $bgd_color
 * @param 生成新图片的名字 $newname
 */
function rotate($res,$angle,$bgd_color,$newname){
    $img = imagecreatefromjpeg($res);
    $new = imagerotate($img, $angle, $bgd_color);
    imagejpeg($new,$newname);
    imagedestroy($img);
}
rotate($filename, 45, 0, "image/rotate.jpg");

$filename =  "image/b.jpg";
/**
 * 图片的翻转
 * @param 源 $res
 * @param 新文件名字 $newname
 * @param 翻转的中心轴 $axle
 */
function turn($res,$newname,$axle="x"){
    $img = imagecreatefromjpeg($res);
    $i_w = imagesx($img);
    $i_h = imagesy($img);
    $newfile = imagecreatetruecolor($i_w, $i_h);
    if ($axle=="y"){
        for ($i = 0; $i < $i_w; $i++) {
            imagecopy($newfile, $img, $i_w-$i-1, 0, $i, 0, 1, $i_h);
        }
    }else{
        for ($i = 0; $i < $i_h; $i++) {
            imagecopy($newfile, $img, 0, $i_h-$i-1, 0, $i, $i_w, 1);
        }
    }
    imagejpeg($newfile,$newname);
    imagedestroy($img);
    imagedestroy($newfile);
}
turn($filename,"image/turn_y.jpg","y");
turn($filename,"image/turn_x.jpg");

/**
 * 锐化操作
 * @param 源 $res
 * @param 新文件名字 $newname
 * @param 锐化程度 $degree
 */
function sharp($res,$newname,$degree){
    $img = imagecreatefromjpeg($res);
    $newfile = imagecreatefromjpeg($res);
    $i_w = imagesx($img);
    $i_h = imagesy($img);
    
    for ($i = 1; $i < $i_w; $i++) {
        for ($j = 1; $j < $i_h; $j++) {
            $b_c1 = imagecolorsforindex($img, imagecolorat($img, $i-1, $j-1));
            $b_c2 = imagecolorsforindex($img, imagecolorat($img, $i, $j));
            
            $r = intval($b_c2["red"]+$degree*($b_c2["red"]-$b_c1["red"]));
            $g = intval($b_c2["green"]+$degree*($b_c2["green"]-$b_c1["green"]));
            $b = intval($b_c2["blue"]+$degree*($b_c2["blue"]-$b_c1["blue"]));
            
            //限制在0到255之间
            $r = min(255,max($r,0));
            $g = min(255,max($g,0));
            $b = min(255,max($b,0));
            
            if (($d_clr = imagecolorexact($newfile, $r, $g, $b))==-1){
                $d_clr = imagecolorexact($newfile, $r, $g, $b);
            }
            
            imagesetpixel($newfile, $i, $j, $d_clr);
        }
    }
    imagejpeg($newfile,$newname);
    imagedestroy($img);
    imagedestroy($newfile);
}
sharp($filename, "image/sharp.jpg", 2);
?>