@extends('layout')

<?php
session_start();
include_once("./fonction-panier.php");
if(isVerrouille()){
    header("Location:http://127.0.0.1:8000/connection");
    exit;
}
$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh'))){
   $erreur=true;
   }
   else{
   //récuperation des variables en POST ou GET
   $id_product = (isset($_POST['id_product'])? $_POST['id_product']:  (isset($_GET['id_product'])? $_GET['id_product']:null )) ;
   $product_price = (isset($_POST['product_price'])? $_POST['product_price']:  (isset($_GET['product_price'])? $_GET['product_price']:null )) ;
   $quantity = (isset($_POST['quantity'])? $_POST['quantity']:  (isset($_GET['quantity'])? $_GET['quantity']:null )) ;


   //On traite $quantity qui peut etre un entier simple ou un tableau d'entier
    
   if (is_array($quantity)){
      $QteArticle = array();
      $i=0;
      foreach ($quantity as $contenu){
         $QteArticle[$i++] = intval($contenu);
      }
   }
   else
   $quantity = intval($quantity);
    }
}


if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($id_product,$quantity,$product_price);
         break;

      Case "suppression":
         suppArticle($id_product,$quantity);
         break;

      Case "refresh" :
         modifierQTeArticle($id_product,$quantity);
         break;

      Default:
         break;
   }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site BDE - Panier</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/cart.css') }}"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>

</head>
    @section('navbar')
        @parent
    @endsection
<body>

    @section('content')
    <h2>panier</h2>
        <table id="panier">
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>quantité</th>
                <th>Total</th>
            </tr>
    <?php
        if (isset($_SESSION['panier']) && isset($_SESSION['panier']['id_product'])){
            $i=0;
            foreach($_SESSION['panier']['id_product'] as $id_product){
                $url_product="http://localhost:3000/api/products/".$id_product;
                if (isset($url_product)){
                    $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                    $resp = $myClient -> request('GET',$url_product,['verify'=>false]);
                    if ($resp -> getStatusCode() == 200){
                        $body = $resp -> getBody();
                        $product = json_decode($body);
                        echo '
                        <form class="products" id="change'.$id_product.'" method="post" action="panier">                                      
                            <input type="hidden" name="action" value="refresh">
                            <input type="hidden" name="id_product" value="'.$id_product.'">
                            <input type="hidden" name="product_price" value="'.$product[0]->product_price.'">
                            <tr>
                                <td>
                                    <p>'.$product[0]->product_name.'</p>
                                </td>
                                <td>
                                    <p>'.$product[0]->product_price.'</p>
                                </td>
                                <td>
                                    <input type="text" placeholder="'.$_SESSION["panier"]["quantity"][$i].'" id="quantity" name="quantity"/> 
                                </td>
                                <td>
                                <p>'.$product[0]->product_price*$_SESSION["panier"]["quantity"][$i].'</p>
                                </td>    
                            </tr>
                        </form>';
                            
                            $i++;
                    }
                }
            }
        }
 ?>

        </table>
        <div id="total_payement">
            <?php echo '<p>total : '.MontantGlobal().' €</p>';?>
            <form id="ok" method="post" action="http://127.0.0.1:8000/Buy/">
                <input type="hidden" name="order">
                <input id="payer" type="submit" name="payer" value="Payement">
            </form>
        </div>
      
        </form>  
        </table>
<script>
        $(document).ready(function(){
            $(".refresh").on('keydown', function(event) {
                if(event.which == 13){
                    $('#'+event.currentTarget.id).parent().submit();
                };
            });
        });


$(document).ready(function(){
            $(document).on('submit','#ok',function(event) {
                var frm = $('#'+event.currentTarget.id);
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    dataType : 'html',
                    success: function (data) {
                    }                
                    });                    
                event.preventDefault();
                location.reload(true);

            });
});

</script>
 @endsection
</body>

    @section('footer')
        @parent
    @endsection
</html>

