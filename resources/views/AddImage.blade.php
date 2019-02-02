<?php
    session_start();
    if(isset($_SESSION['timeout'])){
        if ($_SESSION['timeout'] + 5 * 60 < time()) {
            session_unset();
            header("Location:http://127.0.0.1:8000/connection");
            exit();     
        }
        else if(!isset($_SESSION['timeout'])){
            header("Location:http://127.0.0.1:8000/connection");
            exit();  
        }
    };

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
        
        $url_pic_event="http://localhost:3000/api/pictures_event/";
        if (isset($url_pic_event)&& isset($_SESSION['decoded'])){
            $myClient = new GuzzleHttp\Client(['headers'=> ['User-Agent' => 'MyReader']]);
            $resp = $myClient -> request('POST',$url_pic_event,['form_params'=> ['id_event' => $_POST['id_event'],'id_user' => $_POST['id_user']
            , 'picture_event_body' => $_POST['picture_event_body'], 'picture_event_body' => $_POST['picture_event_body'], 'picture_event_name' => $_POST['picture_event_name']
            ]], ['verify'=>false]);
        header("Location:http://127.0.0.1:8000/event/".$_POST['id_event']);
        exit;
        }
    } else {
        header("Location:http://127.0.0.1:8000/event/".$_POST['id_event']);
        exit;    }
}

?>
