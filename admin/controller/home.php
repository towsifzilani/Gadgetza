<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';	

if(check_session() == true){ 

$users_total = users_total(); 
$deals_total = deals_total();
$sellers_total = sellers_total();
$payments_total = payments_total();
$latestdeals = get_all_deals(5);
$topvisitdeals = get_top_deals(5);
$latestusers = get_all_users(5);
$latestpayments = get_latest_payments(5);

require '../views/home.view.php';
    
}else{

	header('Location:'.SITE_URL);
}


?>