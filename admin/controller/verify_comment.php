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

if(check_permission('edit_comments')){

$id_item = cleardata($_GET['id']);

$statment = connect()->prepare("UPDATE reviews SET verified = :verified WHERE id = :id");

$statment->execute(array(':id' => $id_item,':verified' => 1));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

	header('Location: ./denied.php');
}

}else{

	exit();
}

?>