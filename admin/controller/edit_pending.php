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

$id_deal = cleardata(getId());

if(!$id_deal){
	header('Location: home.php');
}

if(check_permission('edit_deals')){

	$siteSettings = get_settings();
	$siteTheme = get_theme();

	$deal = get_pending_deal_per_id($id_deal);

	if(!$deal){
		header('Location: ./home.php');
	}

    $userDetails = get_user_per_id($deal['deal_author']);

    $array_content = array(
	"{LOGO_URL}" => SITE_URL . "/images/" . $siteTheme['th_logo'],
    "{SITE_DOMAIN}" => SITE_URL, 
    "{SITE_NAME}" => $siteTranslation['tr_1'], 
    "{USER_ID}" => $deal['deal_author'], 
    "{USER_NAME}" => $userDetails['user_name'], 
    "{USER_EMAIL}" => $userDetails['user_email'], 
	"{ITEM_ID}" => $deal['deal_id'],
	"{ITEM_TITLE}" => $deal['deal_title'],
	"{ITEM_IMAGE}" => SITE_URL . "/images/" . $deal['deal_image'],
	"{ITEM_URL}" => SITE_URL . "/deal/" . $deal['deal_id'] . "/" . $deal['deal_slug'],
	"{REVIEW_MESSAGE}" => cleardata($_POST['reviewer_message']),
    "{TERMS_URL}" => get_default_page_slug($siteSettings['st_defaulttermspage']), 
    "{PRIVACY_URL}" => get_default_page_slug($siteSettings['st_defaultprivacypage']),
    "{SIGNIN_URL}" => SITE_URL . "/signin",
    "{CONTACT_URL}" => get_default_page_slug($siteSettings['st_defaultcontactpage']),
    );

	if(isset($_POST['submit'])){

	if($_POST['submit'] == "approved"){
	
		$statment = connect()->prepare("UPDATE deals SET deal_status = 1, deal_created = :deal_created WHERE deal_id = :deal_id");

		$statment->execute(array(
			':deal_id' => $deal['deal_id'],
			':deal_created' => get_date_by_timezone()
		));

		$statment = connect()->prepare("UPDATE deals_gallery SET status = 1 WHERE item = :item");
	
		$statment->execute(array(
			':item' => $deal['deal_id']
		));

		$emailTemplate = getEmailTemplate(9);

		if($emailTemplate) {
    
			$emailContent = json_decode($emailTemplate['email_content'], true);
		
			$mail = sendMail($array_content, $emailContent[0]['message'], $userDetails['user_email'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext'], $siteSettings);
		}

	}elseif($_POST['submit'] == "rejected"){

		$statment = connect()->prepare("UPDATE deals SET deal_status = 4 WHERE deal_id = :deal_id");
		$statment->execute(array(
			':deal_id' => $deal['deal_id']
		));

		$emailTemplate = getEmailTemplate(8);

		if($emailTemplate) {
    
			$emailContent = json_decode($emailTemplate['email_content'], true);
		
			$mail = sendMail($array_content, $emailContent[0]['message'], $userDetails['user_email'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext'], $siteSettings);
		}

	}elseif($_POST['submit'] == "cancel"){

		$statment = connect()->prepare("UPDATE deals SET deal_status = 5 WHERE deal_id = :deal_id");
		$statment->execute(array(
			':deal_id' => $deal['deal_id']
		));

		$emailTemplate = getEmailTemplate(10);

		if($emailTemplate) {
    
			$emailContent = json_decode($emailTemplate['email_content'], true);
		
			$mail = sendMail($array_content, $emailContent[0]['message'], $userDetails['user_email'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext'], $siteSettings);
		}

	}

	$statment = connect()->prepare("INSERT INTO submissions_log (id,item,author_id,author_message,reviewer_message,reviewer_id,log_type,created) VALUES (null, :item, :author_id, :author_message, :reviewer_message, :reviewer_id, :log_type, :created)");
	$statment->execute(array(
		':item' => $deal['deal_id'],
		':author_id' => $deal['deal_author'],
		':author_message' => null,
		':reviewer_message' => cleardata($_POST['reviewer_message']),
		':reviewer_id' => cleardata($_POST['reviewer_id']),
		':log_type' => $_POST['submit'],
		':created' => get_date_by_timezone()
	));

	header('Location: ./deals.php');		

	}

	$gallery = get_deals_gallery($deal['deal_id']);

	require '../views/edit.pending.view.php';

}else{

	header('Location: ./denied.php');		
}

}else{
	header('Location:'.SITE_URL);
}


?>