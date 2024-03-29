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

if(check_permission('create_pages')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

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

$required_fields = ['page_title', 'page_template'];
foreach($required_fields as $field) {
	if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
			$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
	}
}

if(empty($errors)){

$converted_slug = convertSlug(cleardata($_POST['page_title']));
$exists = get_page_slug($converted_slug);

if ($exists > 0){
	$new_number = $exists + 1;
	$slug = $converted_slug."-".$new_number;
}else{
	$slug = $converted_slug;
}

$statment = connect()->prepare("INSERT INTO pages (page_id, page_title, page_seotitle, page_content, page_seodescription, page_status, page_slug, page_template, page_private, page_show_footer, page_show_title, page_ad_header, page_ad_footer, page_ad_sidebar) VALUES (null, :page_title, :page_seotitle, :page_content, :page_seodescription, :page_status, :page_slug, :page_template, :page_private, :page_show_footer, :page_show_title, :page_ad_header, :page_ad_footer, :page_ad_sidebar)");

$statment->execute(array(
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

header('Location: ./pages.php');

}

}

require '../views/new.page.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else {

	header('Location:'.SITE_URL);

}

?>