<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_stores')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$store_title = cleardata($_POST['store_title']);
	$store_seodescription = cleardata($_POST['store_seotitle']);
	$store_description = cleardata($_POST['store_description']);
	$store_seodescription = cleardata($_POST['store_seodescription']);
	$store_featured = cleardata($_POST['store_featured']);

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

	$converted_slug = convertSlug(cleardata($_POST['store_title']));
	$exists = get_store_slug($converted_slug);

	if ($exists > 0){

		$new_number = $exists + 1;
		$slug = $converted_slug."-".$new_number;

	}else{

		$slug = $converted_slug;
	}

	$statment = connect()->prepare("INSERT INTO stores (store_id, store_title, store_seotitle, store_description, store_seodescription, store_featured, store_slug, store_image) VALUES (null, :store_title, :store_seotitle, :store_description, :store_seodescription, :store_featured, :store_slug, :store_image)");

	$statment->execute(array(
		':store_title' => $store_title,
		':store_slug' => $slug,
		':store_seotitle' => $store_seotitle,
		':store_description' => $store_description,
		':store_seodescription' => $store_seodescription,
		':store_featured' => $store_featured,
		':store_image' => $uploadedImages['store_image']
	));

	header('Location: ./stores.php');

}

}

require '../views/new.store.view.php';

}else{

header('Location: ./denied.php');
}

}else {

header('Location:'.SITE_URL);

}

?>