<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");
/**
 * 正则表达式
 *      描述字符排列模式的一种语法规则
 *      字符串的模式分割、匹配、查找、替换
 *
 * 1.组成字符：abc... 123...特殊字符：()?^$*
 *
 * 2.两种函数库，功能相似；效率有差别
 *      PCRE  以preg_ 开头的（执行效率高一些）
 *      POSIX  以ereg_ 开头的
 *
 * 3.通常定界符用//来表示；除了字母数字和\不允许作为定界符，其他的都可以
 *    组成：
 *      原子：
 *         普通字符：英文、数字、标点、其他、(abc)、原子表：[abc]
 *        转义字符：
 *             \d：匹配一个数字0-9；
 *             \D：匹配除数字以外的任何一个字符
 *             \w：一个字母、数字、下划线
 *             \W：除一个字母、数字、下划线的符合
 *             \s：匹配一个空白字符：\f\n\r\t\v这些字符
 *             \S：匹配除空白字符外的任意字符
 *             \oNN：八进制
 *             \xNN：十六进制
 *         原子表：只匹配其中一个字符
 *             [abc]
 *             [^abc]取反
 *             [a-z]
 *      元字符：（有特殊功能用途的字符）
 *         *：0次或者多次匹配前一个原子
 *         +：至少匹配一次前一个原子
 *         ?：0次或者一次匹配前一个原子
 *         .：匹配除换行字符以外的任何一个字符，相当于[^\n\r]
 *         |：abc|efg匹配abc或者efg
 *         ^：匹配字符串串首的原子/^abc/必须匹配以abc开头的字符串
 *         $：匹配字符串串尾的原子/abc$/必须以abc结尾
 *         \b：匹配单词的边界/\bis\b/匹配is两边都有边界的字符例如：this is a
 *         \B：匹配单词边界以外的
 *         {m}：表示其前原子恰好出现m次
 *         {m,n}：表示其前的原子出现m到n次
 *         {m,}：至少出现m次
 *         ()：括号中整体表示一个原子
 *      模式修正字符：（i,U,s,x,m,e,D,等）
 *         标记在在整个模式之外//之外；例如：/abc/i
 *         可以进行组合：/abc/iUsx
 *         i：大小写同时匹配
 *         m：将字符串视为多行
 *         s：将字符串视为单行，换行符作为普通字符
 *         x：将模式中的空白忽略
 *         e：在preg_replace()使用；可以将替换出来的字符当做函数或者表达式来执行
 *             preg_replace("/\d/e","md5(MM)",$str,$limit)
 *         A：强制从目标字符串开头开始匹配
 *         D：美元的元字符匹配字符串结尾；如果有换行就无法成功
 *         U：匹配到最近的字符串
 *
 * 4.通常是按照由左到右的顺序依次执行
 *         优先级
 *             1.模式单元：()
 *             2.重复匹配：?*+{}
 *             3.边界限制：^$\b\B
 *             4.模式选择：|
 *
 * 5.preg_的函数
 *      preg_match($pattern,$str,$content)
 *         在str中是否存在pattern；
 *         如果存在赋值到content的数组中；并返回true
 *         content[0]表示整个匹配
 *         content[1]表示第一个匹配的结果;/(1)(2)(3)/即(1)中匹配的内容
 *      preg_match_all($pattern,$str,$content)（与preg_match有区别）
 *         在str中是否存在pattern；
 *         如果存在赋值到content的数组中；并返回true
 *         content[0]表示整个匹配
 *         content[1]表示第一个匹配的结果;/(1)(2)(3)/即(1)中匹配的内容
 *      preg_replace($pattern,$replacment,$str,$limit)
 *         第一个：模板
 *         第二个：要变成的字符串（可以用\\num来代表第几个()型原子）
 *         第三个：数据源
 *         第四个：替换前多少个
 *         参数都可以是数组形式
 *      preg_split($pattern,$str,$limit)
 *      preg_grep($pattern,$array)
 *         返回一个数组，其中包括在input数组中给定的与模式匹配的单元
 *      preg_
 *      preg_
 *
 * 6.UBBCode转义
 *      [b][/b]=> <b></b>
 *      preg_replace("/[.*]/","",$str,limit);
 *
 */

$str = $_GET["str"];
$mode="/abc/";
//如果匹配成功，放入第三个参数
if (preg_match($mode,$str,$content)){
    echo"匹配成功，匹配出来的字符串是：".$content[0]."<br>";
}else{
    echo"不匹配失败<br>";
}

$str = "date time is ".date("Y-m-d H:i a")." php<br>";
echo $str;
echo preg_replace("/(\d{4}-\d{2}-\d{2})(\d{2}:\d{2}) [ap]m/","<font color=red>\\1</font><fontcolor=green>\\2</font>", $str);

//验证分割函数
@$str = "date. time, is ".date("Y-m-d H:i a")."php<br>";
echo $arr = var_dump(preg_split("/[,.\\s]/", $str));
$arr = preg_split("/[,.\\s]/", $str);
    foreach($arr as $value){
       echo$value."<br>";
    }
//验证BBUCode
$str = "[b]...[/b];[u]sdfjos[/u]";
$pattern = array(
           "/\[b\](.+?)\[\/b\]/is",
           "/\[u\](.+?)\[\/u\]/is");
$replacement = array(
           "<b>\\1</b>",
           "<u>\\1</u>");

echo preg_replace($pattern, $replacement, $str);
 
?>