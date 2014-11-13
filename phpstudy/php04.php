<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
	/**
     * 函数
     * php中只有变量是区分大小写的；
     * 其他的并不区分方法名也是不区分
     *
     * functionfun(arg1,arg2,arg3,...){
     *      ......
     *      return value;
     * }
     *
     */
	function table($name){
		echo "$name";
		echo $name;
	}
	
	table ( "hah" );
	
	/**
	 * 函数的变量作用范围
	 * 以及如何调用全局变量
	 */
	
	//参数定义方式
	$a = 100;
	function funa(){
		//这里的$a默认认为是内部的变量，与外部无关
		$a = 123;
		echo $a;
	}
	function funb(){
		//如果想用外部的可以用如下;或者使用全局数组
		//如果用global声明使用全局的话，进行修改会对外部的值进行修改的
		echo $GLOBALS ["a"];
		global $a;
		echo $a;
	}
	funa ();
	funb ();
	/**
	 * 传值
	 * 如果参数是$a；传值
	 * 并且函数内直接声明了一个变量；这个变量与传进来的变量无关，只是内部的局部变量
	 * 如果参数是&$a；传地址
	 * 这样会将外部变量的地址传递过来。所以内部变量的a是外部变量了
	 */
	//传值
	$a = 100;
	function func($a){
		//这里的$a默认认为是内部的变量，与外部无关
		$a = 900;
	}
	func ( $a );
	
	echo $a;
	
	    //传地址
	function fund(&$a){
		//这里的$a默认认为是内部的变量，与外部无关
		$a = 900;
	}
	fund ( $a );
	echo $a;
	
	/**
	 * 判断函数是否存在
	 *
	 * 来判断php版本中是否存在这个函数
	 */
	function_exists ( "funa" );

    /**
     * php中实参多余形参是可以调用的fune()
     * 如果实参少于形参，会提示警告（不过可以屏蔽，用@）
     *
     * 可以给函数符默认值如funf();
     */
    function fune($a,$b,$c){}

    function funf($a=1,$b="ss",$c=999){}
	fune ( 1, 1, 11, 1, 1, 1, 1, 1 );
//	fune ();
	@fune ();

    /**
     * 函数库中带有[]的参数是可选的参数；表示无力是否传值都可以
     * []的表示有默认的参数；
     *
     * 如果定义的函数有默认的参数，那么该参数必须放在必选参数的后面
     *
     * 如果想接收任意数量的参数，可以用函数func_get_args来处理
     *
     */
    function fung(){
		$args = func_get_args ();
		count ( $args );
		for($i = 0; $i < count ( $args ); $i ++) {
			echo $args [$i];
			echo "</br>";
		}
	}
	echo "</br>fung()</br>";
	fung ( 1, 1, 11, 1, 1, 1, 1, 1 );

    /**
     * 变量函数
     * 根据传入的值获取不同的函数
     *
     * 系统结构的函数不可以做成变量
     * echo() print() unset()isset() empty() include() require();
     */
    function funh(){
		echo "********************<br>";
	}
    function funi(){
		echo "####################<br>";
	}

	@$a = funh();
	$a = funi();
	$a;

    /**
     * 内部函数
     * 1.内部函数在主函数外无法直接调用
     * 2.内部函数访问不了主函数的变量
     *
     */

	function demo($php,$java){
		function php($php){
			return "php is$php";
		}
		function java($java){
			return "java is$java";
		}
		echo php ( $php );
		echo java ( $java );
	}
	demo ( 65, 55 );
	
	/**
	 * 重用函数
	 *include("demo.php");
	 *include"demo.php";
	 *require("demo.php");
	 * 两者，可以调用demo.php的内部定义的函数
	 *
	 * 可以重用多次（但是demo中的函数不可以重新定义）
	 * 下面的函数表示如已经包含，则不再包含进来
	 *include_once("demo.php");
	 *require_once("demo.php");
	 *
	 * require：在预处理期间被导入；
	 * 处理失败的时候：会产生警告
	 * include：每次都有重新计算文件名；
	 * 处理失败的时候：会报错
	 */
	include 'repeat.php';
?>