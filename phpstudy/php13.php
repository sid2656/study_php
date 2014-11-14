<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");

/**
 * 时间和日期
 * 1.unix时间戳
 *         以32位整数表示的格林威治时间
 *         时间戳是从1970年1月1日0点0分0秒到现在的开始计时
 *         方便我们计算使用
 *         处理的时间在1902年-2038年之内是有效的（时间戳不能为负数）
 * 2.在php中获取日期和时间
 *         time()
 *         getDate()
 *         getTimeOfDay()
 *         date_sunrise()
 *         date_sunset()
 * 3.格式化输出
 *         date($str,[timestamp]);（查看使用的符号）
 * 4.将日期和时间编程unix时间戳
 *         mktime($hour, $minute, $second, $month, $day, $year, $is_dst)
 *         如果只想传唤日期，则前三个参数传入0即可
 * 5.修改php的默认时区
 *         最好服务器的时间，没半个小时与世界时间同步一下
 *         php.ini 的 date.timezone
 *         或者
 *        ini_set("date.timezone", "ETC/GMT-8");
 *        date_default_timezone_set("ETC/GMT-8");（php5特性）
 * 6.使用微妙计算php脚本的执行时间
 *         microtime();（带有boolean参数的是php5的新特性）
 *
 * 示例：日历类
 */
//设置时区（参数去查看php手册的参数列表）
//date_default_timezone_set("ETC/GMT-8");
ini_set("date.timezone", "ETC/GMT-8");

//获取时间
$time = time();
echo $time."<br>";
$date = @getDate();
var_dump($date)."<br>";
$timeofday = @getTimeOfDay();
var_dump($timeofday)."<br>";
$date_sunrise = @date_sunrise();
echo $date_sunrise."<br>";
$date_sunset = @date_sunset();
echo $date_sunset."<br>"."<br>";

//格式化日期和时间
echo @date("Y-m-d H:i:s",time())."<br>";
echo @date("Y-m-d H:i:s")."<br>"."<br>";

//转换unix时间戳
echo @date("Y-m-d H:i:s",@mktime(12,29,22))."<br>";
echo @date("Y-m-d H:i:s",@mktime(0,0,0,12,2002))."<br>";
echo @date("Y-m-d H:i:s",@mktime(0,0,0,12,36,2007))."<br>";
echo @date("Y-m-d H:i:s",@mktime(0,0,0,1,1,99))."<br>";

//计算年龄方法
@list($year,$month,$day)=@explode("-", $_GET["birthday"]);
$agestamp = time()-@mktime(0,0,0,$month,$day,$year);
$age = $agestamp/(60*60*24*365);
echo $age."<br>";

//使用微妙计算php的时间
class Time{
    private $starTime;
    private $stopTime;
    function __construct(){
        $this->starTime = 0;
        $this->stopTime = 0;
    }
    function start(){
        $this->starTime=microtime(true);
    }
    function stop(){
        $this->stopTime=microtime(true);
    }
    function speat(){
        //四舍五入四位
        return round($this->stopTime-$this->starTime,4);
    }
}
$timer = new Time();
$timer->start();
for ($i=0;$i<10000;$i++){}
$timer->stop();
echo $timer->speat();

include 'calendar.class.php';
$calendar = new Calendar();
$calendar->out();
?>
<style>
    table{
        border:1px;
    }
    .fonth{
        color:white;
        background:blue;
    }
    th{
        width:30px;
    }
    form{
        margin: 0px;
        padding: 0px;
    }

</style>