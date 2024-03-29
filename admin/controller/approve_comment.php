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
	header('Location: ./home.php');
}

if(check_permission('edit_comments')){

	$statment = connect()->prepare("UPDATE reviews SET status = :status WHERE id = :id");

	$statment->execute(array(':id' => $id_item, ':status' => 1));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location: ./denied.php');

}

}else{
	
	header('Location:'.SITE_URL);
}


?>