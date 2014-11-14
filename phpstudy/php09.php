<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");
/**
 * 资源类型一定要记得关闭:fclose($file);
 *
 * 文件一般处理函数
 * 1.打开文件函数
 *         $file = fopen($filename,mode)
 *         第一个：目的文件名称
 *             已存在或者未存在；或者网络文件，
 *             读取远程文件只能读不能写模式
 *             ftps/ftp/https/http
 *             php.ini中的allow_url_fopen = on;
 *         第二个：打开模式(w、r、wb)
 *             r：    只读方式，必须是已存在的；指针指向文件开头
 *             r+:    以读写的方式；指针指向文件开头
 *             w：    写文件，打开一个文件，并将文件内容情况
 *            w+:    以读写的方式打开，指向开头
 *             a：    以写入的模式，追加模式
 *             x:  创建并以写入方式打开，如果文件存在会打开失败；如果不存在，则创建一个新的文件；只能打开本地文件
 *             x+：创建并以读写的方式打开，如果文件存在会打开失败；如果不存在，则创建一个新的文件；只能打开本地文件
 *             b:    只限于windows（会附加在上述模式的后面，标示打开的是二进制文件）
 *             t:    只限于windows（会附加在上述模式的后面，将所有行结束符转化为\r\n）
 *             目录链接分隔符：DIRECTORY_SEPARATOR
 * 2.写入文件函数
 *         fwrite($file,$string,$length)
 *             第一个：写入的资源
 *             第二个：写入的字符串
 *             第三个：写入的字符串长度，默认是将第二个参数全部写入
 *         fputs
 * 3.读取文件：fread($file,$length)
 * 4.读取文件大小：filesize($filename)
 * 5.读取一行：fgets($file,$length)
 * 6.读取一个字符：fgetc($file)
 * 7.文件结尾判断函数：feof($file)!==false//用全不等来判断因为0
 * 8.按行读取文件
 *         $array = file($filename);
 *         不用打开文件，直接就用file就可以读。然后直接遍历数组就可以了。
 * 9.读入一个文件并直接输出到对方缓存当中readfile($filename)
 * 10.判断文件是否存在file_exists($filename)
 *
 * 11.读取文件，不用打开也不用关闭
 *         $str = file_get_contents($filename);
 *         可以打开本地和远程文件
 * 12.写入文件，不用打开也不用关闭
 *         file_put_contents($filename, $data);
 *         可以写入本地
 *
 * 13.防止并发访问fopen的写入
 *         flock($file, $operation);
 *         文件引用和访问权限；权限如下：
 *             LOCK_SH ：    共享锁定；读文件时使用
 *             LOCK_EX :    独占锁定；写文件时使用
 *             LOCK_UN ：    释放锁定；释放上两个锁
 *             LOCK_NB :    附加锁定；
 *         已经被锁定的文件再次被锁定的时候，会被挂起；
 *         为防止多人同时锁定可以用
 *         if (!flock($fileR, LOCK_SH+LOCK_NB))
 *         if (!flock($fileR, LOCK_UN+LOCK_NB))
 * 14.文件指针位置的函数
 *         $curent = ftell($file)返回当前文件指针的位置
 *         fseek($file,$movLength,$star)移动文件指针到指定位置
 *         $star:
 *             SEEK_SET：从文件开始；默认
 *             SEEK_END：从文件末尾；距离可以为负数
 *             SEEK_CUR：当前位置开始；
 *         rewind($file)移动文件指针到文件开始处
 * 15.文件操作
 *         copy($source, $dest)填写源文件路径和要拷贝到的位置
 *         unlink($filename)    删除文件；成功返回真
 *         rename($oldname, $newname)重命名；成功返回真
 *         ftruncate($file, $size)截取文件；删除其他的字符
 * 16.文件属性
 *         filectime($filename)文件创建时间
 *         filemtime($filename)文件修改时间
 *         fileatime($filename)文件最后访问时间
 *         file_exists($filename)文件是否存在
 *         filesize($filename)文件大小
 *         filetyep($filename)文件类型
 *         is_dir($filename)文件是否是目录
 *         is_file($filename)文件是否是文件
 *         is_link($filename)文件是否是链接
 *         is_executable($filename)文件是否可执行
 *         is_readable($filename)文件是否可读
 *         is_writable($filename)文件是否可写
 *         chmod rwx rwx rwx r=4 w=2 x=1 (拥有者，用户组，其他)
 *         chmod($filename, 644);更改权限
 *         chown($filename, $userID);501更改拥有者
 *         chgrp($filename, $groupID);501更改组信息
 *         fileowner($filename);获取拥有者
 *
 * 17.目录操作
 *         遍历目录
 *             $dir = opendir($path)
 *             readdir($dir)返回目录引用句柄；每读一次返回一个文件；否则返回false
 *             rewinddir($dir)重新将指针返回目录开始
 *             closedir($dir)
 *
 *             对象：
 *             $dir = dir();
 *             read
 *             rewind
 *             close
 *             路径是：$dir->path
 *             引用句柄：$dir->handle    
 *             $dir->read()
 *         检索目录
 *             *代表任意多个任意字符
 *             ?任何一个字符
 *             {}
 *             $array = glob($patten,GLOB_MARK);
 *             GLOB_MARK
 *             GLOB_NOSORT
 *             GLOB_NOCHECK
 *             GLOB_NOESCAPE
 *             GLOB_BRACE
 *             GLOB_ONLYDIR
 *             GLOB_ERR
 *         建立目录
 *             mkdir($pathname,[mode])
 *             文件路径；权限：0700
 *         删除目录（自己实现）
 *             rmdir()不支持递归；
 *             自己写了一个见下面代码：
            function deleteDir ($pathname){
                if (file_exists($pathname)) {
                    $dir = opendir($pathname);
                    //前两次读取不输出；因为是当前文件夹和父文件夹
                    readdir($dir);
                    readdir($dir);
                    while (($file = readdir($dir)) != null) {
                        $file = $pathname . DIRECTORY_SEPARATOR . $file;
                        if (is_dir($file)) {
                            deleteDir($file);
                        } else {
                            unlink($file);
                        }
                    }
                    if (rmdir($pathname)) {
                        echo "删除目录".$pathname."成功<br>";
                    } else {
                        echo "删除目录".$pathname."失败<br>";
                    }
                    closedir($dir);
                }else{
                    echo "指定目录并不存<br>";
                }
            }
            deleteDir($pathname);
 *         复制目录
 *             copy("","")
 *             自己写了一个复制文件夹的递归，代码见下：
             function copyDir ($pathF,$pathT){
                if (file_exists($pathF)) {
                    if (is_dir($pathF)){
                        if (!file_exists($pathT)){
                            mkdir($pathT);
                        }
                        $dir = opendir($pathF);
                        //前两次读取不输出；因为是当前文件夹和父文件夹
                        readdir($dir);
                        readdir($dir);
                        while (($file = readdir($dir)) != null) {
                            $fileF = $pathF . DIRECTORY_SEPARATOR . $file;
                            $fileT = $pathT . DIRECTORY_SEPARATOR . $file;
                            if (is_dir($fileF)) {
                                copyDir($fileF, $fileT);
                            } else {
                                copy($fileF, $fileT);
                            }
                        }
                        closedir($dir);
                    }else{
                        if (!file_exists($pathT)){
                            copy($pathF,$pathT);
                        }else{
                            echo "指定文件已存在<br>";
                        }
                    }
                }else{
                    echo "拷贝的指定目录并不存<br>";
                }
            }
 *
 */
