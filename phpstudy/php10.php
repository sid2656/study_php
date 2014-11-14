<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");
/**
 * 文件上传和下载
 * 1.表单提交
 *         表单必须要改的method="post"
 *         enctype="multipart/form-data"
 *         php.ini:
 *             file_uploads=On;
 *             upload_max_filesize = 2M;//上传限制
 *             post_max_size = 8M;//表单传递的最大尺寸
 *        $myfile1[type]：可以用来控制上传文件的类型
 *            type是MIME类型：网络
 *                text
 *                    text/html
 *                    text/plain
 *                image
 *                    image/gif
 *                    image/jpeg
 *                    image/png
 *                audio
 *                    audio/x-midi .mid .midi
 *                    audio/x-wav
 *                video
 *                    video/quicktime .qt .mov
 *                    video/mpeg .mpeg
 *                application
 *                    application/pdf
 *                    application/msword .doc .dot
 *                    application/vnd.ms-excel .xls
 *                    application/vnd.ms-powerpoint .ppt
 *                    application/zip .zip
 *                    application/rar .rar
 *                    application/xml .xml
 *                    application/mshelp .hlp .chm
 *                    application/octet-stream .ext .bin .com .dll
 *                multipart
 *                message
 * 2.对文件的操作
 *         上传文件拷贝的函数：
 *             move_uploaded_file()
 *         error的提示符及原因:
 *             case 1:上传文件超过了upload_max_filesize这个值
 *             case 2:上传文件超过了表单中MAX_FILE_SIZE选项指定的值
 *             case 3:文件只有部分被上传
 *             case 4:没有文件上传
 *
 * 3.下载文件（在下载页面，只允许写如下代码，不可以写其他的html多余代码）
 *         对于图片和html或者php下载应该写头
 *             header();方法前不许有输出，即使是html也不可以
 *         图片下载：
            header("Content-type:image/jpeg");
            //设置下载文件
            header('Content-disposition:attachment:filename='.$filename);
 *         
 */

    $filename = "one.html";
    //设置下载类型
    header("Content-type:text/html");
    //设置下载文件
    header('Content-Disposition:attachment;filename='.$filename);
    //设置文件下载大小
    header("Content-Length:".filesize($filename));
    
    $fp = fopen($filename, "r");
    while (feof($fp)==FALSE){
        echo fread($fp, 1024);
    }
    fclose($fp);
?>