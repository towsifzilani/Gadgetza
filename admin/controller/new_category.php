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

if(check_permission('create_categories')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$category_title = cleardata($_POST['category_title']);
	$category_seotitle = cleardata($_POST['category_seotitle']);
	$category_description = cleardata($_POST['category_description']);
	$category_seodescription = cleardata($_POST['category_seodescription']);
	$category_featured = cleardata($_POST['category_featured']);
	$category_icon = cleardata($_POST['category_icon']);
	$category_menu = cleardata($_POST['category_menu']);

	$required_fields = ['category_title'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	$image = [
		'category_image' => isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])
	];

	$uploadedImages = [];

	foreach(['category_image'] as $image_key) {

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

	$converted_slug = convertSlug(cleardata($_POST['category_title']));
	$exists = get_category_slug($converted_slug);

	if ($exists > 0){
		$new_number = $exists + 1;
		$slug = $converted_slug."-".$new_number;
	}else{
		$slug = $converted_slug;
	}

	$statment = connect()->prepare("INSERT INTO categories (category_id, category_title, category_seotitle, category_description, category_seodescription, category_featured, category_icon, category_menu, category_slug, category_image) VALUES (null, :category_title, :category_seotitle, :category_description, :category_seodescription, :category_featured, :category_icon, :category_menu, :category_slug, :category_image)");

	$statment->execute(array(
		':category_title' => $category_title,
		':category_slug' => $slug,
		':category_seotitle' => $category_seotitle,
		':category_description' => $category_description,
		':category_seodescription' => $category_seodescription,
		':category_featured' => $category_featured,
		':category_icon' => $category_icon,
		':category_menu' => $category_menu,
		':category_image' => $uploadedImages['category_image']
	));

	header('Location: ./categories.php');

}

}

require '../views/new.category.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else {

	header('Location:'.SITE_URL);

}

?>