<?php
	//设置字符集
	header("Content-Type:text/html;charset=utf-8");

	//1.基本类型
    //八进制；0开头
    $a=0100;
    //十六进制；0X开头
    $a=0XFF;
    //浮点数
    $a=1.2e-4;
    echo $a;
    echo "</br>";
    //字符串:双引号可执行转义字符和执行变量；单引号不可以
    $b="abc$a";
    echo $b;
    echo "</br>";
    $b='abc$a';
    echo $b;
    //布尔
    //false:0,0.0,"","0",array(),null
    //true：与上面的相反的都是真
    //自动类型转换；只有前面的数字会转换，如果前面是字母就还是字符串
    $a="100abc";//自动变成100
    $b="300abc";//自动变成300
    $c=$a+$b;
    echo $c;
    echo "</br>";
    //强制类型转换
    //1.可以直接用（目标类型）来进行转换；是形成一个新的类型，不会改变原来的
/*  (int),(integer)
    (bool),(boolean)
    (float),(double),(real)
    (string)
    (array)
    (object)*/
    $a="100abc";
    $c=(array)$a;
    echo var_dump($c);
    echo "</br>";

    //2.设置类型
    $a="100abc";
    settype($a, "integer");
    $c=$a;
    echo var_dump($c);
    echo "</br>";

    //3.转换函数
    $a="100abc";
    $c=intval($a);
    $c=floatval($a);
    $c=strval($a);
    echo var_dump($a);
    echo var_dump($c);
    /*
     * 浮点型
     * 00000000 0000000000000000 00000000 00000000 00000000 00000000 00000000
     * 整型最大值：2.14e9;溢出会造成数据丢失
     * 00000000 0000000000000000 00000000
     * 
    */

    /**
     * 获取外部变量的方法
     * 无论是get还是post都可以直接当成变量来使用
     */
    //获取表单的方法的数据
    print_r($_REQUEST);
    echo "用户名：";
    echo $_REQUEST["name"];
    echo "</br>";
    echo "密码：";
    echo $_REQUEST["pwd"];
    echo "</br>";

    //获取表单的get方法的数据;如果不指明，表单默认是get方式
    print_r($_GET);
    echo "用户名：";
    echo $_GET["name"];
    echo "</br>";
    echo "密码：";
    echo $_GET["pwd"];
    echo "</br>";

    //获取表单的get方法的数据
    print_r($_POST);
    echo "用户名：";
    echo $_POST["name"];
    echo "</br>";
    echo "密码：";
    echo $_POST["pwd"];
    echo "</br>";

    //获取环境变量
    /**
     * $_SERVER
     * $_EVN
     */
    print_r($_SERVER);
    echo "</br>";
    echo $_SERVER["REMOTE_ADDR"];
    echo "</br>";
    echo $_SERVER["DOCUMENT_ROOT"];
    echo "</br>";
    echo $_SERVER["SCRIPT_FILENAME"];
    echo "</br>";
    print_r($_ENV);
    echo "</br>";
?>
