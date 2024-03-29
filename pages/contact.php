<?php

$errors = array();
$fullHeight = true;
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    

	$contactName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$contactPhone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
	$contactMessage = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
	$contactEmail = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_EMAIL);
    $isChecked = (isset($_POST['ischecked']) ? $_POST['ischecked'] : null);

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

        if (empty($contactName)) {
            $errors[] = $translation['tr_159'];
        }

        if (empty($contactEmail)) {
            $errors[] = $translation['tr_158'];
        } elseif (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = $translation['tr_163'];
        }

        if (empty($contactMessage)) {
            $errors[] = $translation['tr_169'];
        }

        if (!$isChecked) {
            $errors[] = $translation['tr_173'];
        }

        if(empty($errors)) {

        $array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
                               "{SITE_DOMAIN}" => $urlPath->home(), 
                               "{SITE_NAME}" => $translation['tr_1'], 
                               "{USER_NAME}" => $contactName, 
                               "{USER_PHONE}" => $contactPhone, 
                               "{USER_EMAIL}" => $contactEmail, 
                               "{USER_MESSAGE}" => $contactMessage
                                );

        $emailTemplate = getEmailTemplate($connect, 11);

        if ($emailTemplate) {

            $emailContent = json_decode($emailTemplate['email_content'],true);

            $mail = sendMail($array_content, $emailContent[0]['message'], $settings['st_recipientemail'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);

            if ($mail == TRUE) {

				$success = $translation['tr_170'];

            }else{

                $errors[] = $translation['tr_168'];
            }

        }else{
                
                $errors[] = $translation['tr_168'];
        }

      }
}

require './pages/views/contact.view.php';

?>