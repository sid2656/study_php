<?php
    session_start();
    include 'validationcode.class.php';
    $code = new ValidationCode();
    $code->showImage();
    $_SESSION["code"] = $code->getCheckCode();
?>