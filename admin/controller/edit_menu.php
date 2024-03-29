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

$id_menu = cleardata(getId());

if(!$id_menu){
	header('Location: home.php');
}

if(check_permission('view_menus') || check_permission('edit_menus')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

if(check_permission('edit_menus')){

$menu_id = cleardata($_POST['menu_id']);
$menu_name = cleardata($_POST['menu_name']);
$menu_header = cleardata($_POST['menu_header']);
$menu_footer = isset($_POST['menu_footer']) ? cleardata($_POST['menu_footer']) : '0';
$menu_sidebar = isset($_POST['menu_sidebar']) ? cleardata($_POST['menu_sidebar']) : '0';
$menu_status = cleardata($_POST['menu_status']);

$required_fields = ['menu_name'];
foreach($required_fields as $field) {
	if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
			$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
	}
}

if(empty($errors)){

$statment = connect()->prepare("UPDATE menus SET menu_id = :menu_id, menu_name = :menu_name, menu_header = :menu_header, menu_footer = :menu_footer, menu_sidebar = :menu_sidebar, menu_status = :menu_status WHERE menu_id = :menu_id");

$statment->execute(array(
	':menu_id' => $menu_id,
	':menu_name' => $menu_name,
	':menu_header' => $menu_header,
	':menu_footer' => $menu_footer,
	':menu_sidebar' => $menu_sidebar,
	':menu_status' => $menu_status
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}


}else{

	header('Location: ./denied.php');		

}

}

	$menu = get_menu_per_id($id_menu);

	if(!$menu){

		header('Location: ./home.php');
	}
	
	$navigations = get_navigations_by_menu($id_menu);
	$pages = get_all_pages();
	
	require '../views/edit.menu.view.php';

}else{

header('Location: ./denied.php');		

}

}else {
header('Location:'.SITE_URL);
}

?>