<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

$errors = array();

if(check_session() == true){

$id_user = cleardata(getId());

if(!$id_user){
	header('Location: home.php');
}

if(check_permission('view_users')){

	$usr = get_user_per_id($id_user);

	if(!$usr){
		header('Location: ./home.php');
	}

	$siteSettings = get_settings();
	$usrBilling = json_decode($usr['user_billing']);
	$planDetails = get_plan_per_id(($usr['user_plan'] ? $usr['user_plan'] : 0));

	require '../views/user.details.view.php';

}else{

	header('Location: ./denied.php');		
}

}else{
	header('Location:'.SITE_URL);
}


?>