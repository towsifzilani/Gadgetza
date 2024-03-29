<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_roles')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$role_title = cleardata($_POST['role_title']);
	$role_permissions = json_encode($_POST['role_permissions']);

	$statment = connect()->prepare("INSERT INTO roles (role_id, role_title, role_permissions) VALUES (null, :role_title, :role_permissions)");

	$statment->execute(array(
		':role_title' => $role_title,
		':role_permissions' => $role_permissions
	));

	header('Location: ./roles.php');

}

$roles = get_all_roles();

require '../views/new.role.view.php';

}else{

header('Location: ./denied.php');
}

}else {

header('Location:'.SITE_URL);

}

?>