$str = "这是我的是啊啊啊 啊啊 \n";
$filename = "test.txt";
//写入文件
$file = fopen($filename, "w") or die("文件打开失败");
for ($i = 0; $i < 10; $i ++) {
    fwrite($file, $i . $str);
}
fclose($file) or die("文件关闭失败");
echo "<br>";
//读取文件
$file = fopen($filename, "r") or die("文件打开失败");
$str = fread($file, filesize($filename));
var_dump($str);
fclose($file) or die("文件关闭失败");
echo "<br>";
//写入文件
$str = "sssssssssss";
$file = fopen($filename, "r") or die("文件打开失败");
fputs($file, $str, 10);
var_dump($file);
fclose($file) or die("文件关闭失败");
echo "<br>";
//读取文件
$file = fopen($filename, "r") or die("文件打开失败");
while (($line = fgets($file)) != null) {
    $curent = ftell($file);
    echo "get:" . $line . "<br>";
}
var_dump($file);
fclose($file) or die("文件关闭失败");
echo "<br>";
//直接读取文件
$array = file($filename);
foreach ($array as $value)
    echo $value;
echo "<br>";
//直接输出
readfile($filename);
echo "<br>";
//一个简单的计数器
$filename = "sum.txt";
if (! file_exists($filename)) {
    $file = fopen($filename, "w");
    fwrite($file, 1);
    fclose($file);
    echo "你是1位访客";
} else {
    $num = disp($filename);
    echo "你是" . $num . "位访客<br>";
    $file = fopen($filename, "w");
    fwrite($file, $num);
    fclose($file);
}
function disp ($filename)
{
    $file = fopen($filename, "r");
    $num = fread($file, 8);
    $num += 1;
    fclose($file);
    return $num;
}
//获取网站信息
echo "baidu";
$filename = "http://www.baidu.com";
$file = fopen($filename, "r");
$str = "";
while (($line = fgets($file)) != NULL) {
    $str .= $line;
}
preg_match_all("/<a\s+?href=.+?>.+?<\/a>/", $str, $array);
//var_dump($array);
foreach ($array[0] as $value)
    echo $value . "<br>";
fclose($file);
//锁实例
$filename = "test.txt";
//读锁定
$fileR = fopen($filename, "r");
if (! flock($fileR, LOCK_SH + LOCK_NB))
    echo "无法读锁定文件";
