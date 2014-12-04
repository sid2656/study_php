<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
    /**
     * 处理数据库的扩展库
     *
     * mysqli的预处理语句
     * mysqli_stmt预处理类（推荐使用的类）
     *         优点：（mysqli和mysqli_result类的相比）
     *             1.性能：mysqli_stmt高（执行多条类型相同不同数据的sql，不用多次编译sql）
     *             2.安全上：sql注入问题（用?占位符来解决）
     * 使用(详情见代码)：
     *         ?占位符绑定：(邦定时要注意，后写的信息要与定好的类型匹配否则无法执行)
     *         例子：$stmt->bind_param("isd",$id,$name,$price);
     *         i：整型
     *         d：double
     *         s：string
     *         b：二进制数
     * 返回mysqli_stmt预处理类对象:$stmt = $mysqli->prepare($insert)
     * 一次性将结果全取出来:store_result()
     *
     */

//使用面向对象的方式：
$mysqli = new mysqli("localhost","root","root","hibernate");
if (mysqli_connect_errno()){
    echo "连接失败：".mysqli_connect_error();
    $mysqli = null;
    exit();
}
$mysqli->autocommit(true);
$insert = "insert into users values (?,?,?);";
//1.返回mysqli_stmt预处理类对象
$stmt = $mysqli->stmt_init();
//准备一条语句放在服务器上
$stmt->prepare($insert);
//2.mysqli的方式(简化了操作)
//$stmt = $mysqli->prepare($insert);
$stmt->bind_param("isd",$id,$name,$price);
$id = 32;
$name = "ssssss";
$price = 21.23;
//绑定之后开始执行了
if ($stmt->execute()){
    echo "执行成功";
}else {
    echo "执行失败";
}


//2.处理结果集
//准备好语句
$select = "select * from users where id > ?";
//准备一条语句放在服务器上
$stmt->prepare($select);
$stmt->bind_param("i",$select_id);
//绑定结果集（要与查询的字段个数相同）
$stmt->bind_result($id,$name,$price);
$select_id = 12;
//绑定之后开始执行了
if ($stmt->execute()){
    echo "执行成功";
}else {
    echo "执行失败";
}
//获取结果集（每次获取）
while ($stmt->fetch()){
    echo " <br>$id  $name $price";
}
echo " <br>记录总数：".$stmt->num_rows;

//一次性将结果全取出来
$stmt->store_result();
//字段信息
$result = $stmt->result_metadata();
while ($field = $result->fetch_field()){
    echo "<br>".$field->name;
}

$stmt->free_result();
$stmt->close();
$mysqli->close();
?>