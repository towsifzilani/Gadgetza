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

$id_role = cleardata(getId());

if(!$id_role){
	header('Location: home.php');
}

if(check_permission('view_roles') || check_permission('edit_roles')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_roles')){

	$role_id = cleardata($_POST['role_id']);
	$role_title = cleardata($_POST['role_title']);
	$role_permissions = (!empty($_POST['role_permissions']) ? json_encode($_POST['role_permissions']) : "[]");

	$required_fields = ['role_title'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	if(empty($errors)){

	$statment = connect()->prepare("UPDATE roles SET role_id = :role_id, role_title = :role_title, role_permissions = :role_permissions WHERE role_id = :role_id");

	$statment->execute(array(
		':role_id' => $role_id,
		':role_title' => $role_title,
		':role_permissions' => $role_permissions
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}

}else{

	header('Location: ./denied.php');		

}

}

	$role = get_role_per_id($id_role);
	
	if(!$role){
		header('Location: ./home.php');
	}
	
	require '../views/edit.role.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>