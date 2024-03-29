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

$id_deal = cleardata(getId());

if(!$id_deal){
	header('Location: home.php');
}

if(check_permission('view_deals') || check_permission('edit_deals')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_deals')){

	$deal_id = cleardata($_POST['deal_id']);
	$deal_title = cleardata($_POST['deal_title']);
	$deal_seotitle = cleardata($_POST['deal_seotitle']);
	$deal_description = $_POST['deal_description'];
	$deal_seodescription = cleardata($_POST['deal_seodescription']);
	$deal_tagline = cleardata($_POST['deal_tagline']);
	$deal_category = cleardata($_POST['deal_category']);
	$deal_subcategory = cleardata($_POST['deal_subcategory']);
	$deal_store = cleardata($_POST['deal_store']);
	$deal_location = cleardata($_POST['deal_location']);
	$deal_status = cleardata($_POST['deal_status']);
	$deal_price = cleardata($_POST['deal_price']);
	$deal_oldprice = cleardata($_POST['deal_oldprice']);
	$deal_link = cleardata($_POST['deal_link']);
	$deal_video = cleardata($_POST['deal_video']);
	$deal_gif = cleardata($_POST['deal_gif']);
	$deal_start = cleardata($_POST['deal_start']);
	$deal_expire = cleardata($_POST['deal_expire']);
	$deal_exclusive = cleardata($_POST['deal_exclusive']);
	$deal_featured = cleardata($_POST['deal_featured']);
	$deal_author = cleardata($_POST['deal_author']);
	$deal_slug = cleardata($_POST['deal_slug']);
	
	$required_fields = ['deal_title', 'deal_category', 'deal_link', 'deal_price'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	$image = [
		'deal_image' => isset($_FILES['deal_image']['name']) && !empty($_FILES['deal_image']['name'])
	];

	$uploadedImages = [];

	foreach(['deal_image'] as $image_key) {

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

	if(empty($deal_slug)) {
		$slug = $_POST['deal_slug_save'];
	}else{

		$converted_slug = convertSlug($_POST['deal_slug']);
		$exists = get_deal_slug($converted_slug);

		if ($exists > 0){

			$new_number = $exists + 1;
			$slug = $converted_slug."-".$new_number;

		}else{

			$slug = $converted_slug;
		}
	}

	$statment = connect()->prepare("UPDATE deals SET
	deal_id = :deal_id,
	deal_title = :deal_title,
	deal_seotitle = :deal_seotitle,
	deal_slug = :deal_slug,
	deal_description = :deal_description,
	deal_seodescription = :deal_seodescription,
	deal_tagline = :deal_tagline,
	deal_category = :deal_category,
	deal_subcategory = :deal_subcategory,
	deal_store = :deal_store,
	deal_location = :deal_location,
	deal_status = :deal_status,
	deal_price = :deal_price,
	deal_oldprice = :deal_oldprice,
	deal_link = :deal_link,
	deal_video = :deal_video,
	deal_gif = :deal_gif,
	deal_start = :deal_start,
	deal_expire = :deal_expire,
	deal_exclusive = :deal_exclusive,
	deal_featured = :deal_featured,
	deal_image = :deal_image
	WHERE deal_id = :deal_id");

	$statment->execute(array(
		':deal_id' => $deal_id,
		':deal_title' => $deal_title,
		':deal_seotitle' => $deal_seotitle,
		':deal_slug' => $slug,
		':deal_description' => $deal_description,
		':deal_seodescription' => $deal_seodescription,
		':deal_tagline' => $deal_tagline,
		':deal_category' => $deal_category,
		':deal_subcategory' => $deal_subcategory,
		':deal_store' => $deal_store,
		':deal_location' => $deal_location,
		':deal_status' => $deal_status,
		':deal_price' => $deal_price,
		':deal_oldprice' => $deal_oldprice,
		':deal_link' => $deal_link,
		':deal_video' => $deal_video,
		':deal_gif' => $deal_gif,
		':deal_start' => $deal_start,
		':deal_expire' => $deal_expire,
		':deal_exclusive' => $deal_exclusive,
		':deal_featured' => $deal_featured,
		':deal_image' => (isset($uploadedImages['deal_image']) ? $uploadedImages['deal_image'] : $_POST['deal_image_save'])
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

		$statment = connect()->prepare("INSERT INTO deals_gallery (id,item,picture,created) VALUES (null,:item,:picture,CURRENT_TIMESTAMP)");
		
		foreach ($uploadedFiles as $key => $value){
			$statment->execute(array(
				':item' => $deal_id,
				':picture' => $value['name']
			));
		}
	}

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}
		
}else{

header('Location: ./denied.php');		

}

}

$deal = get_deal_per_id($id_deal);

if(!$deal){
	header('Location: home.php');
}

$stores = get_all_stores();
$locations = get_all_locations();
$categories = get_all_categories();
$subcategories = get_subcategories_per_parent($deal['deal_category']);
$siteSettings = get_settings();
$gallery = get_deals_gallery($deal['deal_id']);

require '../views/edit.deal.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>