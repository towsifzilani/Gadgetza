<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require_once '../../config.php';
require_once '../functions.php';

$connect = connect();

if(!$connect){
	header('Location: ./error.php');
}

if(check_session() == true){

require '../views/header.view.php';

}else{
	
	header('Location:'.SITE_URL);

}

?>