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

if(check_permission('delete_deals')){

	$statement = connect()->prepare("DELETE FROM categories WHERE category_id = :category_id");
	$statement->execute(array('category_id' => $id_item));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	echo "access_denied";
}

}else{
	
	exit();		
}

?>