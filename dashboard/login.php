<?php

require '../core.php';

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $translation['tr_signinpage']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

$errors = array();
$validateEmail = false;
$validatePassword = false;

$fullHeight = true;

if (isLogged()){

	header('Location: '. $urlPath->home());
	
}else{

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

		$user_email = filter_var(strtolower($_POST['user_email']), FILTER_SANITIZE_EMAIL);
		$user_password = filter_var($_POST["user_password"], FILTER_SANITIZE_STRING);
		$encrtypted_password = hash('sha512', $user_password);
		
		if (empty($user_email)) {
			$errors[] = $translation['tr_158'];
		} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = $translation['tr_163'];
		}else{
			$validateEmail = true;
		}

		if (empty($user_password)) {
			$errors[] = $translation['tr_160'];
		}else{
			$validatePassword = true;
		}

		if ($validatePassword && $validateEmail) {

				try{        
				
					$connect;
					
				}catch (PDOException $e){
					$errors[] = $translation['tr_168'];
				}
	
				$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_status = 1");
				$statement->execute(array(':user_email' => $user_email));
				$result = $statement->fetch();
	
				if ($result == false) {
					
					$errors[] = $translation['tr_172'];
					
				}

				if($settings['st_login_verified_users_only'] == 1){
		
					$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_verified = 1");
					$statement->execute(array(':user_email' => $user_email));
					$result = $statement->fetch();
		
					if ($result == false) {
						
						$errors[] = $translation['tr_352'];
						
					}
					
				}

		}

		if (empty($errors)) {

			$statement = $connect->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_password AND user_status = 1");
			$statement->execute(array(
				':user_email' => $user_email,
				':user_password' => $encrtypted_password
				
			));
			
			$result_login = $statement->fetch();
			
			if ($result_login !== false){
				$_SESSION['signedin'] = true;
				$_SESSION['user_email'] = $user_email;
				$_SESSION['user_name'] = $result_login['user_name'];

				header('Location: home.php');
				
			}else{
				
				$errors[] = $translation['tr_174'];
			}

		}

	}

}

require './header.php';
require './views/login.view.php';
require './footer.php';

?>