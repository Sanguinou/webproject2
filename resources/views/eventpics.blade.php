@extends('layout')
<?php
session_start();

$url_event="http://localhost:3000/api/events/".$id_event;
if (isset($url_event)){
    $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
    $resp = $myClient -> request('GET',$url_event, ['verify'=>false]);
    if ($resp -> getStatusCode() == 200){
        $body = $resp -> getBody();
        $GLOBALS['event'] = json_decode($body);
    };
};

if(isset($_SESSION['decoded'])){
    $url_reg="http://localhost:3000/api/registers/";
    if (isset($url_reg)){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
        $resp = $myClient -> request('GET',$url_reg,['form_params'=> ['id_event'=> $id_event,'id_user'=>$_SESSION['decoded']->id_user]], ['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
            $bodyreg = $resp -> getBody();
            $decoded = json_decode($bodyreg,true);
            if(isset($decoded)){
                $GLOBALS['isRegistered']=$decoded['isRegistered'];
                if($GLOBALS['isRegistered']!=1){
                    if(isset($_POST['register'])){
                        $url_reg="http://localhost:3000/api/registers/";
                        if (isset($url_reg)){
                            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
                            $resp = $myClient -> request('POST',$url_reg,['form_params'=> ['id_event' => $id_event,'id_user' => $_SESSION['decoded']->id_user]], ['verify'=>false]);
                            if ($resp -> getStatusCode() == 200){
                                echo $_SESSION['decoded']->id_user;
                            };
                        };
                    };
                }else{
                //echo "you are already registered";
                };
            };
        };
    };
};
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
    <!-- main event presentation -->
    <h1 class="titleEventPic center"><?php if(isset($GLOBALS['event']) && sizeof($GLOBALS['event'])>0){echo $GLOBALS['event'][0]->event_name ;}?></h1>
    <div>
        <img class="picEvent imgPos center" src="http://localhost:8000/image/<?php if(isset($GLOBALS['event']) && sizeof($GLOBALS['event'])>0){ echo $GLOBALS['event'][0]->picture_presentation_event;}?>" width="1000" height="600">
        <div class="eventDescPic center">
        <?php if(isset($GLOBALS['event']) && sizeof($GLOBALS['event'])>0){ echo $GLOBALS['event'][0]->event_body ;}?>

        </div>
    </div>
    <div class="vector center"></div>
    <?php
    $url_pic_event="http://localhost:3000/api/pictures_event/";
    if(isset($GLOBALS['isRegistered'])&& isset($GLOBALS['event'])){
        if($GLOBALS['isRegistered']==1 && $GLOBALS['event'][0]->id_status_event==3){
            echo '<button id="addPic" class="buttonStyle3 likePos center">Ajoute une photo</button>
        <div id="addPicForm" style="display:none">                   
            <form id="con" method="POST" action="http://127.0.0.1:8000/AddImage" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><label for="file">Votre Image :</label></td>
                        <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                    </tr>
                    <tr>
                        <td><label for="picture_event_body">Légende :</label></td>
                        <td><textarea id="picture_event_body" name="picture_event_body" rows="10" cols="60"></textarea></td>
                    </tr>  
                </table>
                <input type="hidden" value="'.$_SESSION['decoded']->id_user.'" name="id_user" />
                <input type="hidden" value="'.$GLOBALS['event'][0]->id_event.'" name="id_event" />
                <input type="hidden" id="picture_event_name" name="picture_event_name" value="" />  
 
                <!-- Button for sign up -->
                <input id="btn_Add_Pic" type="submit" name="formAddPic" value="Ajouter l\'image">
            </form>
        </div> ';
        }
    }
    if (isset($url_pic_event)){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('GET',$url_pic_event,['form_params'=> ['id_event' => $id_event, 'id_status_content'=> 1]], ['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
            $body = $resp -> getBody();
            $GLOBALS['pictures_event'] = json_decode($body,true);
            $url_likes="http://localhost:3000/api/likes/";
            if(isset($_SESSION['decoded'])){
                if($_SESSION['decoded']->id_status_user>1){
                echo '      <form action="" method="post">
                                <input type="hidden" name="download" value="1"/>
                                <input class="buttonStyle2 center" type="submit" value="DOWNLOAD image"/>
                            </form>';
                    if(isset($_POST['download'])){
                        foreach($GLOBALS['pictures_event'] as $pic){
                            $image = file_get_contents('http://127.0.0.1:8000/image/'.$pic['picture_event_name']);
                            file_put_contents('C:/'.$pic['picture_event_name'], $image); //Where to save the image on your server
                        }
                    }
                }
            }
            foreach($GLOBALS['pictures_event'] as $pic){
                echo '<div>
                <img class="picEvent imgPos center" src="http://127.0.0.1:8000/image/'.$pic["picture_event_name"].'" width ="1000" height="600">
                <div class=eventPicGrid>
                    <div>
                        <div class="picDesc center">'.$pic["picture_event_body"].'</div>
                        
                    </div>';
                    if(isset($pic)){
                        $urlReg = "http://localhost:3000/api/users/".$pic['id_user'];     
                        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
                        try {
                            $resp =  $myClient -> request('GET',$urlReg);}
                        catch (ClientException $e) {     
                            echo "seems like something went wrong bro";
                        }
                        if(isset($resp)){ 
                            $user = json_decode($resp->getBody());
                            echo '
                    <div>
                        <img class="imgProfileBorder imgProfilePos " src="http://localhost:8000/image/'.$user[0]->profile_pic.'" width="150" height="150">
                        <div class="ideaBoxName center" width="200" height="75">'.$user[0]->first_name." ".$user[0]->last_name.' </div>
                    </div>';
            
                        };
                    };
                    echo '
                </div>
                <div class="likeGrid">
                            <div class="post">POST : '.$pic["created_at"].'</div>
                            ';
                            if(isset($url_likes)){
                                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                                $resp = $myClient -> request('GET',$url_likes,['form_params'=> ['id_picture_event' => $pic['id_picture_event']]], ['verify'=>false]);
                                if ($resp -> getStatusCode() == 200){
                                    $bodyLikes = $resp -> getBody();
                                    $pic['likes'] = json_decode($bodyLikes,true);
                                    if (isset($pic['likes'])&& sizeof($pic['likes'])>0){
                                        foreach($pic['likes'] as $likes){
                                        echo '<button class="buttonStyle1 likePos center">'.$likes['LIKES'].'</button>';

                                        }
                                    }
                                }
                            }
                            if(isset($url_likes) && isset($_SESSION['decoded'])){
                                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                                $resp = $myClient -> request('GET',$url_likes,['form_params'=> ['id_picture_event' => $pic['id_picture_event'], 'id_user'=>$_SESSION['decoded']->id_user]], ['verify'=>false]);
                                if ($resp -> getStatusCode() == 200){
                                    $bodyLikes = $resp -> getBody();
                                    $HasLiked['likes'] = json_decode($bodyLikes,true);
                                    if (isset($HasLiked['likes']) && sizeof($HasLiked['likes'])>0){
                                        echo '
                                        <form id="form" action="http://127.0.0.1:8000/event/SupprLikes/" method="post">
                                            <input type="hidden" name="id_event" value="'.$id_event.'"/>
                                            <input type="hidden" name="id_picture_event" value="'.$pic['id_picture_event'].'"/>
                                            <input type="hidden" name="like" value="1"/>
                                            <input class="buttonStyle3 likePos center" type="submit" value="UNLIKE"/>
                                        </form>';
                                    } else {
                                        echo '
                                        <form id="form" action="http://127.0.0.1:8000/event/AddLikes/" method="post">
                                            <input type="hidden" name="id_event" value="'.$id_event.'"/>
                                            <input type="hidden" name="id_picture_event" value="'.$pic['id_picture_event'].'"/>
                                            <input type="hidden" name="like" value="1"/>
                                            <input class="buttonStyle3 likePos center" type="submit" value="LIKE"/>
                                        </form>';

                                    }
                                }
                            }
                            if(isset($_SESSION['decoded'])){
                                if(($pic['id_user'] == $_SESSION['decoded']->id_user) || $_SESSION['decoded']->id_status_user>1){
                                    echo '
                                    <form id="form" action="http://127.0.0.1:8000/event/SupprImageEvent/" method="post">
                                        <input type="hidden" name="id_user" value="'.$pic['id_user'].'"/>
                                        <input type="hidden" name="id_event" value="'.$id_event.'"/>
                                        <input type="hidden" name="id_picture_event" value="'.$pic['id_picture_event'].'"/>
                                        <input class="buttonStyle3 likePos center" type="submit" value="SUPPR"/>
                                    </form>';
                                }
                            }
                            if(isset($_SESSION['decoded'])){
                                if($_SESSION['decoded']->id_status_user!=1){
                                    echo '
                                    <form id="form" action="http://127.0.0.1:8000/event/SignalerImage/" method="post">
                                        <input type="hidden" name="id_event" value="'.$id_event.'"/>
                                        <input type="hidden" name="id_status_content" value="2"/>                   
                                        <input type="hidden" name="id_picture_event" value="'.$pic['id_picture_event'].'"/>
                                        <input class="buttonStyle3 likePos center" type="submit" value="SIGNALER"/>
                                    </form>';
                                }
                            }
                            echo '
                        </div>
            ';
    if(isset($_SESSION['decoded'])){
            echo '<button id="addCom" class="buttonStyle3 commentButton center">Ajoute un Commentaire</button>
        <div id="addCommForm" style="display:none">                   
            <form id="con" method="POST" action="http://127.0.0.1:8000/event/AddComm" enctype="multipart/form-data">
                        <textarea id="comment_body" class="commentArea center" name="comment_body" placeholder="commentaire" rows="10" cols="50"></textarea>
                <input type="hidden" name="id_event" value="'.$id_event.'"/>
                <input type="hidden" value="'.$_SESSION['decoded']->id_user.'" name="id_user" />
                <input type="hidden" value="'.$pic['id_picture_event'].'" name="id_picture_event" />

                <!-- Button for sign up -->
                <input id="btn_Add_Pic" class="buttonStyle3 commentButton center" type="submit" name="formAddCom" value="Ajouter le commentaire">
            </form>
        </div> ';
    }
                $url_comments="http://localhost:3000/api/comments/";
                if (isset($url_comments)){
                    $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                    $resp = $myClient -> request('GET',$url_comments,['form_params'=> ['id_picture_event' => $pic['id_picture_event'], 'id_status_content'=>1]], ['verify'=>false]);
                    if ($resp -> getStatusCode() == 200){
                        $bodypic = $resp -> getBody();
                        $pic['comments'] = json_decode($bodypic,true);
                        if(isset($pic['comments'])&& sizeof($pic['comments'])>0){
                        foreach($pic['comments'] as $comments){
                            
                                $urlReg = "http://localhost:3000/api/users/".$comments['id_user'];     
                                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
                                try {
                                    $resp =  $myClient -> request('GET',$urlReg);}
                                catch (ClientException $e) {     
                                    echo "seems like something went wrong bro";
                                }
                                if(isset($resp)){ 
                                    $user = json_decode($resp->getBody());
                                    echo '
                                    <div class="commentGrid eventDescPic center" style="height: 175px; padding: 0;">
                                        <div>
                                            <img class="imgProfileBorder imgProfilePos center" style="left: 10px"; src="http://localhost:8000/image/'.$user[0]->profile_pic.'" width="100" height="100">
                                            <div class="ideaBoxName center" width="200" height="75" style="left: 5px; margin-top: 5px; border: transparent; background-color: transparent;"> <b>'.$user[0]->first_name." ".$user[0]->last_name.'</b> </div>
                                        </div>
                                    <div>';
                    
                                };
                          
                        echo '
                            <div class="comment center">'.$comments["comment_body"].'
                            </div>
                            <div class="commentBtnGrid">
                                <div class="post">POST : '.$comments["created_at"].'</div>';
                                if(isset($_SESSION['decoded'])){
                                    if(($comments['id_user'] == $_SESSION['decoded']->id_user) || $_SESSION['decoded']->id_status_user==2){
                                        echo '
                                        <form id="form" action="http://127.0.0.1:8000/event/SupprComment/" method="post">
                                            <input type="hidden" name="id_event" value="'.$id_event.'"/>                                            
                                            <input type="hidden" name="id_comment" value="'.$comments['id_comment'].'"/>
                                            <input class="buttonStyle3 likePos center" type="submit" value="SUPPR"/>
                                        </form>';
                                    }
                                }
                                if(isset($_SESSION['decoded'])){
                                    if($_SESSION['decoded']->id_status_user!=1){
                                        echo '
                                        <form id="form" action="http://127.0.0.1:8000/event/SignalerComment/" method="post">
                                            <input type="hidden" name="id_event" value="'.$id_event.'"/>
                                            <input type="hidden" name="id_status_content" value="2"/>                   
                                            <input type="hidden" name="id_comment" value="'.$comments['id_comment'].'"/>
                                            <input class="buttonStyle3 likePos center" type="submit" value="SIGNALER"/>
                                        </form>';
                                    }
                                }
                                echo '
                            </div>
                        </div>     
                    </div>
                </div>';    };
                        };
                    };

                };
            };
        };
    }; 
?>

        <button id="btncom1" class="buttonStyle2 commentButton" onclick="HideComment('hiddenComment1', 'btncom1')">voir plus de commentaires ></button> 
        <div id="hiddenComment1" class="hide">
            <div class="commentGrid eventDescPic center" style="height: 175px; padding: 0;">

            </div>
        </div>
        <div class="vector center"></div>
    </div>
    <script>
$(document).ready(function(){
  $("#addPic").click(function(){
    $("#addPicForm").toggle();
  });
});

$(document).ready(function(){
  $("#addCom").click(function(){
    $("#addCommForm").toggle();
  });
});


    $(document).ready(function(){
    $("#fileToUpload").change(function(){
            var fileName = $("#fileToUpload").val();
            $("#picture_event_name").val(fileName.split('\\').pop());
    });
 });
 </script>

    @endsection
</body>

    @section('footer')
        @parent
    @endsection

</html>