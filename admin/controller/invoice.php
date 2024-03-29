<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

$id_payment = cleardata(getId());
$theme = get_theme();
$settings = get_settings();

if(!$id_payment){
	header('Location: home.php');
}

if(check_permission('view_payments')){

$itemDetails = get_payment_per_id($id_payment);

if (!$itemDetails){
	header('Location: ./home.php');
}

$userBilling = json_decode($itemDetails['user_billing']);
$taxes = get_taxes_by_ids($itemDetails['payment_taxes']);

require '../views/invoice.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>