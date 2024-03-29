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

$id_slider = cleardata(getId());

if(!$id_slider){
	header('Location: home.php');
}

if(check_permission('view_sliders') || check_permission('edit_sliders')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_sliders')){

	$slider_id = cleardata($_POST['slider_id']);
	$slider_status = cleardata($_POST['slider_status']);
	$slider_link = cleardata($_POST['slider_link']);

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

	$statment = connect()->prepare("UPDATE sliders SET slider_id = :slider_id, slider_status = :slider_status, slider_link = :slider_link, slider_image = :slider_image WHERE slider_id = :slider_id");

	$statment->execute(array(
		':slider_id' => $slider_id,
		':slider_status' => $slider_status,
		':slider_link' => $slider_link,
		':slider_image' => (isset($uploadedImages['slider_image']) ? $uploadedImages['slider_image'] : $_POST['slider_image_save'])
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}

}else{

	header('Location: ./denied.php');		

}

}

	$slider = get_slider_per_id($id_slider);
	
	if(!$slider){
		header('Location: ./home.php');
	}
	
	require '../views/edit.slider.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>