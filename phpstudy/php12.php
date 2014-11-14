<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");
/**
 * 错误处理
 * 1.语法错误
 * 2.运行时错误
 * 3.逻辑错误
 *
 * 错误报告级别（可以在c盘的php.ini中配置；修改之后重启apache）
 *     错误E_ERROR
 *     警告E_WARNING
 *     注意E_NOTICE
 *
 * 开发阶段：开发时输出所有的错误报告，利于调试
 * 运行阶段：屏蔽报告（普通用户和黑客）
 * ini_set("display_error", "off");
 *
 * 将错误报告写入日志：log_error = on;
 *         一、指定错误报告error_reporting
 *         二、关闭错误输出 display_error=off
 *         三、开启错误日志的功能log_error = on
 *
 *         1.默认如果不指定错误日志位置，则默认写入到web服务器的日志中
 *         2.指定error_log为一个项目中的文件名（php可写的权限）
 *         3.写入到操作系统日志中error_log=syslog
 *
 *
 * 异常处理：（php5的重要特性）
 *         意外，是在程序运行过程中发送的意外，使用异常改变脚本正常流程
 *         在catch中解决传递过来的异常
 * try{
 *     throw new Exception();
 * }catch(Exception $e){
 * }
 *
 * 自己定义异常
 *         作用：写一个或者多个方法，解决发生异常时的处理方式
 *         1.自己定义异常类，必须要继承exception
 *         2.Exception中只有构造方法和toString方法可以重写，其他的都是final的
 *
 */
//设置输出报告形式
error_reporting(E_ALL & ~E_NOTICE);
//也可以设置配置文件；临时修改配置文件的设置
ini_set("error_reporting", E_ALL);
//获取配置文件的值
ini_get("error_reporting");
//屏蔽错误信息
ini_set("display_error", "off");
//写入错误日志信息
error_log("this is a test error message!");

//异常处理
$filename = "hello.txt";
try{
    if (!@fopen($filename, "r"))
         throw new Exception();
     echo "没用执行的代码<br/>";
}catch(Exception $e){
     echo "文件不存在，创建文件<br/>";
     echo $e->getMessage();
     //创建文件
     touch($filename);
    $file = @fopen($filename, "r");
}

/**
 * 自定义异常
 * Enter description here ...
 * @author admin
 *
 */
class OpenFileException extends Exception{
    function __construct($message="", $code=0){
        parent::__construct($message, $code);
    }
    function open(){
        touch("tmp.txt");
        $file = fopen("tmp.txt", "r");
        return $file;
    }
}
/**
 * 自定义类的异常使用
 * Enter description here ...
 * @author admin
 *
 */
class Myclass{
    function openFile(){
        throw new OpenFileException("文件打开失败<br/>");
    }
    function demo(){
        throw new Exception("测试出错<br/>");
    }
}
//使用自定义异常
try{
    $my = new Myclass();
    $my->openFile();
    $my->demo();
    echo "没有执行的代码<br/>";
}catch(OpenFileException $e){
     echo "文件不存在，创建文件<br/>";
     echo $e->getMessage();
     $file = $e->open();
     echo $file.$filename;
}catch (Exception $e){
    
}
?>