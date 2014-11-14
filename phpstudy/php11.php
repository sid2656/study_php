<?php
    require 'FileUpload.class.php';
    
    $up = new FileUpload(array('allowtype'=>array("jpg"),'filepath'=>'./upload','maxsize'=>1024000));
    
    if ($up->uploadFile('spic')){
        echo print_r($up->getNewFileName())."<br>";
    }else {
        echo $up->getErrorMsg()."<br>";
    };
//    var_dump($up);
?>