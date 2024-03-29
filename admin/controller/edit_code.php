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

	$id_code = cleardata(getId());

	if(!$id_code){
		header('Location: home.php');
	}

	if(check_permission('view_codes') || check_permission('edit_codes')){

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

	
	
		if(check_permission('edit_codes')){

			$code_id = cleardata($_POST['code_id']);
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

		if(empty($errors)){

			$statment = connect()->prepare("UPDATE codes SET code_id = :code_id, code_title = :code_title, code_coupon = :code_coupon, code_discount = :code_discount, code_quantity = :code_quantity, code_status = :code_status WHERE code_id = :code_id");

			$statment->execute(array(
				':code_id' => $code_id,
				':code_title' => $code_title,
				':code_coupon' => $code_coupon,
				':code_discount' => $code_discount,
				':code_quantity' => $code_quantity,
				':code_status' => $code_status
			));

			header('Location: ' . $_SERVER['HTTP_REFERER']);

		}


		}else{
	
			header('Location: ./denied.php');		
	
		}
		
		}
			$code = get_code_per_id($id_code);

			if (!$code){

				header('Location: ./home.php');
			}

			require '../views/edit.code.view.php';
		
}else{

	header('Location: ./denied.php');		

	}

}else {

	header('Location:'.SITE_URL);
}

?>