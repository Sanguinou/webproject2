@extends('layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Event</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/create_event.css') }}"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>

</head>
@section('navbar')
        @parent
@endsection
<body>
    @section('content')
    <div id="create_event">
        <h2 class="title">Creer un événement</h2>
        <div class="gridCreate">
            <div id="info_event" >
                <h3>Info de L'Event</h3>
                <form id="createEvent" method="POST" action="http://127.0.0.1:8000/AddEvent" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <label for="nom">Nom de l'event :</label>
                            </td>
                            <td>
                                <input type="text" placeholder="Nom de l'event" id="event_name" name="event_name" />                    
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="prenom">Date de l'event :</label>
                            </td>
                            <td>
                                <input type="text" placeholder="jj/mm/aaaa" id="event_date" name="event_date" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="lieu">Lieu de l'event :</label>
                            </td>
                            <td>
                                <input type="text" placeholder="Arras" id="event_location" name="event_location" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="desc">Description :</label>
                            </td>
                            <td>
                                <textarea type="text" id="event_body" name="event_body"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="file">Votre Image :</label></td>
                            <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                            <input type="hidden" id="picture_presentation_event" name="picture_presentation_event" value="" />  

                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input id="valid" type="submit" name="connect" value="Valider changements">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function(){
    $("#fileToUpload").change(function(){
            var fileName = $("#fileToUpload").val();
            $("#picture_presentation_event").val(fileName.split('\\').pop());
    });
 });
 </script>
@endsection
</body>
   @section('footer')
        @parent
    @endsection
</html>