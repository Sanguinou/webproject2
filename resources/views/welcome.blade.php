@extends('layout')

<?php
session_start();
$MaxEventsShown = 1;

$url_product="http://localhost:3000/api/products/top";
$url_event = "http://localhost:3000/api/events";
    if (isset($url_event)){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('GET',$url_event,['form_params'=> ['id_status_event' => 2]], ['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
            $body = $resp -> getBody();
            $GLOBALS['events'] = json_decode($body);
        };
    };
    if (isset($url_event)){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('GET',$url_event,['form_params'=> ['id_status_event' => 1]], ['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
            $body = $resp -> getBody();
            $GLOBALS['ideas'] = json_decode($body);
            $GLOBALS['RandIdea'] = Rand(0,SizeOf($GLOBALS['ideas'])-1);

            if(isset($GLOBALS['RandIdea'])){
                $urlReg = "http://localhost:3000/api/users/".$GLOBALS['ideas'][$GLOBALS['RandIdea']]->id_user_create;     
                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
                try {
                    $resp =  $myClient -> request('GET',$urlReg);}
                catch (ClientException $e) {     
                    echo "seems like something went wrong bro";
                }
                if(isset($resp)){ 
                    $obj = json_decode($resp->getBody());
                    $GLOBALS['ideas'][$GLOBALS['RandIdea']]->user_name = $obj[0]->first_name." ".$obj[0]->last_name;
                    $GLOBALS['ideas'][$GLOBALS['RandIdea']]->profile_pic = $obj[0]->profile_pic;
                }
            };
        };
    };
    if (isset($url_product)){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('GET',$url_product,['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
            $body = $resp -> getBody();
            $GLOBALS['products'] = json_decode($body);
        };
    };
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>BDE Cesi - Acceuil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/style.css') }}" />
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>
</head>
@section('navbar')
        @parent
@endsection
<body>
@section('content')

    <div class="welcomeGrid">
        <div>
            <div class="bg">
                <img class="blurBackground" src="http://localhost:8000/image/<?php echo $GLOBALS['events'][0]->picture_presentation_event;?>">
            </div>
            <div class="welcomeEventGrid">
                <div>
                    <img id="eventPic" class="imgBorder imgPos center" src="http://localhost:8000/image/<?php echo $GLOBALS['events'][0]->picture_presentation_event;?>" width="600" height="300">
                    <p class="titleEvent tEventPos center"><?php echo $GLOBALS['events'][0]->event_name." - ".$GLOBALS['events'][0]->event_date;?> </p>
                    <form id='form' action=<?php if(isset($GLOBALS['events'])){echo "event/".$GLOBALS['events'][0]->id_event ;}?> method='post'>
                        <input type='hidden' name='register' value='1'/>
                        <input type='submit' value="S'inscrire maintenant" class='buttonStyle1 buttonEventPos'/>
                    </form>
                </div>
                <div>
                    <div class="textEvent center">
                        <?php echo $GLOBALS['events'][0]->event_body ?>
                    </div>
                </div>
                <button class="buttonStyle2 viewAllPos" onclick="location.href = 'http://127.0.0.1:8000/event';"> Voir Tout ></button>
            </div>
        </div>
        <div>
            <h1 class="title">Boutique</h1>
            <button class="buttonStyle2 viewAllPos" onclick="location.href =  'http://127.0.0.1:8000/shop';"> voir tout ></button>
            <div class="topMerchGrid">
                <?php if(isset($GLOBALS['products']) && sizeof($GLOBALS['products'])>0){                    
                        for($i=0;$i<3;$i++){
                            $url_pic_product='http://localhost:3000/api/pictures_product/'.$GLOBALS['products'][$i]->id_product;
                                if (isset($url_product)){
                                    $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                                    $resp = $myClient -> request('GET',$url_pic_product,['verify'=>false]);
                                    if ($resp -> getStatusCode() == 200){
                                        $body = $resp -> getBody();
                                        $pic_products = json_decode($body);
                                        if(isset($pic_products)){
                                            foreach($pic_products as $pic_products){
                                                echo '
                                                <div>
                                                    <a href="http://127.0.0.1/product/'.$GLOBALS['products'][$i]->id_product.'">
                                                        <img class="imgBorder imgPos center" src="http://127.0.0.1:8000/image/'.$pic_products->picture_product_name.'" width="300" height="500">
                                                    </a>
                                                    <div class="nameProduct" width="300" height="100">
                                                        '.$GLOBALS['products'][$i]->product_name.' - <b>'.$GLOBALS['products'][$i]->product_price.' €</b>
                                                    </div>
                                                </div>';  
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ?>
            </div>
        </div>
        <div>
            <h1 class="title">Boite à Idée</h1>
            <button class="buttonStyle2 viewAllPos" onclick="location.href = 'http://127.0.0.1:8000/ideabox';"> Voir Tout ></button>
            <div class="ideaBox imgPos center">
                <div class="ideaBoxGrid">
                    <div>
                        <img class="imgProfileBorder imgProfilePos " src="http://localhost:8000/image/<?php echo $GLOBALS['ideas'][$GLOBALS['RandIdea']]->profile_pic;?>" width="150" height="150">
                        <div class="ideaBoxName center" width="200" height="75"> <b><?php echo $GLOBALS['ideas'][$GLOBALS['RandIdea']]->user_name; ?></b> </div>
                        <button class="buttonStyle1 buttonIdeaPos center">Voir plus ></button>
                    </div>
                    <div class="ideaBoxText center">
                        <?php echo $GLOBALS['ideas'][$GLOBALS['RandIdea']]->event_body;?>
                    </div>
                </div>
            </div>
        </div> 
        <div>
            <h1 class="title">Réseaux Sociaux</h1>
            <div class="topMerchGrid">
                <button class="buttonNetwork center" style="background-image: url({{ asset('image/fblogo.png') }}" onclick="location.href = 'http://www.facebook.com/CesiCampusArras/?ref=br_rs';"></button>
                <button class="buttonNetwork center" style="background-image: url({{ asset('image/tlogo.png') }}" onclick="location.href = 'https://twitter.com/eXiaCesiArras';"></button>
                <button class="buttonNetwork center" style="background-image: url({{ asset('image/cesilogo.png') }}" onclick="location.href = 'http://www.cesi.fr';"></button>
            </div>
        </div> 
    </div>
    @endsection
</body>
    @section('footer')
        @parent
    @endsection
</html>
