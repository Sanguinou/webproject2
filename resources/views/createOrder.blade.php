<?php
session_start();

if(isset($_SESSION['timeout'])){
    if ($_SESSION['timeout'] + 5 * 60 < time()) {
        session_unset();
        header("Location:http://127.0.0.1:8000/connection");
        exit();     
    }
};
$url_order="http://localhost:3000/api/orders/";
if (isset($url_order) && isset($_SESSION['panier']) && isset($_POST['order'])){
    if(sizeof($_SESSION['panier']['id_product'])>0){
    $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
    $resp = $myClient -> request('POST',$url_order,['form_params'=> ['id_user' => $_SESSION['decoded']->id_user,'order_price' => $_SESSION['panier']['total']
    ]],['verify'=>false]);
    if ($resp -> getStatusCode() == 200){
        $body = $resp -> getBody();
        $order = json_decode($body);
        $i=0;
        foreach($_SESSION['panier']['id_product'] as $id_product){
            $url_include_order="http://localhost:3000/api/Includes/";
            if (isset($url_include_order)){
                $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                $resp = $myClient -> request('POST',$url_include_order,['form_params'=> ['id_order' => $order[0]->id_order, 
                'id_product'=>$id_product,'quantity' => $_SESSION['panier']['quantity'][$i]
                ]],['verify'=>false]);
            }

        }
            
    }
}
    unset($_SESSION['panier'])
    ;
}
?>
