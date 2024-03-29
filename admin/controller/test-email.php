<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){

$output = "";
$theme = get_theme();

if(check_permission('edit_etemplates')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $idtemplate = cleardata($_POST["idtemplate"]);
	$sendto = filter_var($_POST["sendto"], FILTER_SANITIZE_EMAIL);

    $emailTemplate = getEmailTemplate($idtemplate);
    $settings = get_settings();
    $checkMail = checkMail($settings);

    $array_content = array("{LOGO_URL}" => SITE_URL."/images/".$theme['th_logo'],
     "{SITE_DOMAIN}" => SITE_URL, 
     "{SITE_NAME}" => "Test Site Name", 
     "{USER_NAME}" => "Test Name", 
     "{USER_EMAIL}" => "example@email.com", 
     "{USER_MESSAGE}" => cleardata("This is an example message."),
     "{PRIVACY_URL}" => SITE_URL."/terms-and-conditions",
     "{TERMS_URL}" => SITE_URL."/privacy-policy",
     "{SIGNIN_URL}" => SITE_URL."/signin",
     "{RESET_URL}" => SITE_URL."/forgot",
     "{SENDER_NAME}" => "Sender Name", 
     "{SENDER_EMAIL}" => "sender@example.com",
     "{FRIEND_EMAIL}" => "friend@example.com"
 );

    if ($emailTemplate) {

        $emailContent = json_decode($emailTemplate['email_content'],true);

        try{        

            if(empty($checkMail)) {

            $mail = sendMail($array_content, $emailContent[0]['message'], $sendto, $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext'], $settings);

            if($mail == TRUE) {
                $output = "<span class='text-success'><i class='fa fa-check'></i> "._EMAILSENTSUCCESS."</span>";
                echo $output;
            }else{

                $output = $mail;
                echo "<span class='text-danger'>".$output."</span";
            }

            }else{

                $output = $checkMail;
                echo "<span class='text-danger'>".$output."</span";
            }

            
        }catch (PDOException $e){
            
            $output = $e->getMessage();
            echo "<span class='text-danger'>".$output."</span";

        }

    }

}

}else{

	header('Location: ./denied.php');		

}

}else {

	header('Location:'.SITE_URL);
}

?>