<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

$id_item = cleardata(getId());

if(!$id_item){
	exit();
}

if(check_permission('delete_menus')){

	$statement = connect()->prepare("DELETE FROM navigations WHERE navigation_menu = :navigation_menu");
	$statement->execute(array('navigation_menu' => $id_item));
	
	$statement = connect()->prepare("DELETE FROM menus WHERE menu_id = :menu_id");
	$statement->execute(array('menu_id' => $id_item));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{
    
	echo "access_denied";
}

}else{

	exit();		
}

?>