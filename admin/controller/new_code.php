<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_codes')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$code_title = cleardata($_POST['code_title']);
	$code_coupon = cleardata($_POST['code_coupon']);
	$code_discount = cleardata($_POST['code_discount']);
	$code_quantity = cleardata($_POST['code_quantity']);
	$code_status = cleardata($_POST['code_status']);

	$required_fields = ['code_title', 'code_coupon', 'code_discount'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}

	$statement = connect()->prepare("SELECT * FROM codes WHERE code_coupon = :code_coupon LIMIT 1");
	$statement->execute(array(':code_coupon' => $code_coupon));
	$result = $statement->fetch();

	if ($result != false) {
		
		$errors[] = "<b>".$result['code_coupon']."</b> " . _ERRORALREADYEXIST;  
	
	}

	if(empty($errors)){

	$statment = connect()->prepare("INSERT INTO codes (code_id, code_title, code_coupon, code_discount, code_quantity, code_status) VALUES (null, :code_title, :code_coupon, :code_discount, :code_quantity, :code_status)");

	$statment->execute(array(
		':code_title' => $code_title,
		':code_coupon' => $code_coupon,
		':code_discount' => $code_discount,
		':code_quantity' => $code_quantity,
		':code_status' => $code_status
	));

	header('Location: ./codes.php');

}

}

require '../views/new.code.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else {

	header('Location:'.SITE_URL);

}

?>