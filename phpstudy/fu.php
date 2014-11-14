<?php

    $username = $_POST["username"];
    $password = $_POST["password"];
    //可以重名；然后按照数组来取值
    $myfile1 = $_FILES["myfile1"];
    $myfile2 = $_FILES["myfile2"];
    $name3 = $_FILES["myfile"][name][0];
    $name4 = $_FILES["myfile"][name][1];
    $name5 = $_FILES["myfile"][name][2];
    print_r($_FILES)."<br>";
    echo "用户名：".$username."密码：".$password."<br>";
    echo "文件一名：".$myfile1[name]."<br>";
    echo "文件一类型：".$myfile1[type]."<br>";
    echo "文件一文件路径：".$myfile1[tmp_name]."<br>";
    echo "文件一错误信息：".$myfile1[error]."<br>";
    echo "文件二：".$myfile2[name]."<br>";
    echo "文件三：".$name3."<br>";
    echo "文件四：".$name4."<br>";
    echo "文件五：".$name5."<br>";
    
    $uploadfile = $myfile1[name];
    $copyto = "test/".time().$uploadfile;
    if (is_uploaded_file($uploadfile)){
        if (move_uploaded_file($uploadfile, $copyto)){
            echo "上传文件成功<br>";
        }else{
            echo "上传文件失败<br>";
        }
    }
    
?>