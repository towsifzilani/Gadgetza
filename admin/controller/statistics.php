<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('view_statistics')){

	$earnings = get_earnings_by_interval();
    $topdeals = get_top_deals_by_interval(4);
    $latestpayments = get_latest_payments(4, true);
    $topcountries = get_top_countries(4);
    $topcities = get_top_cities(4);

require '../views/statistics.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>