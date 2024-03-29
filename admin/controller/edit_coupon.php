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

$id_coupon = cleardata(getId());

if(!$id_coupon){
	header('Location: home.php');
}

if(check_permission('view_coupons') || check_permission('edit_coupons')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_coupons')){

	$coupon_id = cleardata($_POST['coupon_id']);
	$coupon_title = cleardata($_POST['coupon_title']);
	$coupon_seotitle = cleardata($_POST['coupon_seotitle']);
	$coupon_description = $_POST['coupon_description'];
	$coupon_seodescription = cleardata($_POST['coupon_seodescription']);
	$coupon_tagline = cleardata($_POST['coupon_tagline']);
	$coupon_category = cleardata($_POST['coupon_category']);
	$coupon_subcategory = cleardata($_POST['coupon_subcategory']);
	$coupon_store = cleardata($_POST['coupon_store']);
	$coupon_code = cleardata($_POST['coupon_code']);
	$coupon_status = cleardata($_POST['coupon_status']);
	$coupon_link = cleardata($_POST['coupon_link']);
	$coupon_start = cleardata($_POST['coupon_start']);
	$coupon_expire = cleardata($_POST['coupon_expire']);
	$coupon_exclusive = cleardata($_POST['coupon_exclusive']);
	$coupon_featured = cleardata($_POST['coupon_featured']);
	$coupon_verified = cleardata($_POST['coupon_verified']);
	$coupon_author = cleardata($_POST['coupon_author']);
	$coupon_slug = cleardata($_POST['coupon_slug']);
	
	$required_fields = ['coupon_title', 'coupon_category', 'coupon_link', 'coupon_code'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	$image = [
		'coupon_image' => isset($_FILES['coupon_image']['name']) && !empty($_FILES['coupon_image']['name'])
	];

	$uploadedImages = [];

	foreach(['coupon_image'] as $image_key) {

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

	if(empty($coupon_slug)) {
		$slug = $_POST['coupon_slug_save'];
	}else{

		$converted_slug = convertSlug($_POST['coupon_slug']);
		$exists = get_coupon_slug($converted_slug);

		if ($exists > 0){

			$new_number = $exists + 1;
			$slug = $converted_slug."-".$new_number;

		}else{

			$slug = $converted_slug;
		}
	}

	$statment = connect()->prepare("UPDATE coupons SET
	coupon_id = :coupon_id,
	coupon_title = :coupon_title,
	coupon_seotitle = :coupon_seotitle,
	coupon_slug = :coupon_slug,
	coupon_description = :coupon_description,
	coupon_seodescription = :coupon_seodescription,
	coupon_tagline = :coupon_tagline,
	coupon_category = :coupon_category,
	coupon_subcategory = :coupon_subcategory,
	coupon_store = :coupon_store,
	coupon_code = :coupon_code,
	coupon_status = :coupon_status,
	coupon_link = :coupon_link,
	coupon_start = :coupon_start,
	coupon_expire = :coupon_expire,
	coupon_exclusive = :coupon_exclusive,
	coupon_featured = :coupon_featured,
	coupon_verified = :coupon_verified,
	coupon_image = :coupon_image
	WHERE coupon_id = :coupon_id");

	$statment->execute(array(
		':coupon_id' => $coupon_id,
		':coupon_title' => $coupon_title,
		':coupon_seotitle' => $coupon_seotitle,
		':coupon_slug' => $slug,
		':coupon_description' => $coupon_description,
		':coupon_seodescription' => $coupon_seodescription,
		':coupon_tagline' => $coupon_tagline,
		':coupon_category' => $coupon_category,
		':coupon_subcategory' => $coupon_subcategory,
		':coupon_store' => $coupon_store,
		':coupon_code' => $coupon_code,
		':coupon_status' => $coupon_status,
		':coupon_link' => $coupon_link,
		':coupon_start' => $coupon_start,
		':coupon_expire' => $coupon_expire,
		':coupon_exclusive' => $coupon_exclusive,
		':coupon_featured' => $coupon_featured,
		':coupon_verified' => $coupon_verified,
		':coupon_image' => (isset($uploadedImages['coupon_image']) ? $uploadedImages['coupon_image'] : $_POST['coupon_image_save'])
	));

	$FileUploader = new FileUploader('files', array(
		'uploadDir' => $target_dir,
		'title' => 'auto',
		'limit' => 8,
		'fileMaxSize' => (allowedFileSize()/1024/1024),
		'extensions' => allowedFileExt(),
		'replace' => true
		));
	
	$data = $FileUploader->upload();
	
	if($data['isSuccess'] && count($data['files']) > 0) {
		
		$uploadedFiles = $data['files'];

		$statment = connect()->prepare("INSERT INTO coupons_gallery (id,item,picture,created) VALUES (null,:item,:picture,CURRENT_TIMESTAMP)");
		
		foreach ($uploadedFiles as $key => $value){
			$statment->execute(array(
				':item' => $coupon_id,
				':picture' => $value['name']
			));
		}
	}

	header('Location: ./coupons.php');
	// header('Location: ' . $_SERVER['HTTP_REFERER']);

}
		
}else{

header('Location: ./denied.php');		

}

}

$coupon = get_coupon_per_id($id_coupon);

if(!$coupon){
	header('Location: home.php');
}

$stores = get_all_stores();
$locations = get_all_locations();
$categories = get_all_categories();
$subcategories = get_subcategories_per_parent($coupon['coupon_category']);
$siteSettings = get_settings();
$gallery = get_coupons_gallery($coupon['coupon_id']);

require '../views/edit.coupon.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>