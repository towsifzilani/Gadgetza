<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){
    
	$id_item = cleardata($_GET['id']);

	if(!$id_item){
		exit();
	}

	if(check_permission('delete_users')){

		cancelUserSubscription(get_settings(), $id_item);

		$statement = connect()->prepare("DELETE FROM users WHERE user_id = :user_id");
		$statement->execute(array('user_id' => $id_item));

		$statement = connect()->prepare("DELETE FROM sellers WHERE seller_user = :seller_user");
		$statement->execute(array('seller_user' => $id_item));
		
		$statement = connect()->prepare("DELETE FROM deals WHERE deal_author = :deal_author");
		$statement->execute(array('deal_author' => $id_item));

		$statement = connect()->prepare("DELETE FROM favorites WHERE user = :user");
		$statement->execute(array('user' => $id_item));

		$statement = connect()->prepare("DELETE FROM reviews WHERE user = :user");
		$statement->execute(array('user' => $id_item));

		/*
		
		$statement = connect()->prepare("DELETE FROM tracking WHERE track_user = :track_user");
		$statement->execute(array('track_user' => $id_item));
		
		$statement = connect()->prepare("DELETE FROM payments WHERE payment_user_id = :payment_user_id");
		$statement->execute(array('payment_user_id' => $id_item));
		
		*/

		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}else{
		
		echo "access_denied";
	}

}else{
	
	exit();		
}

?>