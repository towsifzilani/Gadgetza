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

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // getting the data form
    
    $deal_author = clearGetData($_POST['deal_author']);
    $deal_id = clearGetData($_POST['deal_id']);
    $deal_title = clearGetData($_POST['deal_title']);
    $deal_slug = clearGetData($_POST['deal_slug']);
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
    $author_message = $_POST['author_message'];

    $userPlanSettings = getPlanById($connect, clearGetData($_POST['user_plan']));

    if(!empty($userPlanSettings)){

        if($userPlanSettings['plan_limit'] == -1 || $userPlanSettings['plan_limit'] == 0){
            $deal_expire = "";
        }else{
            $deal_expire = clearGetData($_POST['deal_expire']);
        }

    }else{

        $deal_expire = clearGetData($_POST['deal_expire']);

    }

    // checking the expiration date of the user's subscription
    
    if (isExpiredSubscription()){

        $validations[] = $translation['tr_247'];

    }else{

        // check if the user does not have another edition in drafts

    if($settings['st_auto_approve_update'] == 0){

        $statement = $connect->prepare("SELECT * FROM drafts WHERE deal_id = :deal_id LIMIT 1");
        $statement->execute(array(':deal_id' => $deal_id));
        $result = $statement->fetch();
    
        if($result != false) {
        
        $errors[] = $translation['tr_301'];

        }
    
    }
    
    if(empty($errors)){

    if(empty($deal_id) || empty($deal_title) || empty($deal_category) || empty($deal_price) || empty($deal_link) || empty($author_message)){

        $validations[] = $translation['tr_302'];
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

    if($deal_price >= 10000 ||$deal_oldprice >= 10000){

        $validations[] = $translation['tr_304'].' '.getPrice('10000');
    }

    if(!empty($deal_oldprice)){
        if($deal_price >= $deal_oldprice){
            $validations[] = $translation['tr_305'];
    }

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

    if(empty($validations)){

    // check if the update should be approved automatically

    if($settings['st_auto_approve_update'] == 1){

        $statment_auto = $connect->prepare("UPDATE deals SET
        deal_id = :deal_id,
        deal_title = :deal_title,
        deal_description = :deal_description,
        deal_tagline = :deal_tagline,
        deal_category = :deal_category,
        deal_subcategory = :deal_subcategory,
        deal_store = :deal_store,
        deal_location = :deal_location,
        deal_price = :deal_price,
        deal_oldprice = :deal_oldprice,
        deal_link = :deal_link,
        deal_video = :deal_video,
        deal_gif = :deal_gif,
        deal_expire = :deal_expire,
        deal_image = :deal_image
        WHERE deal_id = :deal_id AND deal_author = :deal_author");

        $statment_auto->execute(array(
            ':deal_id' => $deal_id,
            ':deal_author' => $deal_author,
            ':deal_title' => $deal_title,
            ':deal_description' => $deal_description,
            ':deal_tagline' => $deal_tagline,
            ':deal_category' => $deal_category,
            ':deal_subcategory' => $deal_subcategory,
            ':deal_store' => $deal_store,
            ':deal_location' => $deal_location,
            ':deal_price' => $deal_price,
            ':deal_oldprice' => $deal_oldprice,
            ':deal_link' => $deal_link,
            ':deal_video' => $deal_video,
            ':deal_gif' => $deal_gif,
            ':deal_expire' => $deal_expire,
		    ':deal_image' => (isset($uploadedImages['deal_image']) ? $uploadedImages['deal_image'] : $_POST['deal_image_save'])
        ));

        $success[] = $translation['tr_373'];

    }else{

        $statment = $connect->prepare("INSERT INTO drafts (deal_id, deal_author, deal_title, deal_description, deal_tagline, deal_category, deal_subcategory, deal_store, deal_location, deal_price, deal_oldprice, deal_link, deal_slug, deal_video, deal_gif, deal_expire, deal_image)
        VALUES (:deal_id, :deal_author, :deal_title, :deal_description, :deal_tagline, :deal_category, :deal_subcategory, :deal_store, :deal_location, :deal_price, :deal_oldprice, :deal_link, :deal_slug, :deal_video, :deal_gif, :deal_expire, :deal_image)");

        $statment->execute(array(
            ':deal_id' => $deal_id,
            ':deal_author' => $deal_author,
            ':deal_title' => $deal_title,
            ':deal_description' => $deal_description,
            ':deal_tagline' => $deal_tagline,
            ':deal_category' => $deal_category,
            ':deal_subcategory' => $deal_subcategory,
            ':deal_store' => $deal_store,
            ':deal_location' => $deal_location,
            ':deal_price' => $deal_price,
            ':deal_oldprice' => $deal_oldprice,
            ':deal_link' => $deal_link,
            ':deal_slug' => $deal_slug,
            ':deal_video' => $deal_video,
            ':deal_gif' => $deal_gif,
            ':deal_expire' => $deal_expire,
		    ':deal_image' => (isset($uploadedImages['deal_image']) ? $uploadedImages['deal_image'] : $_POST['deal_image_save'])
        ));

        $statement = connect()->prepare("INSERT INTO submissions_log (id,item,author_id,author_message,reviewer_message,reviewer_id,log_type,created) VALUES (null, :item, :author_id, :author_message, :reviewer_message, :reviewer_id, :log_type, :created)");
        $statement->execute(array(
            ':item' => $deal_id,
            ':author_id' => $deal_author,
            ':author_message' => $author_message,
            ':reviewer_message' => null,
            ':reviewer_id' => null,
            ':log_type' => "update",
            ':created' => getDateByTimeZone()
        ));

        $success[] = $translation['tr_374'];
        
    }

    }

    $totalCount = count(getGalleryByItem($connect, $deal_id));
    
	$FileUploader = new FileUploader('files', array(
		'uploadDir' => $target_dir,
		'title' => 'auto',
		'limit' => (8-$totalCount),
		'fileMaxSize' => (allowedFileSize()/1024/1024),
		'extensions' => allowedFileExt(),
		'replace' => true
		));
    
    $data = $FileUploader->upload();
    
    if($data['isSuccess'] && count($data['files']) > 0) {
        
        $uploadedFiles = $data['files'];

        $statment = $connect->prepare("INSERT INTO deals_gallery (id, item, picture, status, created) VALUES (null, :item, :picture, :status, CURRENT_TIMESTAMP)");
        
        foreach ($uploadedFiles as $key => $value){
            $statment->execute(array(
                ':item' => $deal_id,
                ':picture' => $value['name'],
                ':status' => ($settings['st_auto_approve_update'] == 1 ? 1 : 0)
            ));
        }
    }else{
        // print_r($data);
    }

    }

    // send email to admin if there no errors
     
    if(empty($errors) && empty($validations)){
    
    $userProfile = getUserInfo();
    $userDetails = getUserInfoById($userProfile['user_id']);

    $array_content = array(
    "{LOGO_URL}" => $urlPath->image($theme['th_logo']),
    "{SITE_DOMAIN}" => $urlPath->home(), 
    "{SITE_NAME}" => $translation['tr_1'], 
    "{USER_ID}" => $deal_author, 
    "{USER_NAME}" => $userDetails['user_name'], 
    "{USER_EMAIL}" => $userDetails['user_email'], 
	"{ITEM_ID}" => $deal_id,
	"{ITEM_TITLE}" => $deal_title,
	"{ITEM_IMAGE}" => $urlPath->image((isset($uploadedImages['deal_image']) ? $uploadedImages['deal_image'] : $_POST['deal_image_save'])),
	"{ITEM_URL}" => $urlPath->deal($deal_id, $deal_slug),
	"{REVIEW_MESSAGE}" => null,
    "{TERMS_URL}" => $urlPath->terms(), 
    "{PRIVACY_URL}" => $urlPath->privacy(),
    "{SIGNIN_URL}" => $urlPath->signin(),
    "{CONTACT_URL}" => $urlPath->contact(),
    );

   $emailTemplate = getEmailTemplate($connect, 7);

    if ($emailTemplate) {
    
        $emailContent = json_decode($emailTemplate['email_content'], true);
    
        $mail = sendMail($array_content, $emailContent[0]['message'], $settings['st_recipientemail'], $emailTemplate['email_fromname'], $emailContent[0]['subject'], $emailTemplate['email_plaintext']);
    }

    }

}

echo json_encode(array('validations' => $validations, 'errors' => $errors, 'success' => $success));

    }

?>