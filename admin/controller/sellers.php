<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('view_sellers')){
    
require '../views/sellers.view.php';
	
}else{

	header('Location: ./denied.php');
}

}else{

	header('Location:'.SITE_URL);
}


?>