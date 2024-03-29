<?php 


/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

session_start();

include('../../classes/csrf.php');
require '../../config.php';
require '../functions.php';

$csrf = new CSRF();

$errors = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$captcha = $_POST["captcha"];
$captchaUser = cleardata($_POST['captcha']);

if(isset($_SESSION['CAPTCHA_CODE']) && $_SESSION['CAPTCHA_CODE'] == $captchaUser){

if ($csrf->validate('login-token')) {

	$user_email = filter_var(strtolower($_POST['user_email']), FILTER_SANITIZE_EMAIL);
	$user_password = cleardata($_POST['user_password']);
	$password = hash('sha512', $user_password);

	try{        
	$connect;

	}catch (PDOException $e){

	echo "Error: ." . $e->getMessage();  

	}

	$statement = connect()->prepare("SELECT users.*, roles.* FROM users, roles WHERE users.user_role = roles.role_id AND roles.role_admin = 1 AND user_email = :user_email AND user_password = :user_password AND user_status = 1");
	
	$statement->execute(array(
	':user_email' => $user_email,
	':user_password' => $password
	));

	$result_login = $statement->fetch();

	if ($result_login !== false){

	$_SESSION['signedin'] = true;
	$_SESSION['user_email'] = $user_email;
	$_SESSION['user_name'] = $result_login['user_name'];

	header('Location: ./home.php');

	}else{

	$errors .= _LOGINACCESSDENIED;

	}

}else{

	$errors .= _LOGININVALIDTOKEN;
}

}else{

	$errors .= _LOGININVALIDCAPTCHA;
}

}
	  
require '../views/header.view.php';
require '../views/login.view.php';
require '../views/footer.view.php';

?>