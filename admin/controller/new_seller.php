<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_sellers')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$seller_user = cleardata($_POST['seller_user']);
	$seller_title = cleardata($_POST['seller_title']);
	$seller_description = cleardata($_POST['seller_description']);

	$required_fields = ['seller_user', 'seller_title', 'seller_description'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}

	$statement = connect()->prepare("SELECT * FROM sellers WHERE seller_user = :seller_user LIMIT 1");
	$statement->execute(array(':seller_user' => $seller_user));
	$result = $statement->fetch();

	if ($result != false) {
		
		$errors[] = "<b> User ID ".$result['seller_user']."</b> " . _ERRORALREADYEXIST;  
	
	}
	
	$image = [
		'seller_logo' => isset($_FILES['seller_logo']['name']) && !empty($_FILES['seller_logo']['name'])
	];

	$uploadedImages = [];

	foreach(['seller_logo'] as $image_key) {

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

	$statment = connect()->prepare("INSERT INTO sellers (seller_id, seller_title, seller_user, seller_description, seller_logo) VALUES (null, :seller_title, :seller_user, :seller_description, :seller_logo)");

	$statment->execute(array(
		':seller_title' => $seller_title,
		':seller_user' => $seller_user,
		':seller_description' => $seller_description,
		':seller_logo' => $uploadedImages['seller_logo']
	));

	header('Location: ./sellers.php');
}

}

$users = get_all_users();
require '../views/new.seller.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else {

	header('Location:'.SITE_URL);

}

?>