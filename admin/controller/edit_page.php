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

$id_page = cleardata(getId());

if(!$id_page){
	header('Location: home.php');
}

if(check_permission('view_pages') || check_permission('edit_pages')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_pages')){

	$page_id = cleardata($_POST['page_id']);
	$page_title = cleardata($_POST['page_title']);
	$page_template = cleardata($_POST['page_template']);
	$page_seotitle = cleardata($_POST['page_seotitle']);
	$page_content = $_POST['page_content'];
	$page_seodescription = cleardata($_POST['page_seodescription']);
	$page_status = cleardata($_POST['page_status']);
	$page_private = cleardata($_POST['page_private']);
	$page_show_footer = cleardata($_POST['page_show_footer']);
	$page_show_title = cleardata($_POST['page_show_title']);
	$page_ad_header = cleardata($_POST['page_ad_header']);
	$page_ad_footer = cleardata($_POST['page_ad_footer']);
	$page_ad_sidebar = cleardata($_POST['page_ad_sidebar']);
	$page_slug = cleardata($_POST['page_slug']);

	$required_fields = ['page_title'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	if(empty($errors)){

	if(empty($page_slug)) {

		$slug = $_POST['page_slug_save'];

	}else{

		$converted_slug = convertSlug($_POST['page_slug']);
		$exists = get_page_slug($converted_slug);

		if ($exists > 0){

			$new_number = $exists + 1;
			$slug = $converted_slug."-".$new_number;

		}else{

			$slug = $converted_slug;
		}
	}

$statment = connect()->prepare("UPDATE pages SET page_id = :page_id, page_title = :page_title, page_template = :page_template, page_seotitle = :page_seotitle, page_content = :page_content, page_seodescription = :page_seodescription, page_status = :page_status, page_slug = :page_slug, page_private = :page_private, page_show_footer = :page_show_footer, page_show_title = :page_show_title, page_ad_header = :page_ad_header, page_ad_footer = :page_ad_footer, page_ad_sidebar = :page_ad_sidebar WHERE page_id = :page_id");

$statment->execute(array(
	':page_id' => $page_id,
	':page_title' => $page_title,
	':page_seotitle' => $page_seotitle,
	':page_content' => $page_content,
	':page_seodescription' => $page_seodescription,
	':page_status' => $page_status,
	':page_slug' => $slug,
	':page_template' => $page_template,
	':page_private' => $page_private,
	':page_show_footer' => $page_show_footer,
	':page_show_title' => $page_show_title,
	':page_ad_header' => $page_ad_header,
	':page_ad_footer' => $page_ad_footer,
	':page_ad_sidebar' => $page_ad_sidebar
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}

}else{

	header('Location: ./denied.php');		

}

}

	$page = get_page_per_id($id_page);
	
	if(!$page){
		header('Location: ./home.php');
	}
	
	require '../views/edit.page.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>