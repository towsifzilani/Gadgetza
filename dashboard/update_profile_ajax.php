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
	$user_name = clearGetData($_POST['user_name']);
	$user_description = clearGetData($_POST['user_description']);
	$password = $_POST['user_password'];
	$password_save = $_POST['user_password_save'];

	if(empty($password)) {
		$password = $password_save;
	}else{
		$password = hash('sha512', $password);
	}
    
	$user_billing_name = clearGetData($_POST['user_billing_name']);
	$user_billing_address = clearGetData($_POST['user_billing_address']);
	$user_billing_city = clearGetData($_POST['user_billing_city']);
	$user_billing_zip = clearGetData($_POST['user_billing_zip']);
	$user_billing_country = clearGetData($_POST['user_billing_country']);
	$user_billing_company = clearGetData($_POST['user_billing_company']);
	$user_billing_phone = clearGetData($_POST['user_billing_phone']);
	$user_billing_tax_id = clearGetData($_POST['user_billing_tax_id']);
	
	$_POST['user_billing'] = json_encode([
		'user_billing_name' => $user_billing_name,
		'user_billing_address' => $user_billing_address,
		'user_billing_city' => $user_billing_city,
		'user_billing_zip' => $user_billing_zip,
		'user_billing_country' => $user_billing_country,
		'user_billing_company' => $user_billing_company,
		'user_billing_phone' => $user_billing_phone,
		'user_billing_tax_id' => $user_billing_tax_id
	]);

    // checking the expiration date of the user's subscription
    
    if (isExpiredSubscription()){

        $validations[] = $translation['tr_247'];

    }else{

    
    if(empty($user_id) || empty($user_name) || empty($user_billing_name) || empty($user_billing_address) || empty($user_billing_city)
    || empty($user_billing_zip) || empty($user_billing_country)){

        $validations[] = $translation['tr_302'];
    }

    if(strlen($user_name) > 100){

        $validations[] = $translation['tr_431'];
    }

    if(strlen($user_description) > 255){

        $validations[] = $translation['tr_432'];
    }

    $image = [
        'user_avatar' => isset($_FILES['user_avatar']['name']) && !empty($_FILES['user_avatar']['name'])
    ];

    $uploadedImages = [];

    foreach(['user_avatar'] as $image_key) {

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

        $statment = $connect->prepare("UPDATE users SET
        user_name = :user_name,
        user_description = :user_description,
        user_password = :user_password,
        user_billing = :user_billing,
        user_avatar = :user_avatar WHERE user_id = :user_id");

        $statment->execute(array(
            ':user_id' => $user_id,
            ':user_name' => $user_name,
            ':user_description' => $user_description,
            ':user_password' => $password,
            ':user_billing' => (!empty($_POST['user_billing']) ? $_POST['user_billing'] : "[]"),
            ':user_avatar' => (isset($uploadedImages['user_avatar']) ? $uploadedImages['user_avatar'] : $_POST['user_avatar_save'])
        ));

        $success[] = $translation['tr_373'];

    }

}

echo json_encode(array('validations' => $validations, 'errors' => $errors, 'success' => $success));

    }

?>