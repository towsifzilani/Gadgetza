<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require_once '../../config.php';
require_once '../functions.php';

if(check_session() == true){

	session_destroy();
	$_SESSION = array ();

	header('Location: ./login.php');

}else{
	
	header('Location:'.SITE_URL);

}

?>