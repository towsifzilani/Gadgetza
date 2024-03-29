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

$id_email = cleardata(getId());

if(!$id_email){
	header('Location: home.php');
}

if(check_permission('view_etemplates') || check_permission('edit_etemplates')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	

if(check_permission('edit_etemplates')){

$email_id = cleardata($_POST['email_id']);
$email_fromname = cleardata($_POST['email_fromname']);
$email_plaintext = cleardata($_POST['email_plaintext']);
$email_disabled = cleardata($_POST['email_disabled']);

$required_fields = ['email_fromname', 'email_plaintext', 'message', 'subject'];
foreach($required_fields as $field) {
	if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
			$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
	}
}

if(empty($errors)){

$sentence = connect()->prepare("UPDATE emailtemplates SET email_fromname = :email_fromname, email_plaintext = :email_plaintext, email_disabled = :email_disabled, email_content = :email_content WHERE email_id = :email_id");

$array = array();

$array[] = array(
"message" => $_POST["message"],
"subject" => $_POST["subject"],
);

$data = json_encode($array);

$sentence->execute(array(
		':email_id' => $email_id,
		':email_fromname' => $email_fromname,
		':email_plaintext' => $email_plaintext,
		':email_disabled' => $email_disabled,
		':email_content' => $data
		));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}

	}else{

		header('Location: ./denied.php');		

	}

}

	$etemplate = get_etemplate_by_id($id_email);
    
    if (!$etemplate){
    header('Location: ./home.php');
	}

	$etemplate_content = $etemplate['email_content'];

	$contents = json_decode($etemplate_content, true);

	if(empty($contents)) {
		$contents = array();
	}
	
	require '../views/edit.etemplate.view.php';

}else{

	header('Location: ./denied.php');		

	}

}else {

	header('Location:'.SITE_URL);
}

?>