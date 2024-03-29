<?php 

require '../core.php';

$validateName = false;
$validatePassword = false;
$validateAvatar = false;

if (!isLogged()){

    exit();

}else{

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Get Values 
    $user_id = clearGetData($_POST['user_id']);
    $user_name = clearGetData($_POST['user_name']);
    $user_description = clearGetData($_POST['user_description']);
    $password_save = clearGetData($_POST['user_password_save']);
    $password = clearGetData($_POST['user_password']);
    $confirm_password = clearGetData($_POST['user_confirm_password']);
    $user_avatar = $_FILES["user_avatar"]["name"];
    $user_avatar_save = clearGetData($_POST['user_avatar_save']);

    if (empty($user_name)) {
        echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_159']."</div>";
    }elseif(!lengthInput($user_name, 3, 64)){
        echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_162']."</div>";
    }elseif (validateInput($user_name)) {
        echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_171']."</div>";
    }else{
        $validateName = true;
    }

    if (!empty($password) && !empty($confirm_password)) {

        if (empty($password) || empty($confirm_password)) {
            echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_160']."</div>";
        }elseif(!lengthInput($password, 8, 32) || !lengthInput($confirm_password, 8, 32)){
            echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_164']."</div>";
        }elseif($password != $confirm_password){
            echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_176']."</div>";
        }else{
            $validatePassword = true;
        }

    }else{
            $validatePassword = true;
    }

        if (!empty($user_avatar)) {

            // File path config 
            $fileName = explode(".", $user_avatar);
            $renamefile = round(microtime(true)) . '.' . end($fileName);
            $targetFilePath = '../images/' . $renamefile;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $maxsize = 1048576; 
            $fileInfo = getimagesize($_FILES["user_avatar"]["tmp_name"]);
            $width = $fileInfo[0];
            $height = $fileInfo[1];
             
            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'jpeg'); 
            if(!in_array($fileType, $allowTypes)){ 

            $validateAvatar = false;
            echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_192']."</div>";
            }else{
            $validateAvatar = true;
            }
            
            if(($_FILES['user_avatar']['size'] >= $maxsize) || ($_FILES["user_avatar"]["size"] == 0)) {

            $validateAvatar = false;
            echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_193']."</div>";

            }else{
            $validateAvatar = true;
            }

            if($width > "900") {
            $validateAvatar = false;
            echo "<br><div class='tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_194']."</div>";
            }else{
            $validateAvatar = true;
            }

        }else{

            $validateAvatar = true;

        }

if ($validateName && $validatePassword && $validateAvatar) {

    if (empty($password)) {
        $password = $password_save;
    } else{
        $password = hash('sha512', $password);
    }

    if (empty($user_avatar)) {
        $avatar = $user_avatar_save;
    } else{
        move_uploaded_file($_FILES["user_avatar"]["tmp_name"], $targetFilePath);
        $avatar = $renamefile;
    }

    $statment = $connect->prepare("UPDATE users SET user_name = :user_name, user_description = :user_description, user_password = :user_password, user_avatar = :user_avatar WHERE user_id = :user_id");

    $statment->execute(array(
        ':user_id' => $user_id,
        ':user_name' => $user_name,
        ':user_description' => $user_description,
        ':user_password' => $password,
        ':user_avatar' => $avatar
    ));

    echo "<br><div class='tas-notify tas-notify-success uk-text-small uk-border-rounded uk-margin-remove uk-padding-small'>".$translation['tr_190']."</div>";

}

}else{

    exit();
}

}



?>