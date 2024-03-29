<?php

require '../core.php';
require './functions.php';

if (!isLogged()){
    header('Location: ./login.php');
    exit();
}

if(!isSeller()){
    header('Location: ./denied.php');
    exit();
}

$validations = array();
$errors = array();
$success = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // getting the data form
    
    $user_id = clearGetData($_POST['user_id']);
    $seller_id = clearGetData($_POST['seller_id']);
    $seller_user = clearGetData($_POST['seller_user']);
    $seller_title = clearGetData($_POST['seller_title']);
    $seller_slug = clearGetData($_POST['seller_slug']);
    $seller_description = clearGetData($_POST['seller_description']);
    $seller_website = clearGetData($_POST['seller_website']);

    if(empty($seller_slug)){

        $converted_slug = convertSlug(clearGetData($_POST['seller_title']));
        $exists = getSellerSlug($converted_slug);
    
        if ($exists > 0){
            $new_number = $exists + 1;
            $slug = $converted_slug."-".$new_number;
        }else{
            $slug = $converted_slug;
        }

    }

    // checking the expiration date of the user's subscription
    
    if (isExpiredSubscription()){

        $validations[] = $translation['tr_247'];

    }else{

    
    if(empty($seller_title) || empty($seller_description)){

        $validations[] = $translation['tr_302'];
    }

    if(strlen($seller_title) > 100){

        $validations[] = $translation['tr_310'];
    }

    if(strlen($seller_description) > 350){

        $validations[] = $translation['tr_375'];
    }

    $image = [
        'seller_logo' => isset($_FILES['seller_logo']['name']) && !empty($_FILES['seller_logo']['name']),
    ];

    $uploadedImages = [];

    foreach(['seller_logo'] as $image_key) {

        if($image[$image_key]) {

            $file_name = $_FILES[$image_key]['name'];
            $file_size = $_FILES[$image_key]['size'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_temp = $_FILES[$image_key]['tmp_name'];
            $file_info = getimagesize($file_temp);
            $width = $file_info[0];
            $height = $file_info[1];

            if(!in_array($file_extension, allowedFileExt())) {

                $validations[] = $translation['tr_192'];
    
            }else if ($file_size > allowedFileSize()) {
    
                $validations[] = $translation['tr_193'];

            }else if($width > "1024" || $height > "650") {

                $validations[] = $translation['tr_194'];
                
            }

            if(empty($validations)){

                $image_new_name = md5(time() . rand()) . '.' . $file_extension;
                move_uploaded_file($file_temp, $target_dir . $image_new_name);
                $uploadedImages += [$image_key => $image_new_name];

            }

        }

    }

    if(empty($validations)){

        $sellerStore = getSellerById($user_id);

        if(!$sellerStore){

            $statment = $connect->prepare("INSERT INTO sellers 
            (seller_id,
            seller_title,
            seller_slug,
            seller_description,
            seller_website,
            seller_logo,
            seller_created,
            seller_user) VALUES (
            null,
            :seller_title,
            :seller_slug,
            :seller_description,
            :seller_website,
            :seller_logo,
            :seller_created,
            :seller_user
            )");

            $statment->execute(array(
                ':seller_title' => $seller_title,
                ':seller_slug' => (isset($slug) ? $slug : $seller_slug),
                ':seller_description' => $seller_description,
                ':seller_website' => $seller_website,
                ':seller_logo' => (isset($uploadedImages['seller_logo']) ? $uploadedImages['seller_logo'] : $_POST['seller_logo_save']),
                ':seller_created' => getDateByTimeZone(),
                ':seller_user' => $user_id
            ));

        }else{

            $statment = $connect->prepare("UPDATE sellers SET
            seller_title = :seller_title,
            seller_slug = :seller_slug,
            seller_description = :seller_description,
            seller_website = :seller_website,
            seller_logo = :seller_logo,
            seller_updated = :seller_updated
            WHERE seller_id = :seller_id AND seller_user = :seller_user");

            $statment->execute(array(
                ':seller_id' => $seller_id,
                ':seller_user' => $seller_user,
                ':seller_title' => $seller_title,
                ':seller_slug' => (isset($slug) ? $slug : $seller_slug),
                ':seller_description' => $seller_description,
                ':seller_website' => $seller_website,
                ':seller_updated' => getDateByTimeZone(),
                ':seller_logo' => (isset($uploadedImages['seller_logo']) ? $uploadedImages['seller_logo'] : $_POST['seller_logo_save']),
            ));

        }

        $success[] = $translation['tr_373'];

    }

}

echo json_encode(array('validations' => $validations, 'errors' => $errors, 'success' => $success));

    }

?>