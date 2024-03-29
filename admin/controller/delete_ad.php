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

if(check_permission('delete_ads')){

	$statement = connect()->prepare("DELETE FROM ads WHERE ad_id = :ad_id");
	$statement->execute(array('ad_id' => $id_item));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{
    
	echo "access_denied";
}

}else{

	exit();		
}

?>