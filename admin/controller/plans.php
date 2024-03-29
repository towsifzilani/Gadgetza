<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('view_plans')){

	$siteSettings = get_settings();

	require '../views/plans.view.php';

}else{
	
	header('Location: ./denied.php');
	
}

}else{

    header('Location:'.SITE_URL);
}

?>