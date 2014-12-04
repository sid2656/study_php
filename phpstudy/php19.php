<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
    /**
     * 处理数据库的扩展库
     *
     *     1.执行多条查询语句
     *         多语句查询：        $mysqli->multi_query($sqls)
     *         开始获取结果集：    $mysqli->store_result()
     *         判断是否还存在结果集：$mysqli->more_results()
     *         指针移到到下一个结果集：$mysqli->next_result()
     *         
     *     2.事物处理
     *         目前只有INNODB和BDB两种存储引擎支持事物
     *         默认是：myisam。
     *
     *         所以在建表的时候要指定innodB；在创建语句后加入type = 'INNODB'
     *         而且默认自动提交（导致插入数据不能回滚的）
     *         关闭自动提交：set autocomment = 0;
     *         并要开启事物：START TRANSACTION;
     *         回滚：rollback
     *     
     *     3.设置字符集
     *         在sql语句上
     *         $mysqli->query("set names gb2312");
     *         $mysqli->set_charset("utf8");
     *
     */

//使用面向对象的方式：
$mysqli = new mysqli("localhost","root","root","hibernate");
if (mysqli_connect_errno()){
    echo "连接失败：".mysqli_connect_error();
    $mysqli = null;
    exit();
}
//var_dump($mysqli);
//查看字符集
//echo $mysqli->character_set_name();

//没有结果集的insert update delete
$sqls = "insert into users values(27,'wodm a ','45');"
        ."update users set name = 'devil' where id >12;";
//有结果集的select
$sqls = "select * from users where id < 10;"
        ."select * from tb_company;";
if ($mysqli->multi_query($sqls)){
    echo "执行成功".$mysqli->affected_rows.$mysqli->insert_id."<br>";
    do{
        $result = $mysqli->store_result();
        while ($row = $result->fetch_assoc()){
            foreach ($row as $cal){
                echo $cal."      ";
            }
            echo "<br>";
        }
        //指向第二个结果集
    }while ($mysqli->more_results()?$mysqli->next_result():FALSE);
}else {
    echo $mysqli->errno."--".$mysqli->error;
}


//创建表
$createsql = "CREATE TABLE admins(id int not null auto_increment,name varchar(50) not null default '',price double not null default '0.00',primary key (id)) type = 'INNODB'";
$mysqli->query($createsql);

$sql = "update users set name='sjdkfjslkfjs' where id < 5";
//设置自动提交为假
$mysqli->autocommit(0);

$error = true;
$result = $mysqli->query($sql);
if ($result) {
    echo "更新成功";
}else{
    $error = false;
}
if ($error){
    echo "成功提交";
    $mysqli->commit();
}else{
    echo "失败回滚";
    $mysqli->rollback();
}

//设置字符集(gb2312插入utf8查询，就会出现乱码了)
//与下个set names 一样的效果
//$mysqli->set_charset("utf8");
//$mysqli->query("set names gb2312");
//$inser = "insert into users values(30,'张三',23);";
//$mysqli->query($inser);
//$mysqli->commit();
//设置字符集
$mysqli->query("set names utf-8");
$sql = "select * from users where id =30;";
$result = $mysqli->query($sql);
//循环输出数据
while ($row = mysqli_fetch_row($result)){
    foreach ($row as $cal){
        echo $cal."      ";
    }
    echo "<br>";
}

//释放结果集
//$result->close();
$mysqli->close();
?>