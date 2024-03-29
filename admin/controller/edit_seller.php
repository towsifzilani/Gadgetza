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

	$id_seller = cleardata(getId());

	if(!$id_seller){
		header('Location: home.php');
	}

	if(check_permission('view_sellers') || check_permission('edit_sellers')){

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

	
	
		if(check_permission('edit_sellers')){

			$seller_id = cleardata($_POST['seller_id']);
			$seller_user = cleardata($_POST['seller_user']);
			$seller_title = cleardata($_POST['seller_title']);
			$seller_description = cleardata($_POST['seller_description']);
		
			$required_fields = ['seller_user', 'seller_title', 'seller_description'];
			foreach($required_fields as $field) {
				if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
						$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
				}
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

			$statment = connect()->prepare("UPDATE sellers SET seller_id = :seller_id, seller_title = :seller_title, seller_user = :seller_user, seller_description = :seller_description, seller_logo = :seller_logo WHERE seller_id = :seller_id");

			$statment->execute(array(
				':seller_id' => $seller_id,
				':seller_title' => $seller_title,
				':seller_user' => $seller_user,
				':seller_description' => $seller_description,
				':seller_logo' => (isset($uploadedImages['seller_logo']) ? $uploadedImages['seller_logo'] : $_POST['seller_logo_save'])
			));

			header('Location: ' . $_SERVER['HTTP_REFERER']);

		}

		}else{
	
			header('Location: ./denied.php');		
	
		}

		}

			$users = get_all_users();
			$seller = get_seller_per_id($id_seller);

			if(!$seller){

				header('Location: ./home.php');
			}

			require '../views/edit.seller.view.php';
		
}else{

	header('Location: ./denied.php');		

	}

}else {
	header('Location:'.SITE_URL);
}

?>