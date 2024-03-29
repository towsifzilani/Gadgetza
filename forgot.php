<?php

require './core.php';

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $translation['tr_forgotpage']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

$errors = array();
$validateEmail = false;
$fullHeight = true;
$success = '';

if (isLogged()){

	header('Location: '. $urlPath->home());

}else{

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        

		$user_email = filter_var(strtolower($_POST['user_email']), FILTER_SANITIZE_EMAIL);

		if($settings['st_recaptcha_enable'] == 1){

			$siteKey = $settings['st_recaptchakey'];
			$secretKey = $settings['st_recaptchasecretkey'];
			
			$verifyCaptcha = $_POST['g-recaptcha-response'];
	
			$recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$verifyCaptcha";
	
			$verify = json_decode(file_get_contents($recaptchaUrl));

			if(!$verify->success){
				$errors[] = $translation['tr_161'];
			}

		}

			if (empty($user_email)) {
				$errors[] = $translation['tr_158'];
			} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$errors[] = $translation['tr_163'];
			}else{
				$validateEmail = true;
			}

			if ($validateEmail) {

				try{        

				}catch (PDOException $e){

					$errors[] = $e->getMessage();   
				}

				$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email LIMIT 1");
				$statement->execute(array(':user_email' => $user_email));
				$result = $statement->fetch();

				if ($result == false) {

					$errors[] = $translation['tr_166'];

				}else{

					$currentDate = date("Y-m-d H:i:s");

					try{  // check if user already requested a new password      

					}catch (PDOException $e){

						$errors[] = $e->getMessage();   
					}

					$state = $connect->prepare("SELECT * FROM tokens WHERE token_email = :token_email");
					$state->execute(array(':token_email' => $user_email));
					$check = $state->fetch();

					if($check != false){

						if ($check['token_date'] >= $currentDate) {
						
						$errors[] = $translation['tr_177'];

						}
					}

	}
}

if (empty($errors)) {

	$dateFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
	$token_date = date("Y-m-d H:i:s", $dateFormat);
	$token_key = hash('sha512', 2418*2 . $user_email);
	$generateKey = substr(hash('sha512', uniqid(rand(),1)),3,10);
	$token_key = $token_key . $generateKey;

	$statement = $connect->prepare("INSERT INTO tokens (token_email, token_key, token_date) VALUES (:token_email, :token_key, :token_date)");
	$statement->execute(array(
		':token_email' => $user_email,
		':token_key' => $token_key,
		':token_date' => $token_date
	));

	try {

		$userInfo = getUserInfoByEmail($user_email);

		$array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
			"{SITE_DOMAIN}" => $urlPath->home(), 
			"{SITE_NAME}" => $translation['tr_1'], 
			"{USER_NAME}" => $userInfo['user_name'], 
			"{USER_EMAIL}" => $userInfo['user_email'], 
			"{RESET_URL}" => $urlPath->reset(['email' => $user_email, 'key' => $token_key])
		);

		$emailTemplate = getEmailTemplate($connect, 2);

		if ($emailTemplate) {

			$emailContent = json_decode($emailTemplate['email_content'],true);

			$mail = sendMail($array_content, $emailContent[0]['message'], $user_email, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);

            if ($mail == 'TRUE') {

				$success = $translation['tr_167'];

            }else{

				$errors[] = $translation['tr_168']; // Something Wrong

            }

		}else{

			$errors[] = $translation['tr_168']; // Something Wrong

            }


	} catch (Exception $e) {

$errors[] = $translation['tr_168']; // Something Wrong

			}
		}
	}
}

require './header.php';
require './views/forgot.view.php';
require './footer.php';

?>