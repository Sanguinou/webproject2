@extends('layout')

<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>BDE Cesi - Shop</title>
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
    <h1 class="title">Boutique</h1> 
    <h2 class="title2">Top produits :</h2>
    <div class="topMerchGrid">
    <?php 
        $url_top_product="http://localhost:3000/api/products/top";
        if (isset($url_top_product)){
            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
            $resp = $myClient -> request('GET',$url_top_product,['verify'=>false]);
            if ($resp -> getStatusCode() == 200){
                $body = $resp -> getBody();
                $top_products = json_decode($body);
                if(isset($top_products)){                    
                    for($i=0;$i<3;$i++){
                        $url_pic_product='http://localhost:3000/api/pictures_product/'.$top_products[$i]->id_product;
                            if (isset($url_pic_product)){
                                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                                $resp = $myClient -> request('GET',$url_pic_product,['verify'=>false]);
                                if ($resp -> getStatusCode() == 200){
                                    $body = $resp -> getBody();
                                    $pic_products = json_decode($body);
                                    if(isset($pic_products)){
                                            echo '
                                            <div>
                                                <a href="http://127.0.0.1/product/'.$top_products[$i]->id_product.'">
                                                    <img class="imgBorder imgPos center" src="http://127.0.0.1:8000/image/'.$pic_products[0]->picture_product_name.'" width="300" height="500">
                                                </a>
                                                <div class="nameProduct" width="300" height="100">
                                                    '.$top_products[$i]->product_name." ".'<b>'.$top_products[$i]->product_price.' €</b>
                                                </div>
                                                <form class="products" id="add'.$top_products[$i]->id_product.'" action=http://127.0.0.1:8000/panier/  method="post">
                                                    <input type="hidden" name="action" value="ajout">
                                                    <input type="hidden" name="id_product" value="'.$top_products[$i]->id_product.'"/>
                                                    <input type="hidden" name="product_price" value="'.$top_products[$i]->product_price.'">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input class="buttonStyle1 buttonShopPos" type="submit" value="+">
                                                </form>
                
                                                <form class="products" id="del'.$top_products[$i]->id_product.'" action=http://127.0.0.1:8000/panier/  method="post">
                                                    <input type="hidden" name="action" value="suppression">
                                                    <input type="hidden" name="id_product" value="'.$top_products[$i]->id_product.'">
                                                    <input type="hidden" name="product_price" value="'.$top_products[$i]->product_price.'">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input class="buttonStyle1 buttonShopPos" type="submit" value="-">
                                                </form>
                                            </div>';
                                    }
                                }
                            }
                        }
                    }
            };
        };
    ?>
    </div>
    <h2 class="title2">Produits :</h2>
    <button id=filterEvent class="buttonStyle3 buttonFilterPos dropdown" onclick="Drop('dropFilterEvent')">Filtre</button>
        <div id="dropFilterEvent" class="drop-content filterPos">
            <a id="apparels_action">Vêtements</a>
            <a id="accessories_action">Accessoires</a>
            <a id="ShowAll">Afficher tous</a>
        </div>
    <div id=apparels class="hide show">
    <div class="titleEvent tEventPos">vêtements :</div>
        <div class="topMerchGrid">
        <?php 
        $url_product="http://localhost:3000/api/products/";
        if (isset($url_product)){
            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
            $resp = $myClient -> request('GET',$url_product,['verify'=>false]);
            if ($resp -> getStatusCode() == 200){
                $body = $resp -> getBody();
                $products = json_decode($body);
                if(isset($products)){                    
                    foreach($products as $products){
                        $url_pic_product='http://localhost:3000/api/pictures_product/'.$products->id_product;
                        if($products->id_category==1){
                            if (isset($url_pic_product)){
                                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                                $resp = $myClient -> request('GET',$url_pic_product,['verify'=>false]);
                                if ($resp -> getStatusCode() == 200){
                                    $body = $resp -> getBody();
                                    $pic_products = json_decode($body);
                                    if(isset($pic_products) && sizeof($pic_products)>0 ){
                                            echo '
                                            <div>
                                                <a href="http://127.0.0.1:8000/product/'.$products->id_product.'">
                                                    <img class="imgBorder imgPos center" src="http://127.0.0.1:8000/image/'.$pic_products[0]->picture_product_name.'" width="300" height="500">
                                                </a>
                                                <div class="nameProduct" width="300" height="100">
                                                    '.$products->product_name." ".'<b>'.$products->product_price.' €</b>
                                                </div>
                                                <form class="products" id="add'.$products->id_product.'" action=http://127.0.0.1:8000/panier/  method="post">
                                                    <input type="hidden" name="action" value="ajout">
                                                    <input type="hidden" name="id_product" value="'.$products->id_product.'"/>
                                                    <input type="hidden" name="product_price" value="'.$products->product_price.'">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input class="buttonStyle1 buttonShopPos" type="submit" value="+">
                                                </form>
                
                                                <form class="products" id="del'.$products->id_product.'" action=http://127.0.0.1:8000/panier/  method="post">
                                                    <input type="hidden" name="action" value="suppression">
                                                    <input type="hidden" name="id_product" value="'.$products->id_product.'">
                                                    <input type="hidden" name="product_price" value="'.$products->product_price.'">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input class="buttonStyle1 buttonShopPos" type="submit" value="-">
                                                </form>
                                            </div>';
                                    };
                                };
                            };
                        };
                    };
                };  
            };
        };
    ?>
        </div>
    </div>
    <div id="accessories" class="hide show">
        <div class="titleEvent tEventPos">accessoires :</div>
        <div class="topMerchGrid">
        <?php 
        $url_product="http://localhost:3000/api/products/";
        if (isset($url_product)){
            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
            $resp = $myClient -> request('GET',$url_product,['verify'=>false]);
            if ($resp -> getStatusCode() == 200){
                $body = $resp -> getBody();
                $products = json_decode($body);
                if(isset($products)){                    
                    foreach($products as $products){
                        $url_pic_product='http://localhost:3000/api/pictures_product/'.$products->id_product;
                        if($products->id_category==2){
                            if (isset($url_pic_product)){
                                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                                $resp = $myClient -> request('GET',$url_pic_product,['verify'=>false]);
                                if ($resp -> getStatusCode() == 200){
                                    $body = $resp -> getBody();
                                    $pic_products = json_decode($body);
                                    if(isset($pic_products) && sizeof($pic_products)>0 ){
                                            echo '
                                            <div>
                                                <a href="http://127.0.0.1:8000/product/'.$products->id_product.'">
                                                    <img class="imgBorder imgPos center" src="http://127.0.0.1:8000/image/'.$pic_products[0]->picture_product_name.'" width="300" height="500">
                                                </a>
                                                <div class="nameProduct" width="300" height="100">
                                                    '.$products->product_name." ".'<b>'.$products->product_price.' €</b>
                                                </div>
                                                <form class="products" id="add'.$products->id_product.'" action=http://127.0.0.1:8000/panier/  method="post">
                                                    <input type="hidden" name="action" value="ajout">
                                                    <input type="hidden" name="id_product" value="'.$products->id_product.'"/>
                                                    <input type="hidden" name="product_price" value="'.$products->product_price.'">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input class="buttonStyle1 buttonShopPos" type="submit" value="+">
                                                </form>
                
                                                <form class="products" id="del'.$products->id_product.'" action=http://127.0.0.1:8000/panier/  method="post">
                                                    <input type="hidden" name="action" value="suppression">
                                                    <input type="hidden" name="id_product" value="'.$products->id_product.'">
                                                    <input type="hidden" name="product_price" value="'.$products->product_price.'">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input class="buttonStyle1 buttonShopPos" type="submit" value="-">
                                                </form>
                                            </div>';
                                    };
                                };
                            };
                        };
                    };
                };  
            };
        };
    ?>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#apparels_action").click(function(){
                $("#apparels").show();
                $("#accessories").hide();
            });
        });
        $(document).ready(function(){
            $("#accessories_action").click(function(){
                $("#apparels").hide();
                $("#accessories").show();
            });
        });
        $(document).ready(function(){
            $("#ShowAll").click(function(){
                $("#apparels").show();    
                $("#accessories").show();
            });
        });
        $(document).ready(function(){
            $( ".products" ).submit(function(event) {
                var frm = $('#'+event.currentTarget.id);
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    dataType : 'html',
                    success: function (data) {
                        alert('ok'+frm.attr('method'));
                    }
                });
            event.preventDefault();
            });
        });
    </script>
    @endsection
</body>

    @section('footer')
        @parent
    @endsection

</html>