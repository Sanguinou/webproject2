<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
    };

    $url_vote_idea="http://localhost:3000/api/Votes/";
    if (isset($url_vote_idea) && isset($_SESSION['decoded']) && isset($_POST['vote'])){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('POST',$url_vote_idea,['form_params'=> ['id_event' => $_POST['id_event'],'id_user' => $_SESSION['decoded']->id_user
        ]], ['verify'=>false]);
        header("Location:http://127.0.0.1:8000/ideabox");
        exit();

}

?>
