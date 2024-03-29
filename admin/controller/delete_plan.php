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

if(check_permission('delete_plans')){

	$statement = connect()->prepare("DELETE FROM plans WHERE plan_id = :plan_id");
	$statement->execute(array('plan_id' => $id_item));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{
	
	echo "access_denied";
}

}else{
	
	exit();		
}

?>