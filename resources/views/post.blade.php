<?php
session_start();
use \Firebase\JWT\JWT;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
    $url = "http://localhost:3000/api/login";
    if (isset($url)){
        $myClient = new GuzzleHttp\Client([
            'headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']
        ]);
    
        $resp = $myClient -> request('POST',$url,[
            'form_params'=> [
                'password' => 'tryhard',
                'email' => 'test@test.com'
            ]
            ]);
        if ($resp -> getStatusCode() == 200){
            $obj = json_decode($resp->getBody());
            $_SESSION['token'] = $obj->token;
            $_SESSION['decoded'] = JWT::decode($_SESSION['token'],'secret',array('HS256'));
            print_r($_SESSION['decoded']);
            };
        }
    ?>


</body>
</html>