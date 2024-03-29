<?php

require '../core.php';
require './functions.php';

if (!isLogged()){
    header('Location: ./login.php');
    exit();
}

if(!isSeller()){
    header('Location: ./denied.php');
    exit();
}

    $validations = array();
    $errors = array();
    $success = array();

    $userProfile = getUserInfo();
    $userDetails = getUserInfoById($userProfile['user_id']);
    $planDetails = getPlanById($connect, $userDetails['user_plan']);
	$userTotalOUploaded = getTotalItemsByUser($userDetails['user_id']);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(!empty($planDetails)){

    // checking the limit of uploads

     if($userTotalOUploaded >= $planDetails['plan_total'] && $planDetails['plan_total'] != -1){
        
        $validations[] = $translation['tr_445'];
    }

    }

    // getting the data form
    
    $deal_author = clearGetData($_POST['deal_author']);
    $deal_title = clearGetData($_POST['deal_title']);
    $deal_description = $_POST['deal_description'];
    $deal_tagline = clearGetData($_POST['deal_tagline']);
    $deal_category = clearGetData($_POST['deal_category']);
    $deal_subcategory = clearGetData($_POST['deal_subcategory']);
    $deal_store = clearGetData($_POST['deal_store']);
    $deal_location = clearGetData($_POST['deal_location']);
    $deal_price = clearGetData($_POST['deal_price']);
    $deal_oldprice = clearGetData($_POST['deal_oldprice']);
    $deal_link = clearGetData($_POST['deal_link']);
    $deal_video = clearGetData($_POST['deal_video']);
    $deal_gif = clearGetData($_POST['deal_gif']);
    $deal_image = $_FILES["deal_image"]["name"];

    $deal_expire = "";
    
    if(isset($planDetails['plan_limit']) && $planDetails['plan_limit'] != -1){

        $datetime = getDateByTimeZone('Y-m-d H:i:s');
        $expiration_date = (new \DateTime($datetime))->modify('+' . $planDetails['plan_limit'] . ' days')->format('Y-m-d H:i:s');
        $deal_expire = $expiration_date;
    }

    $converted_slug = convertSlug(clearGetData($_POST['deal_title']));
    $exists = getDealSlug($converted_slug);

    if ($exists > 0){
        $new_number = $exists + 1;
        $slug = $converted_slug."-".$new_number;
    }else{
        $slug = $converted_slug;
    }

    // checking the expiration date of the user's subscription
    
    if (isExpiredSubscription()){

        $validations[] = $translation['tr_247'];

    }else{

    if(empty($deal_title) || empty($deal_category) || empty($deal_price) || empty($deal_link)){

        $validations[] = $translation['tr_302'];
    }
    
    $image = [
        'deal_image' => isset($_FILES['deal_image']['name']) && !empty($_FILES['deal_image']['name'])
    ];

    $uploadedImages = [];

    foreach(['deal_image'] as $image_key) {

        if($image[$image_key]) {

            $file_name = $_FILES[$image_key]['name'];
            $file_size = $_FILES[$image_key]['size'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_temp = $_FILES[$image_key]['tmp_name'];
            $file_info = getimagesize($file_temp);
            $width = $file_info[0];
            $height = $file_info[1];

            if(!in_array($file_extension, allowedFileExt())) {

                $validations[] = $translation['tr_192'];
    
            }else if ($file_size > allowedFileSize()) {
    
                $validations[] = $translation['tr_193'];

            }else if($width > "1024" || $height > "650") {

                $validations[] = $translation['tr_194'];
                
            }

            if(empty($validations)){

                $image_new_name = md5(time() . rand()) . '.' . $file_extension;
                move_uploaded_file($file_temp, $target_dir . $image_new_name);
                $uploadedImages += [$image_key => $image_new_name];

            }

        }

    }

    if(strlen($deal_title) > 100){

        $validations[] = $translation['tr_310'];
    }

    if(strlen($deal_tagline) > 200){

        $validations[] = $translation['tr_311'];
    }

    if(!is_numeric($deal_price)){

        $validations[] = $translation['tr_303'];
    }

    if($deal_price >= 10000 || $deal_oldprice >= 10000){

        $validations[] = $translation['tr_304'].' '.getPrice('10000');
    }

    if(!empty($deal_oldprice)){
        if($deal_price >= $deal_oldprice){
            $validations[] = $translation['tr_305'];
    }

    }

    if(empty($validations)){
        
        $statment = $connect->prepare("INSERT INTO deals (
            deal_id,
            deal_title,
            deal_slug,
            deal_description,
            deal_tagline,
            deal_category,
            deal_subcategory,
            deal_store,
            deal_location,
            deal_status,
            deal_author,
            deal_price,
            deal_oldprice,
            deal_link,
            deal_video,
            deal_gif,
            deal_expire,
            deal_created,
            deal_image) VALUES (
            null,
            :deal_title,
            :deal_slug,
            :deal_description,
            :deal_tagline,
            :deal_category,
            :deal_subcategory,
            :deal_store,
            :deal_location,
            :deal_status,
            :deal_author,
            :deal_price,
            :deal_oldprice,
            :deal_link,
            :deal_video,
            :deal_gif,
            :deal_expire,
            :deal_created,
            :deal_image)");

            $statment->execute(array(
            ':deal_title' => $deal_title,
            ':deal_slug' => $slug,
            ':deal_description' => $deal_description,
            ':deal_tagline' => $deal_tagline,
            ':deal_category' => $deal_category,
            ':deal_subcategory' => $deal_subcategory,
            ':deal_store' => $deal_store,
            ':deal_location' => $deal_location,
            ':deal_status' => $settings['st_auto_approve_subsmission'] == 1 ? 1 : 3,
            ':deal_author' => $deal_author,
            ':deal_price' => $deal_price,
            ':deal_oldprice' => $deal_oldprice,
            ':deal_link' => $deal_link,
            ':deal_video' => $deal_video,
            ':deal_gif' => $deal_gif,
            ':deal_expire' => ($deal_expire ? $deal_expire : ""),
            ':deal_created' => getDateByTimeZone(),
			':deal_image' => $uploadedImages['deal_image']
            ));

        $success[] = ($settings['st_auto_approve_subsmission'] == 1 ? $translation['tr_308'] : $translation['tr_309']);

		// Start Gallery Upload
            
        $idItem = $connect->lastInsertId();
        unset($temp);
        $statment->bindParam(':item', $idItem);
        
        $FileUploader = new FileUploader('files', array(
            'uploadDir' => '../images/',
            'title' => 'auto',
            'limit' => 8,
            'fileMaxSize' => 1,
            'extensions' => ['jpg', 'jpeg', 'png'],
            'replace' => true,
            ));
        
        $data = $FileUploader->upload();
        
        if($data['isSuccess'] && count($data['files']) > 0) {
            
            $uploadedFiles = $data['files'];
    
            $statment = $connect->prepare("INSERT INTO deals_gallery (id, item, picture, status, created) VALUES (null, :item, :picture, :status, CURRENT_TIMESTAMP)");
            
            foreach ($uploadedFiles as $key => $value){
                $statment->execute(array(
                    ':item' => $idItem,
                    ':picture' => $value['name'],
                    ':status' => ($settings['st_auto_approve_subsmission'] == 1 ? 1 : 0)
                ));
            }
            
        }else{
            // print_r($data);
        }

        $statement = connect()->prepare("INSERT INTO submissions_log (id,item,author_id,author_message,reviewer_message,reviewer_id,log_type,created) VALUES (null, :item, :author_id, :author_message, :reviewer_message, :reviewer_id, :log_type, :created)");
        $statement->execute(array(
            ':item' => $idItem,
            ':author_id' => $deal_author,
            ':author_message' => null,
            ':reviewer_message' => null,
            ':reviewer_id' => null,
            ':log_type' => "new",
            ':created' => getDateByTimeZone()
        ));

    }

    // send email to admin if there no errors
     
    if(empty($errors) && empty($validations)){

    $array_content = array(
    "{LOGO_URL}" => $urlPath->image($theme['th_logo']),
    "{SITE_DOMAIN}" => $urlPath->home(), 
    "{SITE_NAME}" => $translation['tr_1'], 
    "{USER_ID}" => $deal_author, 
    "{USER_NAME}" => $userDetails['user_name'], 
    "{USER_EMAIL}" => $userDetails['user_email'], 
    "{USER_PHONE}" => NULL, 
    "{USER_MESSAGE}" => NULL, 
	"{PLAN_ID}" => NULL,
	"{PLAN_TITLE}" => NULL,
	"{PLAN_FREQUENCY}" => NULL,
	"{PAYMENT_ID}" => NULL,
	"{PAYMENT_METHOD}" => NULL,
	"{PAYMENT_BASE_AMOUNT}" => NULL,
	"{PAYMENT_DISCOUNT_AMOUNT}" => NULL,
	"{PAYMENT_TOTAL_AMOUNT}" => NULL,
	"{PAYMENT_CODE}" => NULL,
	"{PAYMENT_CURRENCY}" => NULL,
	"{ITEM_ID}" => $idItem,
	"{ITEM_TITLE}" => $deal_title,
	"{ITEM_IMAGE}" => $urlPath->image($deal_image),
	"{ITEM_URL}" => $urlPath->deal($idItem, $slug),
	"{RESET_URL}" => NULL,
    "{TERMS_URL}" => $urlPath->terms(), 
    "{PRIVACY_URL}" => $urlPath->privacy(),
    "{SIGNIN_URL}" => $urlPath->signin(),
    "{CONTACT_URL}" => $urlPath->contact(),
    );

    $emailTemplate = getEmailTemplate($connect, 6);

    if ($emailTemplate) {
    
        $emailContent = json_decode($emailTemplate['email_content'],true);
    
        $mail = sendMail($array_content, $emailContent[0]['message'], $settings['st_recipientemail'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
    }

    }

}

    echo json_encode(array('validations' => $validations, 'errors' => $errors, 'success' => $success));

    }

?>