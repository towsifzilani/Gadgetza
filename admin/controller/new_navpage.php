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

$stat = connect()->prepare("SELECT navigation_order FROM navigations ORDER BY navigation_order DESC LIMIT 1");
$stat->execute();
$row = $stat->fetch(PDO::FETCH_ASSOC);
$orderNumber = $row["navigation_order"];

$newOrder = $orderNumber + 1;

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$page_id = cleardata($_POST['page_id']);
	$menu_id = cleardata($_POST['menu_id']);
	$navigation_target = $_POST['navigation_target'];
	$navigation_type = cleardata($_POST['navigation_type']);

	$statment = connect()->prepare("INSERT INTO navigations (navigation_id,navigation_order, navigation_page,navigation_target,navigation_type,navigation_menu) VALUES (null, :navigation_order, :navigation_page, :navigation_target, :navigation_type, :navigation_menu)");

	$statment->execute(array(
	':navigation_order' => $newOrder,
	':navigation_page' => $page_id,
	':navigation_target' => $navigation_target,
	':navigation_type' => $navigation_type,
	':navigation_menu' => $menu_id
	));

}

}else{
	
	header('Location: ./denied.php');
}

}else{

	header('Location:'.SITE_URL);

}

?>