echo fread($fileR, filesize($filename));
if (! flock($fileR, LOCK_UN + LOCK_NB))
    echo "无法释放锁定文件";
fclose($fileR);
$fileW = fopen($filename, "a");
//写锁定
if (! flock($fileW, LOCK_EX + LOCK_NB))
    echo "无法写锁定文件";
echo fwrite($fileW, "wo xie d s a ");
if (! flock($fileW, LOCK_UN + LOCK_NB))
    echo "无法释放锁定文件";
fclose($fileW);
//文件指针
$file = fopen($filename, "r") or die("文件打开失败");
while (($line = fgets($file)) != null) {
    $curent = ftell($file);
    echo "get:" . $line . "<br>";
    echo "文件指针当前位置:" . $curent . "<br>";
    fseek($file, 12, SEEK_CUR);
}
fclose($file) or die("文件关闭失败");
echo "<br>";
//获取文件属性
echo "文件创建时间:" . date("Y年m月j日，h:i", filectime($filename)) . "<br>";
echo "文件修改时间:" . date("Y年m月j日，h:i", filemtime($filename)) . "<br>";
echo "文件最后访问时间:" . date("Y年m月j日，h:i", fileatime($filename)) . "<br>";
echo "文件是否存在:" . file_exists($filename) . "<br>";
echo "文件大小:" . filesize($filename) . "<br>";
echo "文件类型:" . filetype($filename) . "<br>";
echo "文件是否是目录:" . is_dir($filename) . "<br>";
echo "文件是否是文件:" . is_file($filename) . "<br>";
echo "文件是否是链接:" . is_link($filename) . "<br>";
echo "文件是否可执行:" . is_executable($filename) . "<br>";
echo "文件是否可读:" . is_readable($filename) . "<br>";
echo "文件是否可写:" . is_writable($filename) . "<br>";
//遍历目录内容
$path = "../base";
function subDir ($path, $str)
{
    $dir = opendir($path) or die("打目录不成功");
    echo $path . "下的内容：<br>";
    //前两次读取不输出；因为是当前文件夹和父文件夹
    readdir($dir);
    readdir($dir);
    while (($file = readdir($dir)) != null) {
        $filePath = $path . DIRECTORY_SEPARATOR . $file;
        if (is_dir($file)) {
            echo $str . $file . "是个目录<br>";
            $subStr = $str + "--";
            subDir($filePath, $subStr);
        } else
            echo $str . $file . "<br>";
    }
    closedir($dir);
}
$path = "base";
$dir = dir($path);
echo "路径是：" . $dir->path;
echo "引用句柄：" . $dir->handle;
//查询检索文件
echo "检索文件<br>";
$array = glob("../base/{s,r,t}*", GLOB_BRACE);
foreach ($array as $value) {
    echo $value . "<br>";
}
subDir($path, "");


//循环删除目录
$pathname = "test";
/**
 * 删除目录
 * 删除后无法恢复
 * @param unknown_type $pathname
 */
function deleteDir ($pathname)
{
    if (file_exists($pathname)) {
        if (is_dir($pathname)){
            $dir = opendir($pathname);
            //前两次读取不输出；因为是当前文件夹和父文件夹
            readdir($dir);
            readdir($dir);
            while (($file = readdir($dir)) != null) {
                $file = $pathname . DIRECTORY_SEPARATOR . $file;
                if (is_dir($file)) {
                    deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            if (rmdir($pathname)) {
                echo "删除目录".$pathname."成功<br>";
            } else {
                echo "删除目录".$pathname."失败<br>";
            }
            closedir($dir);
        }else{
            if (unlink($pathname)){
                echo "指定文件已删除成功<br>";
            }
        }
    }else{
        echo "删除的指定目录并不存<br>";
    }
}
deleteDir($pathname);

//拷贝目录
$pathF = "../application";
$pathT = "test";
/**
 * 拷贝目录
 * 拷贝后无法恢复
 * @param unknown_type $pathname
 */
function copyDir ($pathF,$pathT)
{
    if (file_exists($pathF)) {
        if (is_dir($pathF)){
            if (!file_exists($pathT)){
                mkdir($pathT);
            }
            $dir = opendir($pathF);
            //前两次读取不输出；因为是当前文件夹和父文件夹
            readdir($dir);
            readdir($dir);
            while (($file = readdir($dir)) != null) {
                $fileF = $pathF . DIRECTORY_SEPARATOR . $file;
                $fileT = $pathT . DIRECTORY_SEPARATOR . $file;
                if (is_dir($fileF)) {
                    copyDir($fileF, $fileT);
                } else {
                    copy($fileF, $fileT);
                }
            }
            closedir($dir);
        }else{
            if (!file_exists($pathT)){
                copy($pathF,$pathT);
            }else{
                echo "指定文件已存在<br>";
            }
        }
    }else{
        echo "拷贝的指定目录并不存<br>";
    }
}
copyDir($pathF,$pathT);
?>