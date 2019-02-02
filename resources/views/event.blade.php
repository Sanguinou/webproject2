@extends('layout')

<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>BDE Cesi - Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{  asset('css/style.css') }}"/>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>
</head>

    @section('navbar')
        @parent
    @endsection

<body>
    @section('content')
    <div>
        <h1 class="title">événement</h1>
        <button id=filterEvent class="buttonStyle3 buttonFilterPos dropdown" onclick="Drop('dropFilterEvent')">Filtre</button>
        <div id="dropFilterEvent" class="drop-content filterPos">
            <a id="comming">Prochain evenements</a>
            <a id="done">Evenement finis</a>
            <a id="all">Afficher tous</a>
        </div>
        <?php

$url_event = "http://localhost:3000/api/events";
    if (isset($url_event)){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('GET',$url_event, ['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
            $body = $resp -> getBody();
            $obj = json_decode($body,true);
            $register="Rejoindre";
                foreach($obj as $obj){

                    if($obj['id_status_event']==2){  
                        echo '
                    <div class="nextEvent hide show">
                        <div class="eventGrid">
                            <div>
                                <img class="picEvent imgPos center" src="http://localhost:8000/image/'.$obj["picture_presentation_event"].'" width="500" height="300">
                                <p class="titleEvent tEventPos center">'.$obj["event_name"].' - '.$obj["event_date"].'- </p>
                                <form id="form" action=http://127.0.0.1:8000/event/'.$obj["id_event"].' method="post">
                                    <input type="hidden" name="register" value="1"/>
                                    <input class="buttonStyle1 buttonEventPos" type="submit" value="'.$register.'"/>
                                </form>;
                            </div>
                            <div class="eventDesc center">
                                '.$obj["event_body"].'
                            </div>
                        </div>
                        <div class="vector center"></div>
                    </div>'; 
                    }
                    else if ($obj["id_status_event"]==3){
                        echo '
                        <div class="finishedEvent hide show">
                        <div class="eventGrid">
                            <div>
                                <img class="picEvent imgPos center" src="http://localhost:8000/image/'.$obj["picture_presentation_event"].'" width="500" height="300">
                                <p class="titleEvent tEventPos center">'.$obj["event_name"].' - '.$obj["event_date"].'- </p>
                                <form id="form" action=http://127.0.0.1:8000/event/'.$obj["id_event"].' method="post">
                                <input class="buttonStyle1 buttonEventPos" type="submit" value="Voir les photos"/>
                                </form>;                            
                                </div>
                            <div class="eventDesc center">
                            '.$obj["event_body"].'
                            </div>
                        </div>
                        <div class="vector center"></div>
                        </div>';                        
                    };
                };
        };
    };
    ?>
    </div>
<script>
$(document).ready(function(){
  $("#comming").click(function(){
    $(".nextEvent").show();
    $(".finishedEvent").hide();
  });
});
$(document).ready(function(){
  $("#done").click(function(){
    $(".nextEvent").hide();
    $(".finishedEvent").show();
  });
});
$(document).ready(function(){
  $("#all").click(function(){
    $(".nextEvent").show();    
    $(".finishedEvent").show();
  });
});


</script>
@endsection

           
</body>

    @section('footer')
        @parent
    @endsection

</html>