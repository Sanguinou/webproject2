<?php
    session_start();
    if(isset($_SESSION['timeout'])){
            session_unset();
    };          
    header("Location:http://127.0.0.1:8000/");
    exit();
?>