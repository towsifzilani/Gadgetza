<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_taxes')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$tax_title = cleardata($_POST['tax_title']);
	$tax_percentage = cleardata($_POST['tax_percentage']);
	$tax_type = cleardata($_POST['tax_type']);
	$tax_countries = json_encode($_POST['tax_countries'] ?? []);

	$statment = connect()->prepare("INSERT INTO taxes (tax_id, tax_title, tax_percentage, tax_type, tax_countries) VALUES (null, :tax_title, :tax_percentage, :tax_type, :tax_countries)");

	$statment->execute(array(
		':tax_title' => $tax_title,
		':tax_percentage' => $tax_percentage,
		':tax_type' => $tax_type,
		':tax_countries' => (!empty($_POST['tax_countries']) ? $tax_countries : "[]")
	));

	header('Location: ./taxes.php');
}

require '../views/new.tax.view.php';

}else{
	
	header('Location: ./denied.php');
}

}else{

	header('Location:'.SITE_URL);
}

?>