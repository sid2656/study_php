<?php
    session_start();
    echo @$_POST["code"]."<br>";
    echo $_SESSION["code"]."<br>";
    
    if (strtoupper($_POST["code"])==strtoupper($_SESSION["code"])){
    	echo strtoupper($_POST["code"]);
        echo "ok";
    }else{
        echo "error";
    }
?>