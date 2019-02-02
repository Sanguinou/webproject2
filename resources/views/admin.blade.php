@extends('layout')
<?php
session_start();
if(isset($_SESSION['decoded'])){
    if(($_SESSION['decoded']->id_status_user)=="1"){
        header("Location:http://127.0.0.1:8000/");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
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
    <div class="gridOS">
        <div class="center">
            <h3>Commande :</h3>
            <table class="center">
            <?php
                    $url_order="http://localhost:3000/api/orders/";
                    if (isset($url_order)){
                        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                        $resp = $myClient -> request('GET',$url_order,['verify'=>false]);
                        if ($resp -> getStatusCode() == 200){
                            $body = $resp -> getBody();
                            $orders = json_decode($body);
                            foreach($orders as $order){
                                //URL de la commande 
                                echo '
                                    <tr>
                                        <td>
                                        <a href="">order '.$order->id_order.'</a> 
                                        </td>
                                    </tr>'
                                ;
                            }
                        }
                    }
            ?>
            </table>
            <p><a href="">Afficher toutes les commandes</a></p>
        </div>
        <div class="center">
            <h3>Notification :</h3>
            <table class="center">
                
            </table>
            <p><a href="">Afficher tous les signalements</a></p>
        </div>
    </div>
    <div class="pos">
        <div>
            <h3>stock des produits</h3>
            <table class="prodList">
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>description</th>
                <th>stock</th>
            </tr>
            <?php
                    $url_product="http://localhost:3000/api/products/";
                    if (isset($url_product)){
                        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                        $resp = $myClient -> request('GET',$url_product,['verify'=>false]);
                        if ($resp -> getStatusCode() == 200){
                            $body = $resp -> getBody();
                            $products = json_decode($body);
                            foreach($products as $product){
                                echo '
                                    <tr>
                                        <td>
                                        <p>'.$product->product_name.'</p>
                                        </td>
                                        <td>
                                        <p>'.$product->product_price.'</p>
                                        </td>
                                        <td>
                                        <p>'.$product->product_desc.'</p> 
                                        </td>
                                        <td>
                                        <p>'.$product->stock.'</p>
                                        </td>    
                                    </tr>';
                                ;
                            }
                        }
                    }
            ?>            
        </table>
        </div> 
        <button class="buttonStyle3 prodbtnpos">Ajouter / modifier produit</button>   
    </div>
@endsection
</body>

@section('footer')
    @parent
@endsection

</html>