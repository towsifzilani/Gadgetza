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

if(check_permission('create_users')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$user_name = cleardata($_POST['user_name']);
	$user_email = cleardata($_POST['user_email']);
	$user_verified = cleardata($_POST['user_verified']);
	$user_password = cleardata($_POST['user_password']);
	$encryptPass = hash('sha512', $user_password);
	$user_role = cleardata($_POST['user_role']);
	$user_pro = !empty($_POST['user_pro']) ? cleardata($_POST['user_pro']) : 0;

	$user_billing_name = mb_substr(trim(cleardata($_POST['user_billing_name'])), 0, 128);
	$user_billing_address = mb_substr(trim(cleardata($_POST['user_billing_address'])), 0, 128);
	$user_billing_city = mb_substr(trim(cleardata($_POST['user_billing_city'])), 0, 64);
	$user_billing_zip = mb_substr(trim(cleardata($_POST['user_billing_zip'])), 0, 32);
	$user_billing_country = array_key_exists($_POST['user_billing_country'], $countriesArray) ? cleardata($_POST['user_billing_country']) : 'US';
	$user_billing_company = mb_substr(trim(cleardata($_POST['user_billing_company'])), 0, 128);
	$user_billing_phone = mb_substr(trim(cleardata($_POST['user_billing_phone'])), 0, 32);
	$user_billing_tax_id = mb_substr(trim(cleardata($_POST['user_billing_tax_id'])), 0, 128);

	if(!empty($user_billing_name) && !empty($user_billing_address) && !empty($user_billing_city)
	&& !empty($user_billing_zip) && !empty($user_billing_country)){

		$_POST['user_billing'] = json_encode([
			'name' => $user_billing_name,
			'address' => $user_billing_address,
			'city' => $user_billing_city,
			'zip' => $user_billing_zip,
			'country' => $user_billing_country,
			'company' => $user_billing_company,
			'phone' => $user_billing_phone,
			'tax_id' => $user_billing_tax_id
		]);

	}

	$required_fields = ['user_name', 'user_email', 'user_password', 'user_role'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}

	$statement = connect()->prepare("SELECT * FROM users WHERE user_email = :user_email LIMIT 1");
	$statement->execute(array(':user_email' => $user_email));
	$result = $statement->fetch();

	if ($result != false) {
		
		$errors[] = "<b>".$result['user_email']."</b> " . _ERRORALREADYEXIST;  
	
	}

	if(empty($errors)){

	$statment = connect()->prepare("INSERT INTO users (user_id, user_name, user_email, user_verified, user_password, user_role, user_pro, user_billing, user_created) VALUES (null, :user_name, :user_email, :user_verified, :user_password, :user_role, :user_pro, :user_billing, CURRENT_TIMESTAMP)");

	$statment->execute(array(
		':user_name' => $user_name,
		':user_email' => $user_email,
		':user_verified' => $user_verified,
		':user_password' => $encryptPass,
		':user_role' => $user_role,
		':user_pro' => $user_pro,
		':user_billing' => $_POST['user_billing'] ?? ""
	));

header('Location: ./users.php');
}

}

$roles = get_all_roles();

require '../views/new.user.view.php';

}else{

header('Location: ./denied.php');
}

}else{

header('Location:'.SITE_URL);
}

?>