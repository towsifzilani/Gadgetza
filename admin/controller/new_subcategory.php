<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_subcategories')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$subcategory_parent = cleardata($_POST['subcategory_parent']);
	$subcategory_title = cleardata($_POST['subcategory_title']);
	$subcategory_seotitle = cleardata($_POST['subcategory_seotitle']);
	$subcategory_description = cleardata($_POST['subcategory_description']);
	$subcategory_seodescription = cleardata($_POST['subcategory_seodescription']);

	$required_fields = ['subcategory_title', 'subcategory_parent'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	if(empty($errors)){

	$converted_slug = convertSlug(cleardata($_POST['subcategory_title']));
	$exists = get_subcategory_slug($converted_slug);

	if ($exists > 0){

		$new_number = $exists + 1;
		$slug = $converted_slug."-".$new_number;

	}else{

		$slug = $converted_slug;
	}

	$statment = connect()->prepare("INSERT INTO subcategories (subcategory_id, subcategory_parent, subcategory_title, subcategory_seotitle, subcategory_description, subcategory_seodescription, subcategory_slug) VALUES (null, :subcategory_parent, :subcategory_title, :subcategory_seotitle, :subcategory_description, :subcategory_seodescription, :subcategory_slug)");

	$statment->execute(array(
		':subcategory_parent' => $subcategory_parent,
		':subcategory_title' => $subcategory_title,
		':subcategory_slug' => $slug,
		':subcategory_seotitle' => $subcategory_seotitle,
		':subcategory_description' => $subcategory_description,
		':subcategory_seodescription' => $subcategory_seodescription
	));

	header('Location: ./subcategories.php');

}

}


$categories = get_all_categories();

require '../views/new.subcategory.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else{

	header('Location:'.SITE_URL);
}


?>