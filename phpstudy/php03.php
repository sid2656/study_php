<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
$arr = array (1, 2, 3, 4 );
foreach ( $arr as &$value ) {
	$value = $value * 2;
	echo $value . "\n";
}
reset ( $arr ) . "\n";
while ( list ( , $value ) = each ( $arr ) ) {
	echo "Value: $value<br>\n";
}
$a = array ("one" => 1, "two" => 2, "three" => 3, "seventeen" => 17 );
foreach ( $a as $k => $v ) {
	echo "\$a[$k] => $v.\n";
}

$a = array ();
$a [0] [0] = "a";
$a [0] [1] = "b";
$a [1] [0] = "y";
$a [1] [1] = "z";

foreach ( $a as $v1 ) {
	foreach ( $v1 as $v2 ) {
		echo $v2."\n";
	}
}
foreach ( $a as $v1 ) {
	foreach ( $v1 as $v2 ) {
		echo $v2."\n";
		//退出两层循环
		break 2;
	}
}
foreach ( $a as $v1 ) {
	foreach ( $v1 as $v2 ) {
		echo $v2."\n";
		//跳过2次循环
		continue 2;
	}
}

$num = $_REQUEST ["num"];
//switch.php?num=...
//因为是弱类型，所以都可以
switch ($num) {
	case "abc" :
		echo "abc";
		break;
	case 1 :
		echo "1";
		break;
	case 2 :
		echo "2";
		break;
	default :
		echo "default";
		break;
}
?>