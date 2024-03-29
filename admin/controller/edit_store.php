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

$id_store = cleardata(getId());

if(!$id_store){
	header('Location: home.php');
}

if(check_permission('view_stores') || check_permission('edit_stores')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_stores')){

	$store_id = cleardata($_POST['store_id']);
	$store_title = cleardata($_POST['store_title']);
	$store_seotitle = cleardata($_POST['store_seotitle']);
	$store_description = cleardata($_POST['store_description']);
	$store_seodescription = cleardata($_POST['store_seodescription']);
	$store_featured = cleardata($_POST['store_featured']);
	$store_status = cleardata($_POST['store_status']);
	$store_slug = cleardata($_POST['store_slug']);

	$required_fields = ['store_title'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	$image = [
		'store_image' => isset($_FILES['store_image']['name']) && !empty($_FILES['store_image']['name'])
	];

	$uploadedImages = [];

	foreach(['store_image'] as $image_key) {

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

		if (empty($store_slug)) {
			$slug = $_POST['store_slug_save'];
		}else{
	
			$converted_slug = convertSlug($_POST['store_slug']);
			$exists = get_store_slug($converted_slug);
	
			if ($exists > 0){
	
				$new_number = $exists + 1;
				$slug = $converted_slug."-".$new_number;
	
			}else{
	
				$slug = $converted_slug;
			}
		}

	$statment = connect()->prepare("UPDATE stores SET store_id = :store_id, store_title = :store_title, store_slug = :store_slug, store_description = :store_description, store_seotitle = :store_seotitle, store_seodescription = :store_seodescription, store_featured = :store_featured, store_status = :store_status, store_image = :store_image WHERE store_id = :store_id");

	$statment->execute(array(
		':store_id' => $store_id,
		':store_title' => $store_title,
		':store_slug' => $slug,
		':store_description' => $store_description,
		':store_seotitle' => $store_seotitle,
		':store_seodescription' => $store_seodescription,
		':store_featured' => $store_featured,
		':store_status' => $store_status,
		':store_image' => (isset($uploadedImages['store_image']) ? $uploadedImages['store_image'] : $_POST['store_image_save'])
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}


}else{

	header('Location: ./denied.php');		

}

}

	$store = get_store_per_id($id_store);
	
	if(!$store){
		header('Location: ./home.php');
	}
	
	require '../views/edit.store.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>