<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
    /**
     * 处理数据库的扩展库
     *
     * 一：mysqli(是面向对象的技术)
     *         相对于mysql效率更高更稳定
     *         mysqli类和mysqli_result类常用
     *         mysql_stat
     *         
     *     1.mysqli
     *         $mysqli = new mysqli("localhost","root","root","hibernate");
     *         $mysqli->select_db("hibernate");
     *         或者：
     *         
     *     2.获取记录
     *         每次执行一次，就会从结果集中取出当前一天记录（可以使用data_seek(5)）
     *         每次指向下一行，下次再取时，会取出下一行，当结果集中没有记录时，则返回false
     *         $result->fetch_row()        mysql_fetch_row()    索引数组
     *         $result->fetch_assoc()        mysql_fetch_assoc()    关联数组
     *         $result->fetch_array()        mysql_fetch_array()    两个数组都返回
     *         $result->fetch_object()        mysql_fetch_object()
     *         结果集的释放：
     *         $result->close();$result->free();$result->free_result();
     *
     *         针对列进行
     *         field_count
     *         current_field
     *         lengths
     *         data_field
     *         fetch_field()
     *         fetch_fields()
     *         
     *
     * 二：pdo
     *
     */

//使用面向对象的方式：
$mysqli = new mysqli("localhost","root","root","hibernate");
if (mysqli_connect_errno()){
    echo "连接失败：".mysqli_connect_error();
    $mysqli = null;
    exit();
}
var_dump($mysqli);
//查看字符集
echo $mysqli->character_set_name();

//查询结果集处理mysqli_result
$sql = "select id as uid,name,price from users";
$result = $mysqli->query($sql);
$rows = $result->num_rows;
$cals = $result->field_count;
//获取行数和列数
echo "<br>表中行".$rows."、列".$cals."<br>";
//获取记录;data_seek可以设置指针位置
while ($row = $result->fetch_assoc()){
    foreach ($row as $cal){
        echo $cal."      ";
    }
    echo "<br>";
}

$result = $mysqli->query($sql);
//获取列名;去查看api
while ($field = $result->fetch_field()){
    echo "原名".$field->orgname."别名".$field->name."最大长度".$field->max_length."<br>";
}
//释放结果集
$result->close();
$mysqli->close();
?>