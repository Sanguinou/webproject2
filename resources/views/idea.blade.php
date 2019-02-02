@extends('layout')
<?php
session_start();
$url_event = "http://localhost:3000/api/events";
if (isset($url_event)){
    $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
    $resp = $myClient -> request('GET',$url_event,['form_params'=> ['id_status_event' => 1]], ['verify'=>false]);
    if ($resp -> getStatusCode() == 200){
        $body = $resp -> getBody();
        $GLOBALS['ideas'] = json_decode($body);
    };
};
?>
<!DOCTYPE html>
<html>
<head>
<title>BDE Cesi - Idea Box</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{  asset('css/style.css') }}"/>
    <script src="{{ asset('js/script.js') }}"></script>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>
</head>

    @section('navbar')
        @parent
    @endsection

<body>
    @section('content')
    <h1 class="title">boite à idée</h1>
    <?php 
    foreach($GLOBALS['ideas'] as $idea){
            if($idea->id_status_event == 1){
                echo '
                <div class="ideaBox imgPos center">
                    <div class="ideaBoxGrid">
                        <div>';
                        if(isset($idea)){
                            $urlReg = "http://localhost:3000/api/users/".$idea->id_user_create;     
                            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
                            try {
                                $resp =  $myClient -> request('GET',$urlReg);}
                            catch (ClientException $e) {     
                                echo "seems like something went wrong bro";
                            }
                            if(isset($resp)){ 
                                $obj = json_decode($resp->getBody());
                                $idea->user_name = $obj[0]->first_name." ".$obj[0]->last_name;
                                $idea->profile_pic = $obj[0]->profile_pic;
                                    echo '
                            <img class="imgProfileBorder imgProfilePos " src="http://localhost:8000/image/'.$idea->profile_pic.'" width="150" height="150">
                            <div class="ideaBoxName center" width="200" height="75">'.$idea->user_name.' </div>';
                               }
                        };
                        echo '
                        <form id="form" action=http://127.0.0.1:8000/AddVotes method="post">
                            <input type="hidden" name="id_event" value="'.$idea->id_event.'"/>
                            <input type="hidden" name="vote" value="1"/>
                            <input class="buttonStyle1 buttonEventPos" type="submit" value="Vote"/>
                        </div>
                        <div class="ideaBoxText center">
                            '.$idea->event_name.' <br/> '.$idea->event_body.'
                        </div>
                    </div>
                </div>
                <div class="vector center"></div>';
            }
        }
        ?>
    @endsection
</body>

    @section('navbar')
        @parent
    @endsection

</html>