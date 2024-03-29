<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){
    
$id_item = cleardata($_GET['id']);

if(!$id_item){
	exit();
}

if(check_permission('delete_pages')){

	$isDefault = is_default_page($id_page);

	if (!$isDefault) {

		$statement = connect()->prepare("DELETE FROM pages WHERE page_id = :page_id");
		$statement->execute(array('page_id' => $id_item));

		$statement = connect()->prepare("DELETE FROM navigations WHERE navigation_page = :navigation_page");
		$statement->execute(array('navigation_page' => $id_item));

		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}else{

		if(isset($_SERVER['HTTP_REFERER'])) {

			header('Location: ' . $_SERVER['HTTP_REFERER']);

		}else{

			header('Location: ./pages.php');		
		}
	}

}else{
	
	echo "access_denied";
}

}else{
	
	exit();		
}

?>