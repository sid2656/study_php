<?php
//设置字符集
header ( "Content-Type:text/html;charset=utf-8" );
    /**
     *一、 mysql数据库管理
     * 1.基于数据库的php项目
     * 2.为何使用mysql
     * 3.mysql的架构
     * 4.php程序主要学习那些操作
     * 5.mysql的安装和操作
     * 6.了解数据库sql语句操作
     *         sql
     *         ddl
     *         dql
     *         dcl
     * 7.操作
     *         \s 查看链接等信息
     *         show databases;
     *         php插入时候都安单引号来写''，会自动转换
     * 8.帮助的使用
     *         ? contents 查看帮助内容
     *         show 查看show相关的命令
     *
     * 二、创建数据表：（语句要大写）
     *     1.sql模型
     *         CREATE TABLE 表名{
     *             字段名    字段类型,
     *         }[表类型][表字符集];
     *
     *         SQL是不区分大小写，但是表是一个文件，window不区分，linux区分
     *         表名最好是有意义的英文
     *         表名最好是小写的
     *         show 表名；desc 表名；
     *
     *     2.数值类型
     *         数值
     *             整型（整数）
     *             浮点型（小数）
     *         字符
     *         日期
     *         NULL
     *
     * 三、php的方法
     *     1.从结果集中将记录取出
     *         mysql_fetch_row($result);    返回索引数组
     *         mysql_fetch_assoc($result);    返回关联数组
     *         mysql_fetch_array($result);    返回索引和关联两个数组（不建议）
     *         mysql_fetch_object($result);将一条记录以对象的形式返回（用到的少）
     *         一次从结果集中取出记录
     *     2.
     */

//一：连接
$linkConnect = mysql_connect("localhost:3306","root","root");

if (!$linkConnect){
    echo "数据库连接失败<br>";
}else{
    echo "数据库连接成功<br>";
    //二：选择数据库
    $hibernate = mysql_select_db("hibernate",$linkConnect);
    if (!$hibernate){
        echo "连接hibernate数据库失败<br>";
    }else{
        echo "连接hibernate数据库成功<br>";
        //三：执行创建语句
        $createsql = "CREATE TABLE users(id int not null auto_increment,name varchar(50) not null default '',price double not null default '0.00',primary key (id))";
        $result = query($createsql);
        
        //插入语句
        $id = mysql_insert_id();
        echo $id;
        $insertsql = "INSERT INTO users values('".$id."','hello','12.01')";
        $result = query($insertsql);
        
        //更新语句
        $updatesql = "UPDATE users SET name='ssssssss' WHERE id = 1";
        $result = query($updatesql);
        
        //查询语句
        $selectsql = "SELECT id,name as '姓名',price from users";
        $result = query($selectsql);
        echo "<br>";
        //获取结果集的列数
        echo $cals = mysql_num_fields($result);
        for ($i = 0; $i < $cals; $i++) {
            echo mysql_field_name($result, $i);
        }
        echo "<br>";
        //获取结果集的行数
        echo $rows = mysql_num_rows($result);
        echo "<br>";
        //循环输出数据
        while ($row = mysql_fetch_row($result)){
            foreach ($row as $cal){
                echo $cal."      ";
            }
            echo "<br>";
        }
        $result = query($selectsql);
        while (list($id,$name,$price) = mysql_fetch_row($result)){
            echo $id.":".$name." 价格：".$price;
            echo "<br>";
        }
        //分页：
        
    }
}
mysql_close();

function query($sql){
    $result = mysql_query($sql);
    //错误解决
    if (!$result){
        echo mysql_errno()." 出错了：".mysql_error()."<br>";
    }
    var_dump($result);
    return $result;
}
?>