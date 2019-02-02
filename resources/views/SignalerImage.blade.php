<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
    };
    $url_image="http://localhost:3000/api/pictures_event/";
    if (isset($url_image) && isset($_SESSION['decoded'])){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('PUT',$url_image,['form_params'=> ['id_picture_event' => $_POST['id_picture_event'],'id_status_content' => $_POST['id_status_content']
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
