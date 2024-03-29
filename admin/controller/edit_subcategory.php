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

$id_subcategory = cleardata(getId());

if(!$id_subcategory){
	header('Location: home.php');
}

if(check_permission('view_subcategories') || check_permission('edit_subcategories')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_subcategories')){

	$subcategory_id = cleardata($_POST['subcategory_id']);
	$subcategory_parent = cleardata($_POST['subcategory_parent']);
	$subcategory_title = cleardata($_POST['subcategory_title']);
	$subcategory_seotitle = cleardata($_POST['subcategory_seotitle']);
	$subcategory_description = cleardata($_POST['subcategory_description']);
	$subcategory_seodescription = cleardata($_POST['subcategory_seodescription']);
	$subcategory_status = cleardata($_POST['subcategory_status']);
	$subcategory_slug = cleardata($_POST['subcategory_slug']);

	$required_fields = ['subcategory_title', 'subcategory_parent'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	if(empty($errors)){

	if (empty($subcategory_slug)) {
		$slug = $_POST['subcategory_slug_save'];
	}else{

		$converted_slug = convertSlug($_POST['subcategory_slug']);
		$exists = get_subcategory_slug($converted_slug);

		if ($exists > 0){

			$new_number = $exists + 1;
			$slug = $converted_slug."-".$new_number;

		}else{

			$slug = $converted_slug;
		}
	}

	$statment = connect()->prepare("UPDATE subcategories SET subcategory_id = :subcategory_id, subcategory_parent = :subcategory_parent, subcategory_title = :subcategory_title, subcategory_slug = :subcategory_slug, subcategory_description = :subcategory_description, subcategory_seotitle = :subcategory_seotitle, subcategory_seodescription = :subcategory_seodescription, subcategory_status = :subcategory_status WHERE subcategory_id = :subcategory_id");

	$statment->execute(array(
		':subcategory_id' => $subcategory_id,
		':subcategory_parent' => $subcategory_parent,
		':subcategory_title' => $subcategory_title,
		':subcategory_slug' => $slug,
		':subcategory_description' => $subcategory_description,
		':subcategory_seotitle' => $subcategory_seotitle,
		':subcategory_seodescription' => $subcategory_seodescription,
		':subcategory_status' => $subcategory_status
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}


}else{

	header('Location: ./denied.php');		

}

}

	$subcategory = get_subcategory_per_id($id_subcategory);

	if(!$subcategory){
		header('Location: ./home.php');
	}

	$categories = get_all_categories();
	require '../views/edit.subcategory.view.php';

}else{

	header('Location: ./denied.php');		
}

}else{
	header('Location:'.SITE_URL);
}


?>