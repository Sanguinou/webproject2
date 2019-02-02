@extends('layout')

<?php
session_start();
use GuzzleHttp\Psr7;
use \Firebase\JWT\JWT;
use GuzzleHttp\Exception\ClientException;

if(isset($_SESSION['timeout'])){
    if ($_SESSION['timeout'] + 5 * 60 < time()) {
        session_unset();
        header("Location:http://127.0.0.1:8000/connection");
        exit();     
    }else{
        header("Location:http://127.0.0.1:8000/");
        exit();  
    }; 
};

$urlLog = "http://localhost:3000/api/login";
$urlReg = "http://localhost:3000/api/users";

if (isset($urlLog) && isset($_POST['password']) && !isset($_POST['first_name'])){
     
     $myClient = new GuzzleHttp\Client([
         'headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']
     ]);
    try {
     $resp =  $myClient -> request('POST',$urlLog,[
         'form_params'=> [
             'password' => hash('ripemd160',$_POST['password']),
             'email' => $_POST['email']
         ]
         ]);} 
    catch (ClientException $e) {     
         echo "seems like something went wrong bro";
    }
    if(isset($resp)){
     if ($resp -> getStatusCode() == 200){
         $obj = json_decode($resp->getBody());
         $_SESSION['token'] = $obj->token;
         $_SESSION['decoded'] = JWT::decode($_SESSION['token'],'secret',array('HS256'));
         $_SESSION['timeout'] = time();
         header("Location:http://127.0.0.1:8000/");
         exit();
        }
    }
}else if (isset($urlReg) && isset($_POST['password']) && isset($_POST['first_name'])){
     
        $myClient = new GuzzleHttp\Client([
            'headers'=> ['User-Agent' => 'MyReader','Content-Type' =>'application/json']]);
       try {
        $resp =  $myClient -> request('POST',$urlReg,[
            'form_params'=> [
                'password' => hash('ripemd160',$_POST['password']),
                'email' => $_POST['email'],
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'id_school' => $_POST['school']]]);
        } catch (ClientException $e) {     
            echo "seems like something went wrong bro";
        }
            header("Location:http://localhost:8000/");
            exit();
        };

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site BDE - Connexion</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/connexion.css') }}"/>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>

</head>
    @section('navbar')
        @parent
    @endsection

<body>
    @section('content')
    <div>
        <h2 class="title">Connexion</h2>
        <!-- grey zone -->
        <div id="login_zone" class="gridLogin">       
            <!-- Inscription bloc -->                
            <div id="inscription" class="center">                   
                <h3>Inscription</h3>
                <form method="POST" action="connection">
                    <label for="nom">Nom :</label>
                    <input class="input" type="text" placeholder="Votre nom" id="nom" name="last_name" />
                    <label for="prenom">Prénom :</label>
                    <input class="input" type="text" placeholder="Votre Prénom" id="prenom" name="first_name" />
                    <label for="centre">Centre :</label>
                    <select class="input" name="school">
                        <option value="2">Arras</option>
                        <option value="1">Lille</option>
                        <option value="19">Bordeaux</option>
                        <option value="20">Lyon</option>
                    </select>
                    <label for="email">E-Mail :</label>
                    <input class="input" type="email" placeholder="Votre e-mail" id="email" name="email" />
                    <label for="mdp">Mot de passe :</label>
                    <input class="input" type="password" placeholder="Votre mot de passe" id="mdp" name="password" />
                    <input id="signup" type="submit" name="forminscritpion" value="Sign up">
                </form>
            </div>
            <!-- Connexion bloc -->
            <div id="connexion" class="center">                   
                <h3>Connexion</h3>
                <form id="con" method="POST" action="connection">
                    
                    <label for="email">E-Mail :</label>
                    <input class="input_login" type="email" placeholder="Votre e-mail" id="email" name="email" />
                
                    <td><label for="mdp">Mot de passe :</label></td>
                    <td><input class="input_login" type="password" placeholder="Votre mot de passe" id="mdp" name="password" /> 
                    <!-- Button for sign up -->
                    <input id="btn_connect" type="submit" name="forminscritpion" value="Sign in">
                </form>
            </div>     
        </div>
    </div>
    @endsection
</body>

    @section('footer')
        @parent
    @endsection

</html>