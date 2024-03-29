<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

$errors = array();

if(check_session() == true){

$id_user = cleardata(getId());

if(!$id_user){
	header('Location: home.php');
}

if(check_permission('view_users') || check_permission('edit_users')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(check_permission('edit_users')){

	$user_id = cleardata($_POST['user_id']);
	$user_name = cleardata($_POST['user_name']);
	$user_email = cleardata($_POST['user_email']);
	$user_description = cleardata($_POST['user_description']);
	$user_role = cleardata($_POST['user_role']);
	$user_verified = cleardata($_POST['user_verified']);
	$user_status = cleardata($_POST['user_status']);
	$user_pro = cleardata($_POST['user_pro']);
	$password = $_POST['user_password'];
	$password_save = $_POST['user_password_save'];

	if(empty($password)) {
		$password = $password_save;
	}else{
		$password = hash('sha512', $password);
	}

	$user_billing_name = cleardata($_POST['user_billing_name']);
	$user_billing_address = cleardata($_POST['user_billing_address']);
	$user_billing_city = cleardata($_POST['user_billing_city']);
	$user_billing_zip = cleardata($_POST['user_billing_zip']);
	$user_billing_country = cleardata($_POST['user_billing_country']);
	$user_billing_company = cleardata($_POST['user_billing_company']);
	$user_billing_phone = cleardata($_POST['user_billing_phone']);
	$user_billing_tax_id = cleardata($_POST['user_billing_tax_id']);
	
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

	$required_fields = ['user_name', 'user_email', 'user_role'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
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

			if (!in_array($file_extension, allowedFileExt())) {

				$errors[] = "<b>".$image_key."</b> " . _ERRORALLOWEDFILEFORMATS;  
	
			} else if ($file_size > allowedFileSize()) {
	
				$errors[] = "<b>".$image_key."</b> " . _ERRORFILETOOLARGE;  
	
			}

			if(empty($errors)){

				$image_new_name = md5(time() . rand()) . '.' . $file_extension;
				move_uploaded_file($file_temp, $target_dir . $image_new_name);
				$uploadedImages += [$image_key => $image_new_name];

			}

		}

	}

	if(empty($errors)){

	$statment = connect()->prepare("UPDATE users SET user_id = :user_id, user_name = :user_name, user_email = :user_email, user_description = :user_description, user_role = :user_role, user_verified = :user_verified, user_status = :user_status, user_pro = :user_pro, user_password = :user_password, user_billing = :user_billing WHERE user_id = :user_id");

	$statment->execute(array(
		':user_id' => $user_id,
		':user_name' => $user_name,
		':user_email' => $user_email,
		':user_description' => $user_description,
		':user_role' => $user_role,
		':user_verified' => $user_verified,
		':user_status' => $user_status,
		':user_pro' => $user_pro,
		':user_password' => $password,
		':user_billing' => (!empty($_POST['user_billing']) ? $_POST['user_billing'] : "[]"),
		':user_avatar' => (isset($uploadedImages['user_avatar']) ? $uploadedImages['user_avatar'] : $_POST['user_avatar_save'])
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}

}else{

	header('Location: ./denied.php');		

}

}

	$usr = get_user_per_id($id_user);

	if(!$usr){
		header('Location: ./home.php');
	}

	$usrBilling = json_decode($usr['user_billing']);

	$roles = get_all_roles();

	require '../views/edit.user.view.php';
		
}else{

	header('Location: ./denied.php');		
}

}else{
	header('Location:'.SITE_URL);
}


?>