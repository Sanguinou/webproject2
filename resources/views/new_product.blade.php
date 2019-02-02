@extends('layout')

<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
    };
if(isset($_POST['product_name']) && isset($_SESSION['decoded'])){
$target_dir = 'image/';
$target_file = $target_dir."/".basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["product_name"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $url_product="http://localhost:3000/api/products/";
        if (isset($url_product)&& isset($_SESSION['decoded'])){
            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
            $resp = $myClient -> request('POST',$url_product,['form_params'=> ['product_name' => $_POST['product_name']
            ,'product_desc' => $_POST['product_desc'], 'product_price' => $_POST['product_price'], 'stock' => $_POST['stock'], 'id_category' => $_POST['id_category']
            ]], ['verify'=>false]);
            if ($resp -> getStatusCode() == 200){
                $body = $resp -> getBody();
                $product = json_decode($body,true);
                    $url_pictures_product="http://localhost:3000/api/pictures_product/";
                    if (isset($url_pictures_product)){
                        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
                        $resp = $myClient -> request('POST',$url_pictures_product,['form_params'=> ['id_product' => $product[0]['id_product'], 
                        'picture_product_name' => $_POST['picture_product_name']
                        ]],['verify'=>false]);
                    }

            }
        }
    } else {
        header("Location:http://127.0.0.1:8000/shop/");
        exit;    }
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Product</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/new_product.css') }}"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="keywords" content="Site Web, BDE du CESI, Campus CESI, Arras, Projetweb"/>

</head>
@section('navbar')
        @parent
@endsection
<body>
@section('content')

    <div>
        <h2>Nouveau Produit :</h2>
        <div id="new_product">
            <form id="FormAddProduct"method="POST" action="" enctype="multipart/form-data">
                <input type="text" class="nom" placeholder="Nom du produit" name="product_name">
                <div id="prix_stock">
                    <input type="text" class="prix" placeholder="Prix unitaire" name="product_price">
                    <input type="text" class="stock" placeholder="Quantité stock" name="stock">
                </div>
                <textarea type="text" class="description" placeholder="Description du produit" name="product_desc"></textarea>
                <select class="input" name="id_category">
                        <option value="1">Vêtement</option>
                        <option value="2">Accessoire</option>
                </select>
                <div id="url_img">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="hidden" id="picture_product_name" name="picture_product_name" value="" />
                </div> 
                    <input type="submit" class="add_product" name="add_product" value="Ajouter un produit"/>
            </form>
        </div>
    </div>

<script>

$(document).ready(function(){
            $(document).on('submit','#FormAddProduct',function(event) {
                var frm = $('#'+event.currentTarget.id);
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: frm.serialize(),
                    dataType : 'html',
                    success: function (data) {
                    }                
                    });                    
            });
});

    $(document).ready(function(){
    $("#fileToUpload").change(function(){
            var fileName = $("#fileToUpload").val();
            $("#picture_product_name").val(fileName.split('\\').pop());
            alert( $("#picture_product_name").val());

    });
 });
 </script>
    @endsection

</body>
@section('footer')
        @parent
    @endsection
</html>