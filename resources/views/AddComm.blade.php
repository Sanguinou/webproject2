<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
    };
    $url_comm_pic_event="http://localhost:3000/api/comments/";
    if (isset($url_comm_pic_event) && isset($_SESSION['decoded'])){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('POST',$url_comm_pic_event,['form_params'=> ['id_picture_event' => $_POST['id_picture_event'],'id_user'=> $_SESSION['decoded']->id_user
        ,'comment_body'=> $_POST['comment_body']
        ]], ['verify'=>false]);    
    }
    header("Location:http://127.0.0.1:8000/event/".$_POST['id_event']);
    exit();

?>
