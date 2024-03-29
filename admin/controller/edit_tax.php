<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

$errors = array();

if(check_session() == true){

$id_tax = cleardata(getId());

if(!$id_tax){
	header('Location: home.php');
}

if(check_permission('view_taxes') || check_permission('edit_taxes')){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_taxes')){

	$tax_id = cleardata($_POST['tax_id']);
	$tax_countries = json_encode($_POST['tax_countries'] ?? []);

	if(empty($errors)){

	$statment = connect()->prepare("UPDATE taxes SET tax_id = :tax_id, tax_countries = :tax_countries WHERE tax_id = :tax_id");

	$statment->execute(array(
		':tax_id' => $tax_id,
		':tax_countries' => (!empty($_POST['tax_countries']) ? $tax_countries : "[]")
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}

}else{

	header('Location: ./denied.php');		

}

}

	$tax = get_tax_per_id($id_tax);

	if(!$tax){
		header('Location: ./home.php');
	}

	require '../views/edit.tax.view.php';
		
}else{

	header('Location: ./denied.php');		
}

}else{
	header('Location:'.SITE_URL);
}


?>