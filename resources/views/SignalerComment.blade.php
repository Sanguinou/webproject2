<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
    };
    $url_comment="http://localhost:3000/api/comments/";
    if (isset($url_comment) && isset($_SESSION['decoded'])){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('PUT',$url_comment,['form_params'=> ['id_comment' => $_POST['id_comment'],'id_status_content' => $_POST['id_status_content']
        ]], ['verify'=>false]);
    } 
    if(isset($_POST['id_event'])){
        header("Location:http://127.0.0.1:8000/event/".$_POST['id_event']);
        exit();
    } else{
        header("Location:http://127.0.0.1:8000/event/");
        exit();
    }
?>
