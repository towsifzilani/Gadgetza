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

if(check_permission('delete_subcategories')){

	$statement = connect()->prepare("DELETE FROM subcategories WHERE subcategory_id = :subcategory_id");
	$statement->execute(array('subcategory_id' => $id_item));

	$statment = connect()->prepare("UPDATE deals SET deal_subcategory = 0 WHERE deal_subcategory = :deal_subcategory");
	$statment->execute(array(':deal_subcategory' => $id_item));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{
	
	echo "access_denied";
}

}else{
	
	exit();		
}

?>