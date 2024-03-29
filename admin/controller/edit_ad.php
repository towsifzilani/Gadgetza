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
    
$id_ad = cleardata(getId());

if(!$id_ad){

	header('Location: home.php');
}

if(check_permission('view_ads') || check_permission('edit_ads')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

	if(check_permission('edit_ads')){

		$ad_id = cleardata($_POST['ad_id']);
		$ad_title = cleardata($_POST['ad_title']);
		$ad_html = $_POST['ad_html'];
		$ad_position = cleardata($_POST['ad_position']);
		$ad_status = cleardata($_POST['ad_status']);

		$required_fields = ['ad_title', 'ad_html', 'ad_position'];
		foreach($required_fields as $field) {
			if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
					$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
			}
		}

		if(empty($errors)){

		$statment = connect()->prepare("UPDATE ads SET ad_id = :ad_id, ad_title = :ad_title, ad_html = :ad_html, ad_position = :ad_position, ad_status = :ad_status WHERE ad_id = :ad_id");

		$statment->execute(array(
		':ad_id' => $ad_id,
		':ad_title' => $ad_title,
		':ad_html' => $ad_html,
		':ad_position' => $ad_position,
		':ad_status' => $ad_status
		));

		header('Location: ' . $_SERVER['HTTP_REFERER']);

	}


	}else{

		header('Location: ./denied.php');		

	}

	}

	$ad = get_ad_per_id($id_ad);

	if(!$ad){
		header('Location: ./home.php');
	}

	require '../views/edit.ad.view.php';

}else{

header('Location: ./denied.php');		

}

}else {

header('Location:'.SITE_URL);

}

?>