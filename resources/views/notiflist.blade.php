@extends('layout')

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{  asset('css/admin.css') }}"/>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>
</head>

@section('navbar')
    @parent
@endsection

<body>
    @section('content')
        <h3 class="title">commentaire :</h3>
            <table class="center">
                @foreach($orders as $order)
                    @if($order->id_status_order == 1)
                        <tr>
                            <td>
                                <a href="">commande #{{ $order->id_order }}</a>
                                <button class= "buttonStyle3 deletePos" href=""> redirection </button>
                                <button class= "buttonStyle2 deletePos" href=""> supprimer </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        <h3 class="title">images :</h3>
            <table class="center">
                 @foreach($orders as $order)
                    @if($order->id_status_order == 2)
                        <tr>
                            <td>
                                <a href="">commande #{{ $order->id_order }}</a>
                                <button class= "buttonStyle3 deletePos" href=""> redirection </button>
                                <button class= "buttonStyle2 deletePos" href=""> supprimer </button>
                        </tr>
                    @endif
                @endforeach
            </table>
    @endsection
</body>

@section('footer')
    @parent
@endsection

</html>