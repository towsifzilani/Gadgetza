<?php

require './core.php';

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

$errors = array();
$verifiedAlready = '';
$success = '';
$fullHeight = true;
$validateEmail = false;

if (!clearGetData($_GET['user'])){

	header('Location: '. $urlPath->home());
	
}else{

	$user_email = clearGetData($_GET['user']);

	if(empty($user_email)) {
		$errors[] = $translation['tr_158'];
	} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = $translation['tr_163'];
	}else{
		$validateEmail = true;
	}

	if($validateEmail){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			$user_email = filter_var(strtolower($_POST['user_email']), FILTER_SANITIZE_EMAIL);

			// check if user has an active request
			
			$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_activation_expire > NOW() LIMIT 1");
			$statement->execute(array(':user_email' => $user_email));
			$result = $statement->fetch();
	
			if ($result != false) {
			  
				$errors[] = $translation['tr_334'];

			}

			if(empty($errors)) {

				$activation_code = md5($user_email . microtime());
				$expiry = 1 * 24 * 60 * 60; // 1 Day
				$activation_expire = date('Y-m-d H:i:s',  time() + $expiry);
		  
				$statement = $connect->prepare("UPDATE users SET user_activation_code = :user_activation_code, user_activation_expire = :user_activation_expire WHERE user_email = :user_email");
		  
				$statement->execute(array(
					':user_email' => $user_email,
					':user_activation_code' => $activation_code,
					':user_activation_expire' => $activation_expire
			  ));
		  
		  $userInfo = getUserInfoByEmail($user_email);
		  
		  $array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
								 "{SITE_DOMAIN}" => $urlPath->home(), 
								 "{SITE_NAME}" => $translation['tr_1'], 
								 "{USER_NAME}" => $userInfo['user_name'], 
								 "{USER_EMAIL}" => $userInfo['user_email'], 
								 "{TERMS_URL}" => $urlPath->terms(), 
								 "{PRIVACY_URL}" => $urlPath->privacy(),
								 "{SIGNIN_URL}" => $urlPath->signin(),
								 "{ACTIVATION_CODE}" => $activation_code,
								 "{ACTIVATION_EXPIRE}" => $activation_expire,
								 "{ACTIVATION_URL}" => $urlPath->activate(['email' => $user_email, 'activation_code' => $activation_code])
								  );
		  
		  	$emailTemplate = getEmailTemplate($connect, 12);
		  
			  if($emailTemplate){
		  
				  $emailContent = json_decode($emailTemplate['email_content'],true);
		  
				  $mail = sendMail($array_content, $emailContent[0]['message'], $user_email, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
			  }
		  
			 	 $success .= $translation['tr_335'];
		  
			 }

		}else{

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
		  
		  $verifiedAlready .= true;
		
		}

		if(isLogged()){

		$loggedUser = getUserInfo();

		// check if the logged in user is the same
		
		if($user_email != $loggedUser['user_email']){

			header('Location: '. $urlPath->error());

		}

		// check if user has an active request

		$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_activation_expire > NOW() LIMIT 1");
		$statement->execute(array(':user_email' => $user_email));
		$result = $statement->fetch();

		if ($result == false) {

		$activation_code = md5($user_email . microtime());
		$expiry = 1 * 24 * 60 * 60; // 1 Day
		$activation_expire = date('Y-m-d H:i:s',  time() + $expiry);

		$statement = $connect->prepare("UPDATE users SET user_activation_code = :user_activation_code, user_activation_expire = :user_activation_expire WHERE user_email = :user_email");

		$statement->execute(array(
		':user_email' => $user_email,
		':user_activation_code' => $activation_code,
		':user_activation_expire' => $activation_expire
		));

		$userInfo = getUserInfoByEmail($user_email);

		$array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
			"{SITE_DOMAIN}" => $urlPath->home(), 
			"{SITE_NAME}" => $translation['tr_1'], 
			"{USER_NAME}" => $userInfo['user_name'], 
			"{USER_EMAIL}" => $userInfo['user_email'], 
			"{TERMS_URL}" => $urlPath->terms(), 
			"{PRIVACY_URL}" => $urlPath->privacy(),
			"{SIGNIN_URL}" => $urlPath->signin(),
			"{ACTIVATION_CODE}" => $activation_code,
			"{ACTIVATION_EXPIRE}" => $activation_expire,
			"{ACTIVATION_URL}" => $urlPath->activate(['email' => $user_email, 'activation_code' => $activation_code])
			);

		$emailTemplate = getEmailTemplate($connect, 12);

		if($emailTemplate){

		$emailContent = json_decode($emailTemplate['email_content'],true);

		$mail = sendMail($array_content, $emailContent[0]['message'], $user_email, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
		
		}

		$success .= $translation['tr_335'];

		}

		}
	
		}
		
	}

}

require './header.php';
require './views/verify.view.php';
require './footer.php';

?>