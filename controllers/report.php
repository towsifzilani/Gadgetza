<?php 

require '../core.php';

if (!isLogged()){

    exit();

}else{

if($settings['st_enable_report_form'] == 1){

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $item_id = clearGetData($_POST['item_id']);
        $item_title = clearGetData($_POST['item_title']);
        $item_image = clearGetData($_POST['item_image']);
        $item_url = clearGetData($_POST['item_url']);
        $name = clearGetData($_POST['name']);
        $email = clearGetData($_POST['email']);
        $message = clearGetData($_POST['message']);
    
        if (empty($item_id) || empty($item_title) || empty($item_image) || empty($item_url) || empty($name) || empty($email) || empty($message)) {
          
            echo "<div class='uk-alert-danger uk-border-rounded' uk-alert> <p>".$translation['tr_191']."</p> </div>";
        
        }else{
    
            $array_content = array("{LOGO_URL}" => $urlPath->image($theme['th_logo']),
            "{SITE_DOMAIN}" => $urlPath->home(), 
            "{SITE_NAME}" => $translation['tr_1'], 
            "{CONTACT_URL}" => $urlPath->contact(), 
            "{TERMS_URL}" => $urlPath->terms(), 
            "{PRIVACY_URL}" => $urlPath->privacy(),
            "{SIGNIN_URL}" => $urlPath->signin(),
            "{SIGNUP_URL}" => $urlPath->signup(),
            "{USER_NAME}" => $name, 
            "{USER_EMAIL}" => $email, 
            "{USER_MESSAGE}" => $message,
            "{ITEM_ID}" => $item_id,
            "{ITEM_TITLE}" => $item_title,
            "{ITEM_IMAGE}" => $item_image,
            "{ITEM_URL}" => $item_url
             );
    
            $emailTemplate = getEmailTemplate($connect, 14);
    
            if ($emailTemplate) {

                echo "<div class='uk-alert-success uk-border-rounded' uk-alert> <p>".$translation['tr_350']."</p> </div>";
    
            /*$emailContent = json_decode($emailTemplate['email_content'],true);
    
            $mail = sendMail($array_content, $emailContent[0]['message'], $settings['st_recipientemail'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
    
            if ($mail == TRUE) {
    
                echo "<div class='uk-alert-success uk-border-rounded' uk-alert> <p>".$translation['tr_350']."</p> </div>";
    
            }else{
    
                echo "<div class='uk-alert-danger uk-border-rounded' uk-alert> <p>".$translation['tr_168']."</p> </div>";
    
            }*/
    
        }
    
    }
    
    }

}else{
    exit();
}

}

?>