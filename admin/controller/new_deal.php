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

if(check_permission('create_deals')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

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
	$deal_author = cleardata($_POST['deal_author']);
	$deal_price = cleardata($_POST['deal_price']);
	$deal_oldprice = cleardata($_POST['deal_oldprice']);
	$deal_link = cleardata($_POST['deal_link']);
	$deal_video = cleardata($_POST['deal_video']);
	$deal_gif = cleardata($_POST['deal_gif']);
	$deal_start = cleardata($_POST['deal_start']);
	$deal_expire = cleardata($_POST['deal_expire']);
	$deal_exclusive = cleardata($_POST['deal_exclusive']);
	$deal_featured = cleardata($_POST['deal_featured']);

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

		$converted_slug = convertSlug(cleardata($_POST['deal_title']));
		$exists = get_deal_slug($converted_slug);
	
		if ($exists > 0){
			$new_number = $exists + 1;
			$slug = $converted_slug."-".$new_number;
	
		}else{
	
			$slug = $converted_slug;
		}

		$statment = connect()->prepare("INSERT INTO deals (deal_id, deal_title, deal_seotitle, deal_slug, deal_description, deal_seodescription, deal_tagline, deal_category, deal_subcategory, deal_store, deal_location, deal_status, deal_author, deal_price, deal_oldprice, deal_link, deal_video, deal_gif, deal_start, deal_expire, deal_exclusive, deal_featured, deal_created, deal_image) VALUES (null, :deal_title, :deal_seotitle, :deal_slug, :deal_description, :deal_seodescription, :deal_tagline, :deal_category, :deal_subcategory, :deal_store, :deal_location, :deal_status, :deal_author, :deal_price, :deal_oldprice, :deal_link, :deal_video, :deal_gif, :deal_start, :deal_expire, :deal_exclusive, :deal_featured, CURRENT_TIMESTAMP, :deal_image)");

		$statment->execute(array(
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
			':deal_author' => $deal_author,
			':deal_price' => $deal_price,
			':deal_oldprice' => $deal_oldprice,
			':deal_link' => $deal_link,
			':deal_video' => $deal_video,
			':deal_gif' => $deal_gif,
			':deal_start' => $deal_start,
			':deal_expire' => $deal_expire,
			':deal_exclusive' => $deal_exclusive,
			':deal_featured' => $deal_featured,
			':deal_image' => $uploadedImages['deal_image']
		));
	
		$idItem = connect()->lastInsertId();
		unset($temp);
	
		$statment->bindParam(':item', $idItem);
	
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
	
				$statment = connect()->prepare("INSERT INTO deals_gallery (id,item,picture,created) VALUES (null, :item, :picture, CURRENT_TIMESTAMP)");
	
				foreach ($uploadedFiles as $key => $value){
					$statment->execute(array(
						':item' => $idItem,
						':picture' => $value['name']
					));
				}
			}

		header('Location: ./deals.php');

	}

}

$stores = get_all_stores();
$locations = get_all_locations();
$categories = get_all_categories();
$siteSettings = get_settings();

$userInfo = get_user_information();

require '../views/new.deal.view.php';

}else{

header('Location: ./denied.php');

}

}else{

header('Location:'.SITE_URL);

}


?>