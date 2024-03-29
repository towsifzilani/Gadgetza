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

if(check_permission('create_locations')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$location_title = cleardata($_POST['location_title']);
	$location_seodescription = cleardata($_POST['location_seotitle']);
	$location_description = cleardata($_POST['location_description']);
	$location_seodescription = cleardata($_POST['location_seodescription']);
	$location_featured = cleardata($_POST['location_featured']);

	$required_fields = ['location_title'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	$image = [
		'location_image' => isset($_FILES['location_image']['name']) && !empty($_FILES['location_image']['name'])
	];

	$uploadedImages = [];

	foreach(['location_image'] as $image_key) {

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

	$converted_slug = convertSlug(cleardata($_POST['location_title']));
	$exists = get_location_slug($converted_slug);

	if ($exists > 0){
		$new_number = $exists + 1;
		$slug = $converted_slug."-".$new_number;
	}else{
		$slug = $converted_slug;
	}


	$statment = connect()->prepare("INSERT INTO locations (location_id, location_title, location_seotitle, location_description, location_seodescription, location_featured, location_slug, location_image) VALUES (null, :location_title, :location_seotitle, :location_description, :location_seodescription, :location_featured, :location_slug, :location_image)");

	$statment->execute(array(
		':location_title' => $location_title,
		':location_slug' => $slug,
		':location_seotitle' => $location_seotitle,
		':location_description' => $location_description,
		':location_seodescription' => $location_seodescription,
		':location_featured' => $location_featured,
		':location_image' => $uploadedImages['location_image']
	));

	header('Location: ./locations.php');

}

}

require '../views/new.location.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else {

	header('Location:'.SITE_URL);

}

?>