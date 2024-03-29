<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

if(check_permission('view_settings') || check_permission('edit_settings')){

if($_SERVER['REQUEST_METHOD'] == 'POST'){

if(check_permission('edit_settings')){

	$st_langdir = $_POST['st_langdir'];
	$st_currency = $_POST['st_currency'];
	$st_currencycode = $_POST['st_currencycode'];
	$st_currencyposition = $_POST['st_currencyposition'];
	$st_decimalseparator = $_POST['st_decimalseparator'];
	$st_decimalnumber = $_POST['st_decimalnumber'];
	$st_dateformat = $_POST['st_dateformat'];
	$st_timezone = $_POST['st_timezone'];
	$st_facebook = $_POST['st_facebook'];
	$st_twitter = $_POST['st_twitter'];
	$st_youtube = $_POST['st_youtube'];
	$st_instagram = $_POST['st_instagram'];
	$st_linkedin = $_POST['st_linkedin'];
	$st_whatsapp = $_POST['st_whatsapp'];
	$st_maintenance = $_POST['st_maintenance'];
	$st_defaultsearchpage = $_POST['st_defaultsearchpage'];
	$st_defaultprivacypage = $_POST['st_defaultprivacypage'];
	$st_defaulttermspage = $_POST['st_defaulttermspage'];
	$st_defaultcategoriespage = $_POST['st_defaultcategoriespage'];
	$st_defaultstorespage = $_POST['st_defaultstorespage'];
	$st_defaultlocationspage = $_POST['st_defaultlocationspage'];
	$st_defaultcontactpage = $_POST['st_defaultcontactpage'];
	$st_defaultpricingpage = $_POST['st_defaultpricingpage'];
	$st_analytics = $_POST['st_analytics'];
	$st_recipientemail = $_POST['st_recipientemail'];
	$st_smtphost = $_POST['st_smtphost'];
	$st_smtpemail = $_POST['st_smtpemail'];
	$st_smtppassword = $_POST['st_smtppassword'];
	$st_smtpencrypt = $_POST['st_smtpencrypt'];
	$st_smtpport = $_POST['st_smtpport'];
	$st_recaptcha_enable = $_POST['st_recaptcha_enable'];
	$st_recaptchakey = $_POST['st_recaptchakey'];
	$st_recaptchasecretkey = $_POST['st_recaptchasecretkey'];
	$st_paypal_status = $_POST['st_paypal_status'];
	$st_paypal_mode = $_POST['st_paypal_mode'];
	$st_paypal_id = $_POST['st_paypal_id'];
	$st_paypal_secret = $_POST['st_paypal_secret'];
	$st_stripe_status = $_POST['st_stripe_status'];
	$st_stripe_key = $_POST['st_stripe_key'];
	$st_stripe_secret = $_POST['st_stripe_secret'];
	$st_stripe_webhook = $_POST['st_stripe_webhook'];
	$st_razorpay_status = $_POST['st_razorpay_status'];
	$st_razorpay_publickey = $_POST['st_razorpay_publickey'];
	$st_razorpay_secretkey = $_POST['st_razorpay_secretkey'];
	$st_razorpay_webhook = $_POST['st_razorpay_webhook'];
	$st_paystack_status = $_POST['st_paystack_status'];
	$st_paystack_secret = $_POST['st_paystack_secret'];
	$st_paystack_public = $_POST['st_paystack_public'];
	$st_mollie_status = $_POST['st_mollie_status'];
	$st_mollie_api = $_POST['st_mollie_api'];
	$st_enable_report_form = $_POST['st_enable_report_form'];
	$st_auto_approve_subsmission = $_POST['st_auto_approve_subsmission'];
	$st_auto_approve_update = $_POST['st_auto_approve_update'];
	$st_only_active_subscription = $_POST['st_only_active_subscription'];
	$st_login_verified_users_only = $_POST['st_login_verified_users_only'];
	$st_access_registered_only_exclusive = $_POST['st_access_registered_only_exclusive'];
	$st_access_registered_only = $_POST['st_access_registered_only'];
	$st_disable_registration = $_POST['st_disable_registration'];
	$st_cookie_consent = $_POST['st_cookie_consent'];
	$st_billing_company = $_POST['st_billing_company'];
	$st_billing_invoice_prefix = $_POST['st_billing_invoice_prefix'];
	$st_billing_address = $_POST['st_billing_address'];
	$st_billing_country = $_POST['st_billing_country'];
	$st_billing_city = $_POST['st_billing_city'];
	$st_billing_postal = $_POST['st_billing_postal'];
	$st_billing_phone = $_POST['st_billing_phone'];
	$st_billing_vat = $_POST['st_billing_vat'];
	$st_verification_email = $_POST['st_verification_email'];
	$st_googleplay_app = $_POST['st_googleplay_app'];
	$st_appstore_app = $_POST['st_appstore_app'];

	$statment = connect()->prepare(
	"UPDATE settings SET
	st_langdir = :st_langdir,
	st_currency = :st_currency,
	st_currencyposition = :st_currencyposition,
	st_currencycode = :st_currencycode,
	st_decimalseparator = :st_decimalseparator,
	st_decimalnumber = :st_decimalnumber,
	st_dateformat = :st_dateformat,
	st_timezone = :st_timezone,
	st_facebook = :st_facebook,
	st_twitter = :st_twitter,
	st_youtube = :st_youtube,
	st_instagram = :st_instagram,
	st_linkedin = :st_linkedin,
	st_whatsapp = :st_whatsapp,
	st_maintenance = :st_maintenance,
	st_defaultsearchpage = :st_defaultsearchpage,
	st_defaultprivacypage = :st_defaultprivacypage,
	st_defaulttermspage = :st_defaulttermspage,
	st_defaultcategoriespage = :st_defaultcategoriespage,
	st_defaultstorespage = :st_defaultstorespage,
	st_defaultlocationspage = :st_defaultlocationspage,
	st_defaultcontactpage = :st_defaultcontactpage,
	st_defaultpricingpage = :st_defaultpricingpage,
	st_analytics = :st_analytics,
	st_recipientemail = :st_recipientemail,
	st_smtphost = :st_smtphost,
	st_smtpemail = :st_smtpemail,
	st_smtppassword = :st_smtppassword,
	st_smtpencrypt = :st_smtpencrypt,
	st_smtpport = :st_smtpport,
	st_recaptcha_enable = :st_recaptcha_enable,
	st_recaptchakey = :st_recaptchakey,
	st_recaptchasecretkey = :st_recaptchasecretkey,
	st_paypal_status = :st_paypal_status,
	st_paypal_mode = :st_paypal_mode,
	st_paypal_id = :st_paypal_id,
	st_paypal_secret = :st_paypal_secret,
	st_stripe_status = :st_stripe_status,
	st_stripe_key = :st_stripe_key,
	st_stripe_secret = :st_stripe_secret,
	st_stripe_webhook = :st_stripe_webhook,
	st_razorpay_status = :st_razorpay_status,
	st_razorpay_publickey = :st_razorpay_publickey,
	st_razorpay_secretkey = :st_razorpay_secretkey,
	st_razorpay_webhook = :st_razorpay_webhook,
	st_paystack_public = :st_paystack_public,
	st_paystack_secret = :st_paystack_secret,
	st_paystack_status = :st_paystack_status,
	st_mollie_status = :st_mollie_status,
	st_mollie_api = :st_mollie_api,
	st_enable_report_form = :st_enable_report_form,
	st_auto_approve_subsmission = :st_auto_approve_subsmission,
	st_auto_approve_update = :st_auto_approve_update,
	st_only_active_subscription = :st_only_active_subscription,
	st_login_verified_users_only = :st_login_verified_users_only,
	st_access_registered_only_exclusive = :st_access_registered_only_exclusive,
	st_access_registered_only = :st_access_registered_only,
	st_disable_registration = :st_disable_registration,
	st_cookie_consent = :st_cookie_consent,
	st_billing_company = :st_billing_company,
	st_billing_invoice_prefix = :st_billing_invoice_prefix,
	st_billing_address = :st_billing_address,
	st_billing_country = :st_billing_country,
	st_billing_city = :st_billing_city,
	st_billing_postal = :st_billing_postal,
	st_billing_phone = :st_billing_phone,
	st_billing_vat = :st_billing_vat,
	st_verification_email = :st_verification_email,
	st_googleplay_app = :st_googleplay_app,
	st_appstore_app = :st_appstore_app
	");

	$statment->execute(array(
	':st_langdir' => $st_langdir,
	':st_currency' => $st_currency,
	':st_currencycode' => $st_currencycode,
	':st_currencyposition' => $st_currencyposition,
	':st_decimalseparator' => $st_decimalseparator,
	':st_decimalnumber' => $st_decimalnumber,
	':st_dateformat' => $st_dateformat,
	':st_timezone' => $st_timezone,
	':st_facebook' => $st_facebook,
	':st_twitter' => $st_twitter,
	':st_youtube' => $st_youtube,
	':st_instagram' => $st_instagram,
	':st_linkedin' => $st_linkedin,
	':st_whatsapp' => $st_whatsapp,
	':st_maintenance' => $st_maintenance,
	':st_defaultsearchpage' => $st_defaultsearchpage,
	':st_defaultprivacypage' => $st_defaultprivacypage,
	':st_defaulttermspage' => $st_defaulttermspage,
	':st_defaultcategoriespage' => $st_defaultcategoriespage,
	':st_defaultstorespage' => $st_defaultstorespage,
	':st_defaultlocationspage' => $st_defaultlocationspage,
	':st_defaultcontactpage' => $st_defaultcontactpage,
	':st_defaultpricingpage' => $st_defaultpricingpage,
	':st_analytics' => $st_analytics,
	':st_recipientemail' => $st_recipientemail,
	':st_smtphost' => $st_smtphost,
	':st_smtpemail' => $st_smtpemail,
	':st_smtppassword' => $st_smtppassword,
	':st_smtpencrypt' => $st_smtpencrypt,
	':st_smtpport' => $st_smtpport,
	':st_recaptcha_enable' => $st_recaptcha_enable,
	':st_recaptchakey' => $st_recaptchakey,
	':st_recaptchasecretkey' => $st_recaptchasecretkey,
	':st_paypal_status' => $st_paypal_status,
	':st_paypal_mode' => $st_paypal_mode,
	':st_paypal_id' => $st_paypal_id,
	':st_paypal_secret' => $st_paypal_secret,
	':st_stripe_status' => $st_stripe_status,
	':st_stripe_key' => $st_stripe_key,
	':st_stripe_secret' => $st_stripe_secret,
	':st_stripe_webhook' => $st_stripe_webhook,
	':st_razorpay_status' => $st_razorpay_status,
	':st_razorpay_publickey' => $st_razorpay_publickey,
	':st_razorpay_secretkey' => $st_razorpay_secretkey,
	':st_razorpay_webhook' => $st_razorpay_webhook,
	':st_paystack_status' => $st_paystack_status,
	':st_paystack_public' => $st_paystack_public,
	':st_paystack_secret' => $st_paystack_secret,
	':st_mollie_status' => $st_mollie_status,
	':st_mollie_api' => $st_mollie_api,
	':st_enable_report_form' => $st_enable_report_form,
	':st_auto_approve_subsmission' => $st_auto_approve_subsmission,
	':st_auto_approve_update' => $st_auto_approve_update,
	':st_only_active_subscription' => $st_only_active_subscription,
	':st_login_verified_users_only' => $st_login_verified_users_only,
	':st_access_registered_only_exclusive' => $st_access_registered_only_exclusive,
	':st_access_registered_only' => $st_access_registered_only,
	':st_disable_registration' => $st_disable_registration,
	':st_cookie_consent' => $st_cookie_consent,
	':st_billing_company'  => $st_billing_company,
	':st_billing_invoice_prefix'  => $st_billing_invoice_prefix,
	':st_billing_address'  => $st_billing_address,
	':st_billing_country'  => $st_billing_country,
	':st_billing_city'  => $st_billing_city,
	':st_billing_postal'  => $st_billing_postal,
	':st_billing_phone'  => $st_billing_phone,
	':st_billing_vat'  => $st_billing_vat,
	':st_verification_email'  => $st_verification_email,
	':st_googleplay_app'  => $st_googleplay_app,
	':st_appstore_app'  => $st_appstore_app
	));

	header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{

header('Location: ./denied.php');		

}

}

$settings = get_settings();
$searchpages = get_pages_by_template('search');
$privacypages = get_pages_by_template('privacy');
$termspages = get_pages_by_template('terms');
$categoriespages = get_pages_by_template('categories');
$locationspages = get_pages_by_template('locations');
$storespages = get_pages_by_template('stores');
$contactpages = get_pages_by_template('contact');
$pricingpages = get_pages_by_template('pricing');

require '../views/settings.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>