<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_menus')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$menu_name = cleardata($_POST['menu_name']);
	$menu_header = cleardata($_POST['menu_header']);
	$menu_footer = cleardata($_POST['menu_footer']);
	$menu_sidebar = cleardata($_POST['menu_sidebar']);

	$statment = connect()->prepare("INSERT INTO menus (menu_id,menu_name,menu_header,menu_footer,menu_sidebar) VALUES (null, :menu_name, :menu_header, :menu_footer, :menu_sidebar)");

	$statment->execute(array(
		':menu_name' => $menu_name,
		':menu_header' => $menu_header,
		':menu_footer' => $menu_footer,
		':menu_sidebar' => $menu_sidebar
	));

}

}else{
	
	echo "access_denied";
	
}

}else {

	header('Location:'.SITE_URL);

}

?>