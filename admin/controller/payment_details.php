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

if(!$id_payment){
	header('Location: home.php');
}

if(check_permission('view_payments')){

$payment = get_payment_per_id($id_payment);

if (!$payment){
	header('Location: ./home.php');
}

require '../views/payment.details.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>