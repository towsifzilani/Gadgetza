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

	$id_category = cleardata(getId());

	if(!$id_category){
		header('Location: home.php');
	}

	if(check_permission('view_categories') || check_permission('edit_categories')){

			if($_SERVER['REQUEST_METHOD'] == 'POST'){

	
	
		if(check_permission('edit_categories')){

			$category_id = cleardata($_POST['category_id']);
			$category_title = cleardata($_POST['category_title']);
			$category_seotitle = cleardata($_POST['category_seotitle']);
			$category_description = cleardata($_POST['category_description']);
			$category_seodescription = cleardata($_POST['category_seodescription']);
			$category_featured = cleardata($_POST['category_featured']);
			$category_status = cleardata($_POST['category_status']);
			$category_icon = cleardata($_POST['category_icon']);
			$category_menu = cleardata($_POST['category_menu']);
			$category_slug = cleardata($_POST['category_slug']);

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

			if(empty($category_slug)) {
				$slug = $_POST['category_slug_save'];
			}else{

				$converted_slug = convertSlug($_POST['category_slug']);
				$exists = get_category_slug($converted_slug);

				if ($exists > 0){
					$new_number = $exists + 1;
					$slug = $converted_slug."-".$new_number;
				}else{
					$slug = $converted_slug;
				}
			}

			$statment = connect()->prepare("UPDATE categories SET category_id = :category_id, category_title = :category_title, category_slug = :category_slug, category_description = :category_description, category_seotitle = :category_seotitle, category_seodescription = :category_seodescription, category_featured = :category_featured, category_status = :category_status, category_icon = :category_icon, category_menu = :category_menu, category_image = :category_image WHERE category_id = :category_id");

			$statment->execute(array(
				':category_id' => $category_id,
				':category_title' => $category_title,
				':category_slug' => $slug,
				':category_description' => $category_description,
				':category_seotitle' => $category_seotitle,
				':category_seodescription' => $category_seodescription,
				':category_featured' => $category_featured,
				':category_status' => $category_status,
				':category_icon' => $category_icon,
				':category_menu' => $category_menu,
				':category_image' => (isset($uploadedImages['category_image']) ? $uploadedImages['category_image'] : $_POST['category_image_save'])
			));

			header('Location: ' . $_SERVER['HTTP_REFERER']);

		}

		}else{
	
			header('Location: ./denied.php');		
	
		}
		
		}

			$category = get_category_per_id($id_category);

			if (!$category){

				header('Location: ./home.php');
			}

			require '../views/edit.category.view.php';
		
}else{

	header('Location: ./denied.php');		

	}

}else {
	header('Location:'.SITE_URL);
}

?>