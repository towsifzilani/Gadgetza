<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('create_ads')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	$ad_title = cleardata($_POST['ad_title']);
	$ad_position = cleardata($_POST['ad_position']);

	$statment = connect()->prepare("INSERT INTO ads (ad_id,ad_title,ad_position) VALUES (null, :ad_title, :ad_position)");

	$statment->execute(array(
	':ad_title' => $ad_title,
	':ad_position' => $ad_position
	));

}

}else{
	
	echo "access_denied";
}

}else {

	header('Location:'.SITE_URL);

}


?>