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

$id_plan = cleardata(getId());

if(!$id_plan){
	header('Location: home.php');
}

if(check_permission('view_plans') || check_permission('edit_plans')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(check_permission('edit_plans')){

	$plan_id = cleardata($_POST['plan_id']);
	$plan_order = cleardata($_POST['plan_order']);
	$plan_title = cleardata($_POST['plan_title']);
	$plan_description = cleardata($_POST['plan_description']);
	$plan_status = cleardata($_POST['plan_status']);
	$plan_monthly = cleardata($_POST['plan_monthly']);
	$plan_monthly_label = cleardata($_POST['plan_monthly_label']);
	$plan_monthly_description = cleardata($_POST['plan_monthly_description']);
	$plan_halfyear = cleardata($_POST['plan_halfyear']);
	$plan_halfyear_label = cleardata($_POST['plan_halfyear_label']);
	$plan_halfyear_description = cleardata($_POST['plan_halfyear_description']);
	$plan_annual = cleardata($_POST['plan_annual']);
	$plan_annual_label = cleardata($_POST['plan_annual_label']);
	$plan_annual_description = cleardata($_POST['plan_annual_description']);
	$plan_total = cleardata($_POST['plan_total']);
	$plan_limit = cleardata($_POST['plan_limit']);
	$plan_customstore = cleardata($_POST['plan_customstore']);
	$plan_recommended = cleardata($_POST['plan_recommended']);
	$plan_checkbox = cleardata($_POST['plan_checkbox']);
	$plan_summary = cleardata($_POST['plan_summary']);
	$plan_features = cleardata($_POST['plan_features']);
	$plan_taxes = json_encode($_POST['plan_taxes'] ?? []);
	$plan_codes = json_encode($_POST['plan_codes'] ?? []);

	$required_fields = ['plan_title', 'plan_total', 'plan_limit'];
	foreach($required_fields as $field) {
		if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
				$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
		}
	}
	
	if(empty($errors)){

    for($i=0;$i<count($plan_features);$i++){

		if($plan_checkbox[$i]!="" && $plan_features[$i]!=""){

			$array[] = array(
			"status" => $plan_checkbox[$i],
			"summary" => $plan_summary[$i],
			"title" => $plan_features[$i]
			);
		}
    }

    $data = json_encode($array);

	$statment = connect()->prepare("UPDATE plans SET
		plan_id = :plan_id,
        plan_order = :plan_order,
        plan_title = :plan_title,
        plan_description = :plan_description,
        plan_status = :plan_status,
        plan_monthly = :plan_monthly,
        plan_monthly_label = :plan_monthly_label,
        plan_monthly_description = :plan_monthly_description,
        plan_halfyear = :plan_halfyear,
        plan_halfyear_label = :plan_halfyear_label,
        plan_halfyear_description = :plan_halfyear_description,
        plan_annual = :plan_annual,
        plan_annual_label = :plan_annual_label,
        plan_annual_description = :plan_annual_description,
        plan_total = :plan_total,
        plan_limit = :plan_limit,
        plan_customstore = :plan_customstore,
        plan_recommended = :plan_recommended,
        plan_features = :plan_features,
        plan_taxes = :plan_taxes,
        plan_codes = :plan_codes WHERE plan_id = :plan_id");

	$statment->execute(array(
		':plan_id' => $plan_id,
		':plan_order' => $plan_order,
		':plan_title' => $plan_title,
		':plan_description' => $plan_description,
		':plan_status' => $plan_status,
		':plan_monthly' => $plan_monthly,
		':plan_monthly_label' => $plan_monthly_label,
		':plan_monthly_description' => $plan_monthly_description,
		':plan_halfyear' => $plan_halfyear,
		':plan_halfyear_label' => $plan_halfyear_label,
		':plan_halfyear_description' => $plan_halfyear_description,
		':plan_annual' => $plan_annual,
		':plan_annual_label' => $plan_annual_label,
		':plan_annual_description' => $plan_annual_description,
		':plan_total' => $plan_total,
		':plan_limit' => $plan_limit,
		':plan_customstore' => $plan_customstore,
		':plan_recommended' => $plan_recommended,
		':plan_features' => $data,
		':plan_taxes' => (!empty($_POST['plan_taxes']) ? $plan_taxes : "[]"),
		':plan_codes' => (!empty($_POST['plan_codes']) ? $plan_codes : "[]")
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}


}else{

	header('Location: ./denied.php');		

}

}

	$siteSettings = get_settings();

	$plan = get_plan_per_id($id_plan);

	if(!$plan){
		header('Location: ./home.php');
	}
	
	$features = json_decode($plan['plan_features'], true);
	
	if(empty($features)) {

		$features = array();
	}
	
	$taxes = get_all_taxes();
	$codes = get_all_codes();
	
	require '../views/edit.plan.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>