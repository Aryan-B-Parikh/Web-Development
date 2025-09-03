<?php
    $unamee = $_GET["username"];
    $psd = $_GET["password"];
    $_REQUEST["username"] = $unamee;
    $_REQUEST["password"] = $psd;
    echo"NAME: ".$_REQUEST["username"]." PASSWORD: ".$_REQUEST["password"]."";
?>