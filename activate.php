<?php

require './core.php';

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

$errors = array();
$success = '';
$fullHeight = true;
$validateEmail = false;
$validateCode = false;

if (!clearGetData($_GET['email']) && !clearGetData($_GET['activation_code'])){

	header('Location: '. $urlPath->home());
	
}else{

	$user_email = clearGetData($_GET['email']);
	$activation_code = clearGetData($_GET['activation_code']);

	if(empty($user_email)) {
		$errors[] = $translation['tr_158'];
	} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = $translation['tr_163'];
	}else{
		$validateEmail = true;
	}

	if(empty($activation_code)) {
		$errors[] = $translation['tr_336'];
	}else{
		$validateCode = true;
	}

	if($validateEmail && $validateCode){

		// check if user account exist

		$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email LIMIT 1");
		$statement->execute(array(':user_email' => $user_email));
		$result = $statement->fetch();

		if ($result == false) {
		  
			$errors[] = $translation['tr_172'];
		
		}

		// check if user email already verified

		$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_verified = 1 LIMIT 1");
		$statement->execute(array(':user_email' => $user_email));
		$result = $statement->fetch();

		if ($result != false) {
		  
			$errors[] = $translation['tr_337'];
		
		}

		// check if activation code is valid

		$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_activation_code = :user_activation_code AND user_activation_expire > NOW() LIMIT 1");
		$statement->execute(array(':user_email' => $user_email, ':user_activation_code' => $activation_code));
		$result = $statement->fetch();

		if ($result == false) {
		  
			$errors[] = $translation['tr_338'];
		
		}

		if(empty($errors)){

			// activate account

			$statement = $connect->prepare("UPDATE users SET user_verified = :user_verified, user_activation_at = CURRENT_TIMESTAMP WHERE user_email = :user_email AND user_activation_code = :user_activation_code AND user_activation_expire > NOW() LIMIT 1");
			$statement->execute(array(
				':user_verified' => 1,
				':user_email' => $user_email,
				':user_activation_code' => $activation_code
			));

			$userInfo = getUserInfoByEmail($user_email);
		  
			$array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
								   "{SITE_DOMAIN}" => $urlPath->home(), 
								   "{SITE_NAME}" => $translation['tr_1'], 
								   "{USER_NAME}" => $userInfo['user_name'], 
								   "{USER_EMAIL}" => $userInfo['user_email'], 
								   "{TERMS_URL}" => $urlPath->terms(), 
								   "{PRIVACY_URL}" => $urlPath->privacy(),
								   "{SIGNIN_URL}" => $urlPath->signin()
									);
			
				$emailTemplate = getEmailTemplate($connect, 13);
			
				if($emailTemplate){
			
					$emailContent = json_decode($emailTemplate['email_content'],true);
			
					$mail = sendMail($array_content, $emailContent[0]['message'], $user_email, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
				}

			$success .= true;

		}
	
	}

}

require './header.php';
require './views/activate.view.php';
require './footer.php';

?>