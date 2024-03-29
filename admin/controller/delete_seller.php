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

if(check_permission('delete_sellers')){

	$statement = connect()->prepare("DELETE FROM sellers WHERE seller_id = :seller_id");
	$statement->execute(array('seller_id' => $id_item));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	echo "access_denied";
}

}else{
	
	exit();		
}

?>