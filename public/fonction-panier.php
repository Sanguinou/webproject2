<?php

function isVerrouille(){
    if (isset($_SESSION['verrou'])){
        return $_SESSION['verrou'];
    }
}
 
 
 
 function ajouterArticle($id_product,$quantity,$product_price){
 //Si le panier existe
    if (!isVerrouille())
    {
       $positionProduit = array_search($id_product,$_SESSION['panier']['id_product']); 
       if ($positionProduit !== false)
       {
          $_SESSION['panier']['quantity'][$positionProduit] += $quantity;
       }
       else
       {
          //Sinon on ajoute le produit
          array_push( $_SESSION['panier']['id_product'],$id_product);
          array_push( $_SESSION['panier']['quantity'],$quantity);
          array_push( $_SESSION['panier']['product_price'],$product_price);
       }
    };
 };
 

 function suppArticle($id_product,$quantity){
    //Si le panier existe
       if (!isVerrouille())
       {
          $positionProduit = array_search($id_product,$_SESSION['panier']['id_product']); 
          if ($positionProduit !== false)
          {
             $_SESSION['panier']['quantity'][$positionProduit] -= $quantity;

             if($_SESSION['panier']['quantity'][$positionProduit]==0){
                array_splice( $_SESSION['panier']['id_product'],$positionProduit,1);
                array_splice( $_SESSION['panier']['quantity'],$positionProduit,1);
                array_splice( $_SESSION['panier']['product_price'],$positionProduit,1);             }
          }
       };
    };

 
 function modifierQTeArticle($id_product,$quantity){
    //Si le panier éxiste
    if (!isVerrouille()){ 
       //Si la quantité est positive on modifie sinon on supprime l'article
       if ($quantity > 0){
          //Recharche du produit dans le panier
          $positionProduit = array_search($id_product,  $_SESSION['panier']['id_product']);
 
          if ($positionProduit !== false)
          {
             $_SESSION['panier']['quantity'][$positionProduit] =  $quantity;
          }
       }else{
        $positionProduit = array_search($id_product,  $_SESSION['panier']['id_product']);
        array_splice( $_SESSION['panier']['id_product'],$positionProduit,1);
        array_splice( $_SESSION['panier']['quantity'],$positionProduit,1);
        array_splice( $_SESSION['panier']['product_price'],$positionProduit,1);   
       }
    }else{
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
    }
 }
 
 
 
 function MontantGlobal(){
    if (isset($_SESSION['panier']['id_product'])){
        $total=0;
        for($i = 0; $i < count($_SESSION['panier']['id_product']); $i++){
            $total += $_SESSION['panier']['quantity'][$i] * $_SESSION['panier']['product_price'][$i];
        }
        $_SESSION['panier']['total']=$total;
        return $total;
    }
}
 
 
 function supprimePanier(){
    unset($_SESSION['panier']);
 }
 
 
 function compterArticles()
 {
    if (isset($_SESSION['panier']))
    return count($_SESSION['panier']['id_product']);
    else
    return 0;
 
 }
 
?>