<?php

require './core.php';

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $translation['tr_resetpage']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

$errors_reset = array();
$errors_update = array();
$success = '';
$validateEmail = false;
$validatePassword = false;
$fullHeight = true;

if (isset($_GET["key"]) && isset($_GET["email"])){

	if (isLogged()){

		header('Location: '. $urlPath->home());
		
	}else{

		$getKey = clearGetData($_GET["key"]);
		$getEmail = clearGetData($_GET["email"]);
		$currentDate = getDateByTimeZone();

		if (empty($getEmail)) {
			$errors_reset[] = $translation['tr_158'];
		} elseif (!filter_var($getEmail, FILTER_VALIDATE_EMAIL)) {
			$errors_reset[] = $translation['tr_163'];
		}else{
			$validateEmail = true;
		}

		if ($validateEmail) {
			
			$statement = $connect->prepare("SELECT * FROM tokens WHERE token_key = :token_key AND token_email = :token_email");
			$statement->execute(array(':token_key' => $getKey, ':token_email' => $getEmail));
			$result = $statement->fetch();

			if ($result == false) {

				$errors_reset[] = "Invalid Link";

			}else{

				if ($result['token_date'] >= $currentDate) {
					# code...
				}else{
					$errors_reset[] = "Link Expired";
				}

			}

		}

	}

}else{

	header('Location: '. $urlPath->home());
} // Validate Link

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$user_email = clearGetData($_GET["email"]);
	$new_password = filter_var($_POST["new_password"], FILTER_SANITIZE_STRING);
	$confirm_password = filter_var($_POST["confirm_password"], FILTER_SANITIZE_STRING);
	$encrtypted_password = hash('sha512', $new_password);
	$currentDate = getDateByTimeZone();

	if (empty($user_email)) {
		$errors_update[] = $translation['tr_158'];
	} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
		$errors_update[] = $translation['tr_163'];
	}else{
		$validateEmail = true;
	}

	if (empty($new_password) || empty($confirm_password)) {
		$errors_update[] = $translation['tr_160'];
	}elseif(!lengthInput($new_password, 8, 32) || !lengthInput($confirm_password, 8, 32)){
		$errors_update[] = $translation['tr_164'];
	}elseif($new_password != $confirm_password){
		$errors_update[] = $translation['tr_176'];
	}else{
		$validatePassword = true;
	}

	if (empty($errors_update) && empty($errors_reset) && $validateEmail && $validatePassword) {

		$statement = $connect->prepare("UPDATE users SET user_password = :user_password WHERE user_email = :user_email");
		$statement->execute(array(
			':user_email' => $user_email,
			':user_password' => $encrtypted_password
		));

		$sentence = $connect->prepare("DELETE FROM tokens WHERE token_email = :token_email");
		$sentence->execute(array('token_email' => $user_email));

		$userInfo = getUserInfoByEmail($user_email);

		$array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
			"{SITE_DOMAIN}" => $urlPath->home(), 
			"{SITE_NAME}" => $translation['tr_1'], 
			"{USER_NAME}" => $userInfo['user_name'], 
			"{USER_EMAIL}" => $userInfo['user_email'], 
			"{CONTACT_URL}" => $urlPath->contact(), 
			"{TERMS_URL}" => $urlPath->terms(), 
			"{PRIVACY_URL}" => $urlPath->privacy(),
			"{SIGNIN_URL}" => $urlPath->signin(),
			"{SIGNUP_URL}" => $urlPath->signup()
		);

		$emailTemplate = getEmailTemplate($connect, 3);

		if($emailTemplate){
		  
			$emailContent = json_decode($emailTemplate['email_content'],true);
	
			$mail = sendMail($array_content, $emailContent[0]['message'], $user_email, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
		
            if ($mail == 'TRUE') {

				$success = $translation['tr_175'];

			}else{

			$errors[] = $translation['tr_168']; 
		}

		}else{

				$errors[] = $translation['tr_168'];
			}

		}
	}

	require './header.php';
	require './views/reset.view.php';
	require './footer.php';

	?>