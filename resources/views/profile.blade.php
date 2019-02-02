@extends('layout')
<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BDE Cesi - Profil</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/profile.css') }}"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>
</head>

    @section('navbar')
        @parent
    @endsection

<body>
    @section('content')
    <div id="profil_page">
        <h2>Profil</h2>
        <div id="profil_id">
            <?php if(isset($_SESSION['decoded'])){ echo '<img src="http://127.0.0.1:8000/image/'.$_SESSION["decoded"]->profile_pic.'">';}?>
        </div>
        <div id="profil_information">
            <h3>Info utilisateur</h3>
            <form  method="POST" action="http://127.0.0.1:8000/ChangeProfil" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>
                            <label for="email">E-mail :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Email correspondant au profil" id="email" name="email" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nom">Nom :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre nom" id="last_name" name="last_name" />                    
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="prenom">Prenom :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre prénom" id="first_name" name="first_name" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="centre">Centre :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre centre" id="School_name" name="School_name" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mdp">Password :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre mot de passe" id="password" name="password" />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="file">Changer l'image :</label></td>
                        <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                        <td><input type="hidden" name="profil_pic" id="profil_pic"></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="valid" type="submit" name="connect" value="Valider changements">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script>

    
$(document).ready(function(){
    $("#fileToUpload").change(function(){
            var fileName = $("#fileToUpload").val();
            $("#profil_pic").value=fileName.split('\\').pop(); // clean from C:\fakepath OR C:\fake_path 
    });
 });
    });
 });
 </script>

    @endsection
</body>
    @section('footer')
        @parent
    @endsection
</html>