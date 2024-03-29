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

if(check_permission('create_sliders')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$slider_link = cleardata($_POST['slider_link']);
	$slider_status = cleardata($_POST['slider_status']);

	$required_fields = ['slider_link'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
			$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	$image = [
		'slider_image' => isset($_FILES['slider_image']['name']) && !empty($_FILES['slider_image']['name'])
	];

	$uploadedImages = [];

	foreach(['slider_image'] as $image_key) {

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

	$statment = connect()->prepare("INSERT INTO sliders (slider_id, slider_link, slider_status, slider_image) VALUES (null, :slider_link, :slider_status, :slider_image)");

	$statment->execute(array(
		':slider_link' => $slider_link,
		':slider_status' => $slider_status,
		':slider_image' => $uploadedImages['slider_image']
	));

	header('Location: ./sliders.php');

}

}

require '../views/new.slider.view.php';

}else{

header('Location: ./denied.php');
}

}else {

header('Location:'.SITE_URL);

}

?>