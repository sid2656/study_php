<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
/**
 * 字符串
 * 定义：
 * 1、双引号；
 * 可以执行变量；可以使用传义字符
 * 2、单引号；
 * 可以执行变量；只能使用部分转义字符（\'和\\）
 * 3、反引号··；
 * 反引号中使用的服务器的命令
 * 声明的字符串没有输出；
 * 4、定界符
 * 以<<<abc开始；然后换行加入信息
 * 以abc结束
 * 可以执行变量；可以使用传义字符；可以在定界符中使用任意多的双引号
 * 比如发表文章来讲文章加入到定界符之中
 *
 */
$num = 100;
$str = "hello$num''";
echo $str ."<br>";
echo "ssssssssssss". $str ."ssss<br>";
echo "ssssssssssss{$str}ssss<br>";
echo "this is a \"String\" test<br>";
$str = 'hello$num';
echo $str ."<br>";
$str = `hello$num`;
echo "文件夹start";
$str = `dir`;
$str = iconv('GB2312', 'UTF-8', $str);
echo $str ."<br>";
echo "文件夹end<br>";
$str = <<<sss
           sdfadfa
           adsfsadf
sss;
echo $str ."<br>";

/**
 * 字符串处理函数
 * 输出函数：
 * echo()多个参数不允许用括号
 * print()函数有返回值；输出成功返回1；失败返回0
 * printf()可以按照格式输出
 * sprintf()格式化之后返回不进行输出
 * print_r()只用于数组的输出
 * var_dump()检测数据的类型
 * die()==echo();exit;输出内容并退出程序
 */
$str = "this is string function test!";
$num = 100.001;

//多个参数不允许用括号
echo $str."<br>";
echo "aaa","vvv","ccc<br>";
//函数有返回值；输出成功返回1；失败返回0
print $str."<br>";
print($str."<br>");
//可以按照格式输出
printf("%s%s",$num,"<br>");
printf("字符串：%s---%d---%b---%x---%o---%c---%X---%.2f%s",
$num,$num,$num,$num,$num,$num,$num,$num,"<br>");
printf("输出字符20位补前，-20补后，不够的补#号：%'#20s",
$num,"<br>");
//格式化之后返回不进行输出
$str = sprintf("输出字符20位补前，-20补后，不够的补#号：%'#20s",$num,"<br>");
//只用于数组的输出
//print_r();
//检测数据的类型
//var_dump();
//输出内容并退出程序
//die($str);
//mysql_connect("localhost","root","root")or die("链接失败，退出程序");

/**
 * 处理字符串；原有的字符串不会变，只是返回新的字符串
 * 1、去掉字符串做空格ltrim()
 * 2、去掉字符串右空格rtrim()
 * 3、去掉字符串两端的空格trim()
 * 4、获取字符串长度strlen()
 * 5、将字符串反转strrev()
 * 6、将字符串转成小写strtolower()
 * 7、将字符串转成大写strtoupper()
 * 8、将字符串第一个字符改成大写ucfirst()
 * 9、将字符串中单词的首字母大写ucwords()
 * 10、使用一个字符串分割另一个字符串explode(string separator,string string,[int limit])
 * 11、用一组较小的字符串创建一个大字符串implode();
 * 12、取部分字符串substr(string string,int start,int length)
 * 13、别名strstr()
 * 14、冲某字符串截止到结尾strchr()
 * 15、寻找字符串中某字符最先出现的位置strpos(string string,string substr,int offset);
 * 16、寻找字符串中某字符最后出现的位置strrpos(string string,string substr);
 * 17、寻找字符串中某字符最后出现的位置到结尾的字符串strrchr(string string,string substr);
 * 18、字符串的填补函数str_pad(string str,int length,string addstr,STR_PAD_LEFT)
 *      填补方向：  STR_PAD_LEFT
 *                STR_PAD_RIGHT
 *                STR_PAD_BOTH
 */
    $str = "  This is a word   ";
print_r(explode(" ",$str)) ."<br>";
print_r(explode(" ",$str,3)) ."<br>";
echo ltrim($str)."<br>";
echo rtrim($str)."<br>";
echo trim($str)."<br>";
echo strlen($str)."<br>";
echo strrev($str)."<br>";
echo strtolower($str)."<br>";
echo strtoupper($str)."<br>";
echo ucfirst($str)."<br>";
echo ucwords($str)."<br>"."<br>";
$arr = array("this","is","a","word");
echo implode("-", $arr)."<br>";;
echo substr($str, 5)."<br>";;
echo substr($str, 5, 3)."<br>";;
echo strstr($str,"sdfa")."<br>";;
echo strchr($str,"a")."<br>";;
echo strpos($str,"wor")."<br>";;

/**
 * 字符串比较函数
 * 1、按字节进行字符串比较
 *      strcmp     区分大小写
 *      strcasecmp()不区分大小写
 *
 * 2、按自然排序法时进行字符串比较]
 *      strnatcmp 
 *
 * 3、字符串的模糊比较
 *      soundex()按读音
 *      similar_text()计算相似度出处百分比的数字
 *
 * 4、字符串替换str_replace(string,string,string);
 *      多个值换成一个str_replace(array,string,string);
 *      多个值分别替换str_replace(array,array,string);
 *      参数一：需要替换的字符串
 *      参数二：转换成的字符串
 *      参数三：在哪里进行字符串的替换
 *
 * 5、字符串翻译函数strtr(string,string,string);
 *      参数一：在哪里进行字符串的替换
 *      参数二: 需要转换的字符串com
 *      参数三：传换成的字符串net
 *     strtr(string,array);
 *
 * 6、去掉双引号的转义字符stripslashes()、addslashes();
 *
 * 7、将html标签变成实体输出，不让浏览器直接解释标签htmlentities()、htmlspecialchars()
 *
 * 8、6、7嵌套可以同时修改两种
 *
 * 9、html过滤标签strip_tags(string str,string "保留的标签");
 *
 * 10、处理URL
 *      解析：
 *      parse_str();
 *      parse_url();
 *
 *      编码处理
 *      rawurlencode();
 *      urlenode();
 *      urldecode();
 *
 *      构造查询字符串等
 *     http_build_query();    
 */

$str1 = "hello";
$str2 = "hello";
$str11 = "hollo";

echo strcmp($str1, $str2)."<br>";
echo strcmp($str1, $str11)."<br>";
echo strcasecmp($str1, $str2)."<br>";
echo strcasecmp($str1, $str11)."<br>";
echo strnatcmp($str1, $str2)."<br>";
echo strnatcmp($str1, $str11)."<br>";
echo soundex($str)."<br>";
echo soundex($str)."<br>";
echo similar_text($str1, $str2)."<br>";
echo similar_text($str1, $str11)."<br>";
$url = "http://lolcahost.xiaofei.com/demo.php";
$arr = array("http"=>"ftp","gost"=>"hi","ofet"=>"heol","com"=>"net");
echo strtr($url,"gost","hi")."<br>";
echo strtr($url, $arr)."<br>";
?>