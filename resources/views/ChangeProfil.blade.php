<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
    };

    $url_pic_event="http://localhost:3000/api/users/";
    if (isset($url_pic_event)&& isset($_SESSION['decoded'])){
        $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
        $resp = $myClient -> request('PUT',$url_pic_event,['form_params'=> ['id_user' => $_SESSION['decoded']->id_user, 'last_name' => $_POST['last_name']
        , 'profil_pic' => $_POST['profil_pic'], 'first_name' => $_POST['first_name'], 'email' => $_POST['email'], 'password' => hash('ripemd160',$_POST['password'])
        ]], ['verify'=>false]);
        if ($resp -> getStatusCode() == 200){
        }
    }

$target_dir = 'image/';
$target_file = $target_dir ."/". basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
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
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>
