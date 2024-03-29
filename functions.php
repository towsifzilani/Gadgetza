<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/classes/vendor/autoload.php';
require_once __DIR__ . '/classes/slugify.php';
require_once __DIR__ . '/classes/fileuploader.php';
require_once __DIR__ . '/classes/csrf.php';
require_once __DIR__ . '/admin/countries.php';

use voku\helper\AntiXSS;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Razorpay\Api\Api;
$csrf = new CSRF();

function connect(){

    global $database;

    try{
        $connect = new PDO('mysql:host='.$database['host'].';dbname='.$database['db'],$database['user'],$database['pass'], array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        return $connect;
        
    }catch (PDOException $e){
        return false;
    }
}

function isLogged(){

    if (isset($_SESSION['signedin']) && $_SESSION['signedin'] == true) {
        return true;
    }else{
        return false;
    }
}

function isAdmin(){

    if (isset($_SESSION['user_email'])) {

        $userEmail = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_EMAIL);

        $sentence = connect()->prepare("SELECT users.user_email, users.user_role, roles.role_admin FROM users, roles WHERE users.user_role = roles.role_id AND users.user_email = :email"); 
        $sentence->execute(array(
            ":email" => $userEmail
        ));

        $row = $sentence->fetch();

        if($row['role_admin'] == 1){
            return true;
        }else{
            return false;
        }

    }else{
        return false;
    }

}

function isExclusive($value){
    
    if($value == 1){
        return true;
    }else{
        return false;
    }
}

function isVerified($value){
    
    if($value == 1){
        return true;
    }else{
        return false;
    }
}

function isEditing(){
    
    return isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'edit';
}

function isFavorites(){
    
    return isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'favorites';
}

function echoOutput($data){
    $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
    return $data;
}

function textTruncate($data, $chars) {
    if(strlen($data) > $chars) {
        $data = $data.' ';
        $data = substr($data, 0, $chars);
        $data = $data.'...';
    }
    return $data;
}

function echoNoHtml($data){
    $data = strip_tags($data);
    $data = htmlentities($data, ENT_QUOTES, "UTF-8");
    $data = substr($data, 0, 255);
    return $data;
}

function clearGetData($data){

    $antiXss = new AntiXSS();
    $data = $antiXss->xss_clean($data);
    return $data;
}

function lengthInput($data, $min, $max = NULL){

    $characters = strlen($data);
    $spaces = preg_match('/\s/',$data);

    if ($max) {
        if ($characters >= $min && $characters <= $max && !$spaces) {
            return true;
        }else{
            return false;
        }
    }else{

        if ($characters >= $min && !$spaces) {
            return true;
        }else{
            return false;
        }
    }
}

function validateInput($data){

    $specialChars = preg_match('@[^\w]@', $data);

    if ($specialChars) {
        return true;
    }else{
        return false;
    }
}

function getCurrentUrl() {
    // Check if the request is using HTTPS
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    // Get the protocol
    $protocol = $isSecure ? 'https://' : 'http://';
    
    // Get the server name
    $serverName = $_SERVER['SERVER_NAME'];
    
    // Get the request URI
    $requestUri = $_SERVER['REQUEST_URI'];
    
    // Combine the components to get the current URL
    $currentUrl = $protocol . $serverName . $requestUri;
    
    return ltrim($requestUri, '/');
}

function getCurrentPageSlug(){
    
    return isset($_GET['slug']) && !empty($_GET['slug']) ? clearGetData($_GET['slug']) : NULL;
}

function getNumPage(){
    
    return isset($_GET['p']) && !empty($_GET['p']) && (int)$_GET['p'] ? clearGetData($_GET['p']) : 1;
}

function getItemId(){
    
    return isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : NULL;
}

function getFilterParam(){
    
    return isset($_GET['filter']) && !empty($_GET['filter']) && $_GET['filter'] ? clearGetData($_GET['filter']) : NULL;
}

function getIDCategory(){
    
    return isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] ? clearGetData($_GET['category']) : NULL;
}

function getIDLocation(){
    
    return isset($_GET['location']) && !empty($_GET['location']) && $_GET['location'] ? clearGetData($_GET['location']) : NULL;
}

function getIDStore(){
    
    return isset($_GET['store']) && !empty($_GET['store']) && $_GET['store'] ? clearGetData($_GET['store']) : NULL;
}

function getIDRating(){
    
    return isset($_GET['rating']) && !empty($_GET['rating']) && $_GET['rating'] ? clearGetData($_GET['rating']) : NULL;
}

function getIDPrice(){
    
    return isset($_GET['price']) && !empty($_GET['price']) && $_GET['price'] ? clearGetData($_GET['price']) : NULL;
}

function getIDSubCategory(){
    
    return isset($_GET['subcategory']) && !empty($_GET['subcategory']) && $_GET['subcategory'] ? clearGetData($_GET['subcategory']) : NULL;
}

function getIDUser(){
    
    return isset($_GET['user']) && !empty($_GET['user']) && $_GET['user'] ? clearGetData($_GET['user']) : NULL;
}

function getTypeData(){
    
    return isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] ? clearGetData($_GET['type']) : NULL;
}

function getSortBy($value){

   if (isset($_GET['sortby']) && $_GET['sortby'] === $value) {
       
       return "value = '$value' selected";
   }

   return "value = '$value'";
}

function getSlugItem(){
    
    return isset($_GET['slug']) && !empty($_GET['slug']) && $_GET['slug'] ? clearGetData($_GET['slug']) : NULL;
}

function getSearchQuery(){
    
    return isset($_GET['query']) && !empty($_GET['query']) && $_GET['query'] ? clearGetData($_GET['query']) : NULL;
}

function getSlugCategory(){
    
    return isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] ? clearGetData($_GET['category']) : NULL;
}

function getSlugSubCategory(){
    
    return isset($_GET['subcategory']) && !empty($_GET['subcategory']) && $_GET['subcategory'] ? clearGetData($_GET['subcategory']) : NULL;
}

function getSlugLocation(){
    
    return isset($_GET['location']) && !empty($_GET['location']) && $_GET['location'] ? clearGetData($_GET['location']) : NULL;
}

function getFreqParam(){
    
    return isset($_GET['freq']) && !empty($_GET['freq']) && $_GET['freq'] ? clearGetData($_GET['freq']) : NULL;
}

function getSlugStore(){
    
    return isset($_GET['store']) && !empty($_GET['store']) && $_GET['store'] ? clearGetData($_GET['store']) : NULL;
}

function getTypeParam(){
    
    return isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] ? clearGetData($_GET['type']) : NULL;
}

function getParamsSort(){
    
    return isset($_GET['sortby']) && !empty($_GET['sortby']) ? clearGetData($_GET['sortby']) : NULL;
}

function getIntervalParam(){

    $interval = isset($_GET['interval']) && !empty($_GET['interval']) && $_GET['interval'] ? clearGetData($_GET['interval']) : "last7days";

    $intervals = array("today", "yesterday", "last7days", "last30days", "last6months", "lastyear", "alltime");

    if (in_array($interval, $intervals)) {

            return $interval;
            
        }else{
   
        return false;
    }
    
}

function getDateByInterval($interval){

    $date = new DateTime("now", new DateTimeZone(getTimeZone()));

    $intervals = array("today", "yesterday", "last7days", "last30days", "last6months", "lastyear", "alltime");

    if (in_array($interval, $intervals)) {

        switch($interval) {

            case 'today':

                return $date;

            break;
    
            case 'yesterday':

                $date->sub(new \DateInterval('P1D'));
                return $date;

            break;
    
            case 'last7days':

                $date->sub(new \DateInterval('P7D'));
                return $date;

            break;
    
            case 'last30days':

                $date->sub(new \DateInterval('P1M'));
                return $date;
                
            break;
    
            case 'last6months':

                $date->sub(new \DateInterval('P6M'));
                return $date;

            break;
    
            case 'lastyear':

                $date->sub(new \DateInterval('P1Y'));
                return $date;

            break;

            case 'alltime':

                $date->sub(new \DateInterval('P5Y'));
                return $date;

            break;
    
            }

        }else{
   
        return false;
    }
    
}

function getItemParam(){
    
    return isset($_GET['item']) && !empty($_GET['item']) && $_GET['item'] ? clearGetData($_GET['item']) : NULL;
}

function getUniqueParam(){
    
    return isset($_GET['unique']) && !empty($_GET['unique']) && $_GET['unique'] ? clearGetData($_GET['unique']) : NULL;
}

function formatDate($date){

    $sentence = connect()->prepare("SELECT st_dateformat FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $newDate = date($row['st_dateformat'], strtotime($date));
    return echoOutput($newDate);
}

function generatePassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

function maskEmail($email){

    $mail_parts = explode('@', $email);
    $username = '@'.$mail_parts[0];
    $len = strlen($username);

    return $username;
}

function getUserInfo(){

    if (isset($_SESSION['signedin']) && $_SESSION['signedin'] == true) {

        $email = filter_var(strtolower($_SESSION['user_email']), FILTER_VALIDATE_EMAIL);
    
        if($email) {
    
            $sentence = connect()->prepare("SELECT * FROM users WHERE user_status = 1 AND user_email = :user_email LIMIT 1");
            $sentence->execute(array(
                ':user_email' => $email
            ));
            $row = $sentence->fetch();
            return $row;
    
        }else{
            return null;
        }

    }else{

        return null;
    }

}

function getUserInfoByEmail($userEmail){

        if ($userEmail) {

            $sentence = connect()->prepare("SELECT * FROM users WHERE user_status = 1 AND user_email = :user_email LIMIT 1");
            $sentence->execute(array(
                ':user_email' => $userEmail
            ));
            $row = $sentence->fetch();
            return $row;
    
    }else{

        return false;
    }

}

function isUserVerified($userEmail){

    $sentence = connect()->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_verified = 1 LIMIT 1"); 
    $sentence->execute(array(
        ':user_email' => $userEmail
    ));
    $row = $sentence->fetch();

    if ($row) {
        return true;
    }else{
        return false;
    }
}

function getGravatar($email, $s = 150, $d = 'mp', $r = 'g', $img = false, $atts = array()) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function numTotalPages($total_items, $items_page){

    $numPages = ceil($total_items / $items_page);
    return $numPages;
}

function countFormat($num) {

      if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;
    }

  return $num;
}

function getSocialMedia($connect){
    
    $sentence = $connect->prepare("SELECT st_facebook,st_twitter,st_youtube,st_instagram,st_linkedin,st_whatsapp FROM settings"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function isInFav($connect, $userId, $itemId){
    $sentence = $connect->prepare("SELECT * FROM favorites WHERE user = :user AND item = :item LIMIT 1");
    $sentence->execute(array(
        ':user' => $userId,
        ':item' => $itemId
    ));
    $row = $sentence->fetch();
    return $row;
}

function getTimeZone(){

    $sentence = connect()->prepare("SELECT st_timezone FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    if(!empty($row['st_timezone'])){

        return $row['st_timezone'];

    }else{

        return "UTC";
    }

}

function getDateByTimeZone($format = NULL){

    $sentence = connect()->prepare("SELECT st_timezone FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $date = new DateTime("now", new DateTimeZone($row['st_timezone']) );

    if($format){
        return $date->format($format);
    }else{
        return $date->format('Y-m-d H:i');
    }
}

function getDateOnlyByTimeZone(){

    $sentence = connect()->prepare("SELECT st_timezone FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $date = new DateTime("now", new DateTimeZone($row['st_timezone']) );

    return $date->format('Y-m-d');

}

/*------------------------------------------------------------ */
/* SITE */
/*------------------------------------------------------------ */

function getSeoTitle($pageTitle = NULL, $pageSubTitle = NULL){

    if (!$pageSubTitle && empty($pageSubTitle)) {
        
        return $pageTitle;
        
    }elseif(!$pageTitle && empty($pageTitle)){

        return $pageSubTitle;

    }elseif($pageTitle && !empty($pageTitle) && $pageSubTitle && !empty($pageSubTitle)){

        return $pageSubTitle.' - '.$pageTitle;

    }else{

        return null;
    }
}

function getSeoDescription($generalDescription, $itemDescription = NULL, $seoDescription = NULL){

    if (!$itemDescription && empty($itemDescription) && !$seoDescription && empty($seoDescription)) {
        
        return echoNoHtml($generalDescription);
        
    }else{

        if ($seoDescription && !empty($seoDescription)) {

            return echoNoHtml($seoDescription);

        }else{

            return echoNoHtml($itemDescription);
        }

    }
}

/*------------------------------------------------------------ */
/* CONTENT */
/*------------------------------------------------------------ */

function getPlans($connect){
    $sentence = $connect->prepare("SELECT * FROM plans WHERE plan_status = 1 ORDER BY plan_order ASC");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getPlanById($connect, $id){

    if($id){

        $sentence = $connect->prepare("SELECT * FROM plans WHERE plan_status = 1 AND plan_id = :plan_id LIMIT 1");
        $sentence->execute(array(
            ':plan_id' => $id
        ));
        $row = $sentence->fetch();
        return $row;

    }else{
        return false;
    }


}

function getTaxesById($plan_taxes){

    $plan_taxes = json_decode($plan_taxes);

    if(empty($plan_taxes)) {
        return null;
    }

    $plan_taxes = implode(',', $plan_taxes);

    $sentence = connect()->prepare("SELECT * FROM taxes WHERE tax_id IN ({$plan_taxes})");
    $sentence->execute();
    return $sentence->fetchAll();
}

function calcTaxesByPrice($price, $percentage){

$percentage = $percentage;
$price = $price;

$new_width = ($percentage / 100) * $price;

return $new_width;

}

function getTaxesByPlan($plan_taxes){

    $plan_taxes = json_decode($plan_taxes);

    if(empty($plan_taxes)) {
        return null;
    }

    $plan_taxes = implode(',', $plan_taxes);

    $sentence = connect()->prepare("SELECT taxes.*, (SELECT SUM(tax_percentage) FROM taxes WHERE tax_type = 'exclusive') AS exclusive_percentage, (SELECT SUM(tax_percentage) FROM taxes WHERE tax_type = 'inclusive') AS inclusive_percentage FROM taxes WHERE tax_id IN ({$plan_taxes})");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getAppliedTaxes($planTaxes){

    $user = getUserInfo();

    $userDetails = getUserInfoById($user['user_id']);

    $userBilling = json_decode($userDetails['user_billing'], true);

    if(!empty($planTaxes)) {

        foreach ($planTaxes as $key => $value) {

            /* Countries */
            if ($value['tax_countries'] != "[]" && !in_array($userBilling['country'], json_decode($value['tax_countries']))) {
                unset($planTaxes[$key]);
            }

            if (isset($planTaxes[$key])) {
                $applied_taxes[] = $value['tax_id'];
            }
        }

        $array_taxes = array_values($planTaxes);
        return $array_taxes;
        
    }else{
        return null;
    }

}

function calculateTaxes($plan_price, $plan_taxes_array) {

    $price = $plan_price;

    $plan_taxes = getTaxesByPlan($plan_taxes_array);

    if($plan_taxes) {

        /* Check for the inclusives */
        $inclusive_taxes_total_percentage = 0;

        foreach($plan_taxes as $row) {
            if($row['tax_type'] == 'exclusive') continue;

            $inclusive_taxes_total_percentage += $row['tax_percentage'];
        }

        $total_inclusive_tax = $price - ($price / (1 + $inclusive_taxes_total_percentage / 100));

        $price_without_inclusive_taxes = $price - $total_inclusive_tax;

        /* Check for the exclusives */
        $exclusive_taxes_array = [];

        foreach($plan_taxes as $row) {

            if($row['tax_type'] == 'inclusive') {
                continue;
            }

            $exclusive_tax = $price_without_inclusive_taxes * ($row['tax_percentage'] / 100);

            $exclusive_taxes_array[] = $exclusive_tax;

        }

        $exclusive_taxes = array_sum($exclusive_taxes_array);

        $price_with_taxes = $price + $exclusive_taxes;

        $price = $price_with_taxes;
    }

    return $price;

}

function getMonthlyPlan($connect){
    $sentence = $connect->prepare("SELECT plan_monthly FROM plans WHERE plan_monthly != 0");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;

}

function gethalfYearPlan($connect){
    $sentence = $connect->prepare("SELECT plan_halfyear FROM plans WHERE plan_halfyear != 0");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function getAnnualPlan($connect){
    $sentence = $connect->prepare("SELECT plan_annual FROM plans WHERE plan_annual != 0");
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
    
}

function getUserInfoById($id){

        $sentence = connect()->prepare("SELECT users.*, sellers.seller_logo, sellers.seller_title  FROM users LEFT JOIN sellers ON sellers.seller_user = users.user_id WHERE user_status = 1 AND user_id = :user_id LIMIT 1");
        $sentence->execute(array(
            ':user_id' => $id
        ));
        $row = $sentence->fetch();
        return $row;
}

function getLocationBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT * FROM locations WHERE location_status = 1 AND location_slug = :location_slug LIMIT 1");
    $sentence->execute(array(
        ':location_slug' => $slug
    ));
    $row = $sentence->fetch();
    return $row;
}

function getSellerBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT sellers.*, (SELECT COUNT(*) FROM deals WHERE deals.deal_author = sellers.seller_user AND deals.deal_status = 1) AS total_items FROM sellers WHERE seller_Status = 1 AND seller_slug = :seller_slug LIMIT 1");
    $sentence->execute(array(
        ':seller_slug' => $slug
    ));
    $row = $sentence->fetch();
    return $row;
}

function getTotalDealsByLocation($itemId){
    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM deals WHERE deal_location = :deal_location AND deal_status = 1");
    $sentence->execute(array(
        ':deal_location' => $itemId
    ));
    $row = $sentence->fetch();
    return $row['total'];

}

function getReviewsByLocation($itemId){
    $sentence = connect()->prepare("SELECT SQL_CALC_FOUND_ROWS AVG(rating) AS rating, COUNT(*) AS total FROM reviews WHERE reviews.item = (SELECT deals.deal_id FROM deals WHERE deals.deal_location = :deal_location LIMIT 1) AND reviews.status = 1");
    $sentence->execute(array(
        ':deal_location' => $itemId
    ));
    $row = $sentence->fetch();
    return $row['rating'];

}


function getUserFavorites($connect, $userId){
    $sentence = $connect->prepare("SELECT deals.*, favorites.* FROM deals,favorites WHERE favorites.user = :user AND favorites.item = deals.deal_id GROUP BY deals.deal_id");
    $sentence->execute(array(
        ':user' => $userId
    ));
    return $sentence->fetchAll();
}

function getFeaturedCoupons($connect, $limit){

    $sentence = $connect->prepare("SELECT SQL_CALC_FOUND_ROWS coupons.*, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title,stores.store_slug AS store_slug, users.user_name AS author_name FROM coupons LEFT JOIN categories ON coupons.coupon_category = categories.category_id LEFT JOIN stores ON coupons.coupon_store = stores.store_id LEFT JOIN users ON coupons.coupon_author = users.user_id LEFT JOIN subcategories ON coupons.coupon_subcategory = subcategories.subcategory_id WHERE coupons.coupon_status = 1 AND coupons.coupon_featured = 1 AND coupons.coupon_verified = 1 AND coupons.coupon_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < coupons.coupon_expire OR coupons.coupon_expire IS NULL OR coupons.coupon_expire = '') GROUP BY coupons.coupon_id ORDER BY coupons.coupon_created DESC LIMIT $limit");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeaturedDeals($connect, $limit){

    $sentence = $connect->prepare("SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_status = 1 AND deals.deal_featured = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getDealById($connect, $itemId){

    $sentence = $connect->prepare("SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews, categories.*, subcategories.*, stores.*, locations.*, sellers.*, users.* FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id AND reviews.status = 1 LEFT JOIN sellers ON sellers.seller_id = deals.deal_author WHERE deals.deal_status = 1 AND deals.deal_id = :deal_id LIMIT 1");
    $sentence->execute(array(
        ':deal_id' => $itemId,
    ));
    $row = $sentence->fetch();
    return $row;
}

function getItemsGallery($connect, $itemId){

    $sentence = $connect->prepare("SELECT * FROM deals_gallery WHERE item = :item ORDER BY created DESC");
    $sentence->execute(array(
        ':item' => $itemId,
    ));
    return $sentence->fetchAll();
}

function getLatestDeals($connect, $limit){

    $sentence = $connect->prepare("SELECT deals.*, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id WHERE deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getExclusiveCoupons($connect, $limit){

    $sentence = $connect->prepare("SELECT SQL_CALC_FOUND_ROWS coupons.*, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title,stores.store_slug AS store_slug, users.user_name AS author_name FROM coupons LEFT JOIN categories ON coupons.coupon_category = categories.category_id LEFT JOIN stores ON coupons.coupon_store = stores.store_id LEFT JOIN users ON coupons.coupon_author = users.user_id LEFT JOIN subcategories ON coupons.coupon_subcategory = subcategories.subcategory_id WHERE coupons.coupon_status = 1 AND coupons.coupon_exclusive = 1 AND coupons.coupon_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < coupons.coupon_expire OR coupons.coupon_expire IS NULL OR coupons.coupon_expire = '') GROUP BY coupons.coupon_id ORDER BY coupons.coupon_created DESC LIMIT $limit");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeebackCoupons($connect, $user_id) {
    $feedbackCoupons = $connect->prepare("SELECT * FROM user_preferences WHERE user_id = :user_id ORDER BY created_at DESC");
    $feedbackCoupons->execute(array(
        ':user_id' => $user_id,
    ));
    return $feedbackCoupons->fetchAll();
}

function getExclusiveDeals($connect, $limit){

    $sentence = $connect->prepare("SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_status = 1 AND deals.deal_exclusive = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getRelatedDeals($connect, $itemId){

    $sentence = $connect->prepare("SELECT deals.*, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id WHERE deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') AND deals.deal_id != $itemId GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT 6");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeaturedStores($connect){
    $sentence = $connect->prepare("SELECT stores.*, (SELECT COUNT(*) FROM deals WHERE deals.deal_store = stores.store_id AND deal_status = 1) AS total_items FROM stores WHERE stores.store_featured = 1 AND stores.store_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeaturedLocations($connect){
    $sentence = $connect->prepare("SELECT locations.*, (SELECT COUNT(*) FROM deals WHERE deals.deal_location = locations.location_id AND deal_status = 1) AS total_items FROM locations WHERE locations.location_featured = 1 AND locations.location_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getLocations($connect, $limit = NULL){

    if($limit){
        $sentence = $connect->prepare("SELECT * FROM locations WHERE locations.location_status = 1 LIMIT $limit");
    }else{
        $sentence = $connect->prepare("SELECT * FROM locations WHERE locations.location_status = 1");
    }

    $sentence->execute();
    return $sentence->fetchAll();
}

function getStores($connect, $limit = NULL){

    if($limit){
        $sentence = $connect->prepare("SELECT stores.* FROM stores WHERE stores.store_status = 1 LIMIT $limit");
    }else{
        $sentence = $connect->prepare("SELECT stores.* FROM stores WHERE stores.store_status = 1");
    }

    $sentence->execute();
    return $sentence->fetchAll();
}

function getStoresByLetter($connect, $letter = NULL){

    if(!$letter){
        $sentence = $connect->prepare("SELECT stores.* FROM stores WHERE store_status = 1 AND store_title REGEXP '^[0-9]'");
    }else{
        $sentence = $connect->prepare("SELECT stores.* FROM stores WHERE store_status = 1 AND store_title LIKE '".$letter."%'");
    }

    $sentence->execute();
    return $sentence->fetchAll();
}

function getLocationsByLetter($connect, $letter = NULL){

    if(!$letter){
        $sentence = $connect->prepare("SELECT locations.* FROM locations WHERE location_status = 1 AND location_title REGEXP '^[0-9]'");
    }else{
        $sentence = $connect->prepare("SELECT locations.* FROM locations WHERE location_status = 1 AND location_title LIKE '".$letter."%'");
    }

    $sentence->execute();
    return $sentence->fetchAll();
}

function getSliders($connect){
    $sentence = $connect->prepare("SELECT * FROM sliders WHERE sliders.slider_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getMenuCategories($connect){
    $sentence = $connect->prepare("SELECT * FROM categories WHERE categories.category_menu = 1 AND categories.category_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFeaturedCategories($connect){
    $sentence = $connect->prepare("SELECT * FROM categories WHERE categories.category_featured = 1 AND categories.category_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getCategories($connect){
    $sentence = $connect->prepare("SELECT * FROM categories WHERE categories.category_status = 1");
    $sentence->execute();
    return $sentence->fetchAll();
}

function getTagCategoryBySlug($slug){
    $sentence = connect()->prepare("SELECT * FROM categories WHERE category_status = 1 AND category_slug = :category_slug LIMIT 1");
    $sentence->execute(array(
        ':category_slug' => $slug
    ));
    $row = $sentence->fetch();

    if($row){
        return $row['category_title'];
    }else{
        return false;
    }

}

function getTagSubCategoryBySlug($slug){
    $sentence = connect()->prepare("SELECT * FROM subcategories WHERE subcategory_status = 1 AND subcategory_slug = :subcategory_slug LIMIT 1");
    $sentence->execute(array(
        ':subcategory_slug' => $slug
    ));
    $row = $sentence->fetch();

    if($row){
        return $row['subcategory_title'];
    }else{
        return false;
    }
}

function getTagLocationBySlug($slug){
    $sentence = connect()->prepare("SELECT * FROM locations WHERE location_status = 1 AND location_slug = :location_slug LIMIT 1");
    $sentence->execute(array(
        ':location_slug' => $slug
    ));
    $row = $sentence->fetch();

    if($row){
        return $row['location_title'];
    }else{
        return false;
    }
}

function getTagStoreBySlug($slug){
    $sentence = connect()->prepare("SELECT * FROM stores WHERE store_status = 1 AND store_slug = :store_slug LIMIT 1");
    $sentence->execute(array(
        ':store_slug' => $slug
    ));
    $row = $sentence->fetch();

    if($row){
        return $row['store_title'];
    }else{
        return false;
    }
}

function getSubCategories12($connect, $parent){
    $sentence = $connect->prepare("SELECT subcategories.*, categories.category_id AS category_id FROM subcategories, categories WHERE subcategories.subcategory_parent = :subcategory_parent AND subcategories.subcategory_status = 1 GROUP BY subcategories.subcategory_id");
    $sentence->execute(array(
        ':subcategory_parent' => $parent
    ));
    return $sentence->fetchAll();
}

function getSubCategories($connect, $parent) {
    $sentence = $connect->prepare("
        SELECT 
            subcategories.*, 
            categories.category_id AS category_id
        FROM 
            subcategories
        JOIN 
            categories ON subcategories.subcategory_parent = categories.category_id
        WHERE 
            subcategories.subcategory_parent = :subcategory_parent 
            AND subcategories.subcategory_status = 1 
        GROUP BY 
            subcategories.subcategory_id, 
            categories.category_id
    ");

    $sentence->execute(array(
        ':subcategory_parent' => $parent
    ));

    return $sentence->fetchAll();
}


function getReviewsByDeal($connect, $itemId){

    $sentence = $connect->prepare("SELECT reviews.*, users.* FROM reviews LEFT JOIN users ON users.user_id = reviews.user WHERE item = :item AND reviews.status = 1 ORDER BY verified DESC, created DESC LIMIT 6");
    $sentence->execute(array(
        ':item' => $itemId
    ));
    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $results = $sentence->fetchAll(PDO::FETCH_ASSOC);
    return array('results' => $results, 'total' => $total);
}

function getReviewsByDealAjax($connect, $itemId, $limit){

    $sentence = $connect->prepare("SELECT SQL_CALC_FOUND_ROWS reviews.*, users.* FROM reviews LEFT JOIN users ON users.user_id = reviews.user WHERE item = :item AND reviews.status = 1 ORDER BY verified DESC, created DESC LIMIT 0,".$limit);
    $sentence->execute(array(
        ':item' => $itemId
    ));
    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $results = $sentence->fetchAll(PDO::FETCH_ASSOC);
    return array('results' => $results, 'total' => $total);

}

function getLikesCountById($id){
    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM favorites WHERE item = :item"); 
    $sentence->execute(array(
        ':item' => $id
    ));
    $row = $sentence->fetch();
    return $row['total'];
}

function getQParam(){

    return isset($_GET['q']) && !empty($_GET['q']) && $_GET['q'] ? clearGetData($_GET['q']) : NULL;
}

function getSearch($connect, $items_per_page){
    // echo getFilterParam(); exit;
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    if(getFilterParam() == "all-deals") {
        $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, CAST(deals.deal_oldprice AS UNSIGNED) AS oldprice, categories.*, subcategories.*, stores.*, locations.*, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '')";

        if(getSlugCategory()){
    
            $sqlQuery .= " AND deals.deal_category = (SELECT categories.category_id FROM categories WHERE categories.category_slug = '".getSlugCategory()."' LIMIT 1) ";
        }
    
        if(getQParam()){
    
            $sqlQuery .= " AND deals.deal_title LIKE '%".getQParam()."%'";
        }
    
        if(getSlugSubCategory()){
    
            $sqlQuery .= " AND deals.deal_subcategory = (SELECT subcategories.subcategory_id FROM subcategories WHERE subcategories.subcategory_slug = '".getSlugSubCategory()."' LIMIT 1) ";
        }
    
        if(getSlugLocation()){
    
            $sqlQuery .= " AND deals.deal_location = (SELECT locations.location_id FROM locations WHERE locations.location_slug = '".getSlugLocation()."' LIMIT 1) ";
        }
    
        if(getSlugStore()){
    
            $sqlQuery .= " AND deals.deal_store = (SELECT stores.store_id FROM stores WHERE stores.store_slug = '".getSlugStore()."' LIMIT 1) ";
        }
    
        if(getIDRating() && getIDRating() != "all"){
    
            $sqlQuery .= " AND rating >= '".getIDRating()."'";
        }
    
        if(getFilterParam() && getFilterParam() == "exclusive"){
    
            if(getFilterParam() == "exclusive"){
                $sqlQuery .= " AND deals.deal_exclusive = 1";
            }elseif(getFilterParam() == "featured"){
                $sqlQuery .= " AND deals.deal_featured = 1";
            }else{
                return NULL;
            }
            
        }
    
        if(getIDPrice() && getIDPrice() != "all"){
    
            $values = explode(',', getIDPrice());
            $from = (isset($values[0]) ? $values[0] : "0");
            $to = (isset($values[1]) ? $values[1] : "999999999");
    
            $sqlQuery .= " AND CAST(deals.deal_price AS UNSIGNED) BETWEEN '".$from."' AND '".$to."'";
        }
    
        $sqlQuery .= " GROUP BY deals.deal_id";
    
        if (getParamsSort()) {
    
            if(getParamsSort() == 'relevance') {
    
                $sqlQuery .= " ORDER BY deals.deal_created DESC";
    
            }elseif(getParamsSort() == 'price-asc') {
    
                $sqlQuery .= " ORDER BY price ASC";
    
            }elseif (getParamsSort() == 'price-desc') {
    
                $sqlQuery .= " ORDER BY price DESC";
    
            }elseif (getParamsSort() == 'best-rated') {
    
                $sqlQuery .= " ORDER BY total_reviews DESC";
            }
    
        }elseif(!isset($_GET['sortby']) || empty($_GET['sortby'])) {
    
            $sqlQuery .= " ORDER BY deals.deal_created DESC";
        }
    }
    else if(getFilterParam() == "all-coupons") {
        $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS coupons.*, categories.*, subcategories.*, stores.*, users.user_name AS author_name FROM coupons LEFT JOIN categories ON coupons.coupon_category = categories.category_id LEFT JOIN stores ON coupons.coupon_store = stores.store_id LEFT JOIN users ON coupons.coupon_author = users.user_id LEFT JOIN subcategories ON coupons.coupon_subcategory = subcategories.subcategory_id WHERE coupons.coupon_status = 1 AND coupons.coupon_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < coupons.coupon_expire OR coupons.coupon_expire IS NULL OR coupons.coupon_expire = '')";

        if(getSlugCategory()){
    
            $sqlQuery .= " AND coupons.coupon_category = (SELECT categories.category_id FROM categories WHERE categories.category_slug = '".getSlugCategory()."' LIMIT 1) ";
        }
    
        if(getQParam()){
    
            $sqlQuery .= " AND coupons.coupon_title LIKE '%".getQParam()."%'";
        }
    
        if(getSlugSubCategory()){
    
            $sqlQuery .= " AND coupons.coupon_subcategory = (SELECT subcategories.subcategory_id FROM subcategories WHERE subcategories.subcategory_slug = '".getSlugSubCategory()."' LIMIT 1) ";
        }
    
        if(getSlugStore()){
    
            $sqlQuery .= " AND coupons.coupon_store = (SELECT stores.store_id FROM stores WHERE stores.store_slug = '".getSlugStore()."' LIMIT 1) ";
        }
    
        if(getTypeParam()){
    
            if(getTypeParam() == "exclusive-coupon"){
                $sqlQuery .= " AND coupons.coupon_exclusive = 1";
            }elseif(getTypeParam() == "featured-coupon"){
                $sqlQuery .= " AND coupons.coupon_featured = 1";
            }
            
        }
    
        $sqlQuery .= " GROUP BY coupons.coupon_id";
        if(!isset($_GET['sortby']) || empty($_GET['sortby'])) {
    
            $sqlQuery .= " ORDER BY coupons.coupon_created DESC";
        }
    }
    else if(getFilterParam()== "exclusive-coupon" || getFilterParam()=="featured-coupon") {
        $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS coupons.*, categories.*, subcategories.*, stores.*, users.user_name AS author_name FROM coupons LEFT JOIN categories ON coupons.coupon_category = categories.category_id LEFT JOIN stores ON coupons.coupon_store = stores.store_id LEFT JOIN users ON coupons.coupon_author = users.user_id LEFT JOIN subcategories ON coupons.coupon_subcategory = subcategories.subcategory_id WHERE coupons.coupon_status = 1 AND coupons.coupon_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < coupons.coupon_expire OR coupons.coupon_expire IS NULL OR coupons.coupon_expire = '')";


        if(getSlugCategory()){
    
            $sqlQuery .= " AND coupons.coupon_category = (SELECT categories.category_id FROM categories WHERE categories.category_slug = '".getSlugCategory()."' LIMIT 1) ";
        }
    
        if(getQParam()){
    
            $sqlQuery .= " AND coupons.coupon_title LIKE '%".getQParam()."%'";
        }
    
        if(getSlugSubCategory()){
    
            $sqlQuery .= " AND coupons.coupon_subcategory = (SELECT subcategories.subcategory_id FROM subcategories WHERE subcategories.subcategory_slug = '".getSlugSubCategory()."' LIMIT 1) ";
        }
    
        if(getSlugStore()){
    
            $sqlQuery .= " AND coupons.coupon_store = (SELECT stores.store_id FROM stores WHERE stores.store_slug = '".getSlugStore()."' LIMIT 1) ";
        }
    
        if(getFilterParam()){
    
            if(getFilterParam() == "exclusive-coupon"){
                $sqlQuery .= " AND coupons.coupon_exclusive = 1";
            }elseif(getFilterParam() == "featured-coupon"){
                $sqlQuery .= " AND coupons.coupon_featured = 1";
            }else{
                return NULL;
            }
            
        }
    
        $sqlQuery .= " GROUP BY coupons.coupon_id";
        if(!isset($_GET['sortby']) || empty($_GET['sortby'])) {
    
            $sqlQuery .= " ORDER BY coupons.coupon_created DESC";
        }
    } else {
        $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, CAST(deals.deal_oldprice AS UNSIGNED) AS oldprice, categories.*, subcategories.*, stores.*, locations.*, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '')";

        if(getSlugCategory()){
    
            $sqlQuery .= " AND deals.deal_category = (SELECT categories.category_id FROM categories WHERE categories.category_slug = '".getSlugCategory()."' LIMIT 1) ";
        }
    
        if(getQParam()){
    
            $sqlQuery .= " AND deals.deal_title LIKE '%".getSearchQuery()."%'";
        }
    
        if(getSlugSubCategory()){
    
            $sqlQuery .= " AND deals.deal_subcategory = (SELECT subcategories.subcategory_id FROM subcategories WHERE subcategories.subcategory_slug = '".getSlugSubCategory()."' LIMIT 1) ";
        }
    
        if(getSlugLocation()){
    
            $sqlQuery .= " AND deals.deal_location = (SELECT locations.location_id FROM locations WHERE locations.location_slug = '".getSlugLocation()."' LIMIT 1) ";
        }
    
        if(getSlugStore()){
    
            $sqlQuery .= " AND deals.deal_store = (SELECT stores.store_id FROM stores WHERE stores.store_slug = '".getSlugStore()."' LIMIT 1) ";
        }
    
        if(getIDRating() && getIDRating() != "all"){
    
            $sqlQuery .= " AND rating >= '".getIDRating()."'";
        }
    
        if(getFilterParam() && getFilterParam() == "exclusive"){
    
            if(getFilterParam() == "exclusive"){
                $sqlQuery .= " AND deals.deal_exclusive = 1";
            }elseif(getFilterParam() == "featured"){
                $sqlQuery .= " AND deals.deal_featured = 1";
            }else{
                return NULL;
            }
            
        }
    
        if(getIDPrice() && getIDPrice() != "all"){
    
            $values = explode(',', getIDPrice());
            $from = (isset($values[0]) ? $values[0] : "0");
            $to = (isset($values[1]) ? $values[1] : "999999999");
    
            $sqlQuery .= " AND CAST(deals.deal_price AS UNSIGNED) BETWEEN '".$from."' AND '".$to."'";
        }
    
        $sqlQuery .= " GROUP BY deals.deal_id";
    
        if (getParamsSort()) {
    
            if(getParamsSort() == 'relevance') {
    
                $sqlQuery .= " ORDER BY deals.deal_created DESC";
    
            }elseif(getParamsSort() == 'price-asc') {
    
                $sqlQuery .= " ORDER BY price ASC";
    
            }elseif (getParamsSort() == 'price-desc') {
    
                $sqlQuery .= " ORDER BY price DESC";
    
            }elseif (getParamsSort() == 'best-rated') {
    
                $sqlQuery .= " ORDER BY total_reviews DESC";
            }
    
        }elseif(!isset($_GET['sortby']) || empty($_GET['sortby'])) {
    
            $sqlQuery .= " ORDER BY deals.deal_created DESC";
        }
    }

    $sqlQuery .= " LIMIT $limit, $items_per_page";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

function getDealsByStore($connect, $items_per_page, $itemId){
    
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.store_id = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_store = '".$itemId."' AND deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit, $items_per_page";
    $sentence = $connect->prepare($sqlQuery);
    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

function getDealsByLocation($connect, $items_per_page, $itemId){
    
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_location = '".$itemId."' AND deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit, $items_per_page";
    $sentence = $connect->prepare($sqlQuery);
    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

function getDealsByUser($connect, $items_per_page, $itemId){
    
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deals.deal_category = categories.category_id LEFT JOIN stores ON deals.deal_store = stores.store_id LEFT JOIN locations ON deals.deal_location = locations.location_id LEFT JOIN users ON deals.deal_author = users.user_id LEFT JOIN subcategories ON deals.deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_author = '".$itemId."' AND deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit, $items_per_page";
    $sentence = $connect->prepare($sqlQuery);
    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

function getDealsByCategory($connect, $items_per_page, $itemId){
    
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON store_id = stores.store_id LEFT JOIN locations ON location_id = locations.location_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_category = '".$itemId."' AND deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit, $items_per_page";
    $sentence = $connect->prepare($sqlQuery);
    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

function getDealsBySubCategory($connect, $items_per_page, $itemId){
    
    $limit = (getNumPage() > 1) ? getNumPage() * $items_per_page - $items_per_page : 0;
    
    $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, CAST(deals.deal_price AS UNSIGNED) AS price, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON store_id = stores.store_id LEFT JOIN locations ON location_id = locations.location_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_subcategory = '".$itemId."' AND deals.deal_status = 1 AND deals.deal_start <= '".getDateByTimeZone()."' AND ('".getDateByTimeZone()."' < deals.deal_expire OR deals.deal_expire IS NULL OR deals.deal_expire = '') GROUP BY deals.deal_id ORDER BY deals.deal_created DESC LIMIT $limit, $items_per_page";
    $sentence = $connect->prepare($sqlQuery);
    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();
    $items = $sentence->fetchAll(PDO::FETCH_ASSOC);

    return array('items' => $items, 'total' => $total);
}

/*------------------------------------------------------------ */
/* SITEMAP */
/*------------------------------------------------------------ */

function getPages($connect){
    $sentence = $connect->prepare("SELECT * FROM pages WHERE page_status = 1");
    $sentence->execute();
    $row = $sentence->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getDeals($connect){
    
    $sqlQuery = "SELECT deals.*, categories.category_title AS category_title, subcategories.subcategory_title AS subcategory_title, stores.store_id AS store_id, stores.store_title AS store_title, stores.store_image AS store_image, stores.store_slug AS store_slug, users.user_name AS author_name FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id WHERE deals.deal_status = 1 GROUP BY deals.deal_id ORDER BY deals.deal_created DESC";
    $sentence = $connect->prepare($sqlQuery);
    $sentence->execute();
    $row = $sentence->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function getSubCategoriesSiteMap($connect){
    $sentence = $connect->prepare("SELECT subcategories.* FROM subcategories WHERE subcategories.subcategory_status = 1");
    $sentence->execute();
    $row = $sentence->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

/*------------------------------------------------------------ */
/* ADS */
/*------------------------------------------------------------ */

function getHeaderAd($connect){
    
    $sentence = $connect->prepare("SELECT * FROM ads WHERE ad_position = 'header' AND ad_status = 1 ORDER BY RAND() LIMIT 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getFooterAd($connect){
    
    $sentence = $connect->prepare("SELECT * FROM ads WHERE ad_position = 'footer' AND ad_status = 1 ORDER BY RAND() LIMIT 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getSidebarAd($connect){
    
    $sentence = $connect->prepare("SELECT * FROM ads WHERE ad_position = 'sidebar' AND ad_status = 1 ORDER BY RAND() LIMIT 1"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getSettings($connect){
    
    $sentence = $connect->prepare("SELECT * FROM settings"); 
    $sentence->execute();
    return $sentence->fetch();
}

function getTheme($connect){
    
    $sentence = $connect->prepare("SELECT * FROM theme"); 
    $sentence->execute();
    return $sentence->fetch();
}

function getDefaultPage($connect, $page){

    if($page){

        $sentence = $connect->prepare("SELECT * FROM pages WHERE page_status = 1 AND page_id = :page_id LIMIT 1");
        $sentence->execute(array(
            ':page_id' => $page
        ));
        $row = $sentence->fetch();
        return $row;

    }else{
        return NULL;
    }

}

function getPageBySlug($connect, $slug){
    $sentence = $connect->prepare("SELECT * FROM pages WHERE page_status = 1 AND page_slug = :page_slug LIMIT 1");
    $sentence->execute(array(
        ':page_slug' => $slug
    ));
    $row = $sentence->fetch();
    return $row;
}

function getPageByID($connect, $id_page){
    $sentence = $connect->prepare("SELECT * FROM pages WHERE page_status = 1 AND page_id = :page_id LIMIT 1");
    $sentence->execute(array(
        ':page_id' => $id_page
    ));
    $row = $sentence->fetch();
    return $row;
}

function getSidebarMenu($connect){
    
    $q = $connect->query("SELECT * FROM menus WHERE menu_sidebar = 1 AND menu_status = 1 ORDER BY menu_id DESC LIMIT 1");
    $f = $q->fetch();
    $result = $f;
    return $result;
}

function getHeaderMenu($connect){
    
    $q = $connect->query("SELECT * FROM menus WHERE menu_header = 1 AND menu_status = 1 ORDER BY menu_id DESC LIMIT 1");
    $f = $q->fetch();
    $result = $f;
    return $result;
}

function getFooterMenu($connect){
    
    $q = $connect->query("SELECT * FROM menus WHERE menu_footer = 1 AND menu_status = 1 ORDER BY menu_id DESC LIMIT 1");
    $f = $q->fetch();
    $result = $f;
    return $result;
}

function getNavigation($connect, $idMenu){
    
    $sentence = $connect->prepare("SELECT navigations.navigation_id, navigations.navigation_page, navigations.navigation_target, COALESCE(pages.page_slug, navigations.navigation_url) AS navigation_url, COALESCE(pages.page_title, navigations.navigation_label) AS navigation_label, navigations.navigation_type FROM navigations LEFT JOIN pages ON page_id = navigations.navigation_page WHERE navigation_menu = '".$idMenu."' ORDER BY navigation_order ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getEmailTemplate($connect, $id){

    if (!empty($id) && (int)($id)) {

        $q = $connect->query("SELECT * FROM emailtemplates WHERE email_id = ".$id." LIMIT 1");
        $f = $q->fetch();
        $result = $f;

        if ($result['email_disabled'] == 1) {
            return null;
        }else{
            return $result;
        }
    }else{

        return null;
    }  

}

function sendMail($array_content, $email_content, $destinationmail, $fromName, $subject, $isHtml, $replyToName = NULL, $replyToAddress = NULL) {
    
    $sentence = connect()->prepare("SELECT * FROM settings"); 
    $sentence->execute();
    $settings = $sentence->fetch();
    
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                          
        $mail->Host       = $settings['st_smtphost'];                
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $settings['st_smtpemail'];              
        $mail->Password   = $settings['st_smtppassword'];                             
        $mail->SMTPSecure = $settings['st_smtpencrypt'];
        $mail->Port       = $settings['st_smtpport'];

        if (isset($replyToAddress, $replyToName) && !empty($replyToAddress) && !empty($replyToName)) {
            $mail->addReplyTo($replyToAddress, $replyToName);
        }

        $mail->setFrom($settings['st_smtpemail'], $fromName);
        $mail->CharSet = "UTF-8";
        $mail->AddAddress($destinationmail); 
        $mail->isHTML($isHtml);

        $find = array_keys($array_content);
        $replace = array_values($array_content);

        $mailcontent = str_replace($find, $replace, $email_content);
        $mailsubject = str_replace($find, $replace, $subject);

        $mail->Subject = $mailsubject;
        $mail->Body = $mailcontent;
        if (!$mail->send()){

            $result = $mail->ErrorInfo;
            
        }else{

            $result = 'TRUE';
        }

        return $result;

    } catch (Exception $e) {
     return $e;
    }

}

/*------------------------------------------------------------ */
/* PAYMENT PROCCESING */
/*------------------------------------------------------------ */

function getTransactionById($connect, $id, $processor){
    $sentence = $connect->prepare("SELECT * FROM payments WHERE payment_external = :payment_external AND payment_processor = :payment_processor");
    $sentence->execute(array(
        ':payment_external' => $id,
        ':payment_processor' => $processor
    ));
    $row = $sentence->fetch();

    if($row){
        return $row;
    }else{
        return false;
    }
}

function cancelUserSubscription($settings, $user_id) {

	    $user = getUserInfoById($user_id);

        if(empty($user['user_payment_subscription_id'])) {
            return true;
        }

        switch($user['user_payment_processor']) {
            case 'stripe':

                \Stripe\Stripe::setApiKey($settings['st_stripe_secret']);

                $subscription = \Stripe\Subscription::retrieve($user['user_payment_subscription_id']);
                $subscription->cancel();

                break;

            case 'paypal':

                try {
                    $paypal_api_url = get_api_url_paypal($settings);
                    $headers = get_headers_paypal($settings);
                } catch (\Exception $exception) {

                    throw new \Exception($exception->getCode() . ':' . $exception->getMessage());
                }

                $response = \Unirest\Request::post($paypal_api_url . 'v1/billing/subscriptions/' . $user['user_payment_subscription_id'] . '/cancel', $headers, \Unirest\Request\Body::json([
                    'reason' => "Canceled By User"
                ]));

                if($response->code >= 400) {

                    throw new \Exception($response->body->name . ':' . $response->body->message);
                }

                break;

            case 'paystack':

                $payment_subscription_id = explode('###', $user['user_payment_subscription_id']);
                $code = $payment_subscription_id[0];
                $token = $payment_subscription_id[1];

                $response = \Unirest\Request::post(get_api_url_paystack() . 'subscription/disable', get_headers_paystack($settings), \Unirest\Request\Body::json([
                    'code' => $code,
                    'token' => $token,
                ]));

                if(!$response->body->status) {

                    throw new \Exception($response->body->message);
                }

                break;

            case 'razorpay':

                $razorpay = new Api($settings['st_razorpay_publickey'], $settings['st_razorpay_secretkey']);

                try {
                    $response = $razorpay->subscription->fetch($user['user_payment_subscription_id'])->cancel();
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage());
                }

                break;

            case 'mollie':

                $mollie = new \Mollie\Api\MollieApiClient();
                $mollie->setApiKey($settings['st_mollie_api']);

                $payment_subscription_id = explode('###', $user['user_payment_subscription_id']);
                $customer_id = $payment_subscription_id[0];
                $subscription_id = $payment_subscription_id[1];

                try {
                    $mollie->subscriptions->cancelForId($customer_id, $subscription_id);
                } catch (\Exception $exception) {

                    throw new \Exception($exception->getMessage());
                }

                break;
        }

        $statment = connect()->prepare("UPDATE users SET user_payment_subscription_id = :user_payment_subscription_id, user_plan_canceled_date = :user_plan_canceled_date WHERE user_id = :user_id");
    
        $statment->execute(array(
            ':user_id' => $user_id,
            ':user_payment_subscription_id' => '',
            ':user_plan_canceled_date' => getDateByTimeZone()
        ));
}

function webhookProcessPayment($connect, $settings, $payment_processor, $payment_taxes, $external_payment_id, $payment_total, $payment_currency, $user_id, $plan_id, $payment_frequency, $code, $discount_amount, $base_amount, $payment_type, $payment_subscription_id, $payer_email, $payer_name) {

    $plan = getPlanById($connect, $plan_id);

    if(!$plan) {
        http_response_code(400);die();
    }

    if(getTransactionById($connect, $external_payment_id, $payment_processor)) {
        http_response_code(400);die();
    }

    $user = getUserInfoById($user_id);

    if(!$user) {
        http_response_code(400);die();
    }

    if(!empty($user['user_payment_subscription_id']) && ($payment_subscription_id && $user['user_payment_subscription_id'] != $payment_subscription_id)) {
        try {
            cancelUserSubscription($settings, $user_id);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            http_response_code(400); die();
        }
    }

    $statment = $connect->prepare("INSERT INTO payments (
        payment_id,
        payment_user_id,
        payment_plan_id,
        payment_subscription_id,
        payment_processor,
        payment_frequency,
        payment_code,
        payment_discount_amount,
        payment_base_amount,
        payment_email,
        payment_external,
        payment_name,
        payment_taxes,
        payment_total_amount,
        payment_currency,
        payment_date
        )
        VALUES (
        null,
        :payment_user_id,
        :payment_plan_id,
        :payment_subscription_id,
        :payment_processor,
        :payment_frequency,
        :payment_code,
        :payment_discount_amount,
        :payment_base_amount,
        :payment_email,
        :payment_external,
        :payment_name,
        :payment_taxes,
        :payment_total_amount,
        :payment_currency,
        :payment_date)");
    
    $statment->execute(array(
        ':payment_user_id' => $user_id,
        ':payment_plan_id' => $plan_id,
        ':payment_subscription_id' => $payment_subscription_id,
        ':payment_processor' => $payment_processor,
        ':payment_frequency' => $payment_frequency,
        ':payment_code' => $code,
        ':payment_discount_amount' => $discount_amount,
        ':payment_base_amount' => $base_amount,
        ':payment_email' => $payer_email,
        ':payment_external' => $external_payment_id,
        ':payment_name' => $payer_name,
        ':payment_taxes' => $payment_taxes,
        ':payment_total_amount' => $payment_total,
        ':payment_currency' => $payment_currency,
        ':payment_date' => getDateByTimeZone()
        ));

    $current_plan_expiration_date = $plan_id == $user['user_plan'] ? $user['user_plan_expiration_date'] : '';

    switch($payment_frequency) {
        case 'monthly':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+30 days')->format('Y-m-d H:i:s');
            break;

        case 'halfyear':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+6 months')->format('Y-m-d H:i:s');
            break;

        case 'annual':
            $plan_expiration_date = (new \DateTime($current_plan_expiration_date))->modify('+12 months')->format('Y-m-d H:i:s');
            break;
    }

    $statement = $connect->prepare("UPDATE users SET
    user_plan = :user_plan,
    user_plan_expiration_date = :user_plan_expiration_date,
    user_payment_subscription_id = :user_payment_subscription_id,
    user_payment_processor = :user_payment_processor,
    user_payment_total_amount = :user_payment_total_amount,
    user_payment_currency = :user_payment_currency,
    user_plan_canceled_date = :user_plan_canceled_date
    WHERE user_id = :user_id");

    $statement->execute(array(
        ':user_id' => $user_id,
        ':user_plan' => $plan_id,
        ':user_plan_expiration_date' => $plan_expiration_date,
        ':user_payment_subscription_id' => $payment_subscription_id,
        ':user_payment_processor' => $payment_processor,
        ':user_payment_total_amount' => $payment_total,
        ':user_payment_currency' => $payment_currency,
        ':user_plan_canceled_date' => null
    ));

}

/*------------------------------------------------------------ */
/* PAYMENTS */
/*------------------------------------------------------------ */

function getFrequency($frequency){
    if($frequency == 'monthly'){
        return 30;
    }else if($frequency == 'halfyear'){
        return 183;
    }else if($frequency == 'annual'){
        return 365;
    }
}

function getTimeFreq($frequency){
    
    if($frequency == 'monthly'){
        return '+1 month';
    }else if($frequency == 'halfyear'){
        return '+6 months';
    }else if($frequency == 'annual'){
        return '+1 year';
    }
}

function getPlanPrice($connect, $planId, $frequency){

    $statement = $connect->prepare("SELECT * FROM plans WHERE plan_id = :plan_id LIMIT 1");
    $statement->execute(array(':plan_id' => $planId));
    $planDetails = $statement->fetch();

    if($frequency == "monthly"){
        return $planDetails['plan_monthly'];
    }elseif($frequency == "halfyear"){
        return $planDetails['plan_halfyear'];
    }elseif($frequency == "annual"){
        return $planDetails['plan_annual'];
    }else{
        return null;
    }
        
}

function getCouponPrice($connect, $planId, $codeCoupon, $frequency){

    $statement = $connect->prepare("SELECT * FROM plans WHERE plan_id = :plan_id LIMIT 1");
    $statement->execute(array(':plan_id' => $planId));
    $planDetails = $statement->fetch();

    if($frequency == "monthly"){
        $getPrice = $planDetails['plan_monthly'];
    }elseif($frequency == "halfyear"){
        $getPrice = $planDetails['plan_halfyear'];
    }elseif($frequency == "annual"){
        $getPrice = $planDetails['plan_annual'];
    }else{
        return null;
    }

    $statement = $connect->prepare("SELECT * FROM codes WHERE code_coupon = :code_coupon AND code_status = 1 LIMIT 1");
    $statement->execute(array(':code_coupon' => $codeCoupon));
    $codeDetails = $statement->fetch();
    
    if($codeDetails == false){
    
    return array('base_amount' => $getPrice, 'price' => $getPrice, 'code' => null, 'discount_amount' => 0);
    
    }else{

        $allowedCoupons = json_decode($planDetails['plan_codes']);

                if(!in_array($codeDetails['code_id'], $allowedCoupons)){

                    return array('base_amount' => $getPrice, 'price' => $getPrice, 'code' => null, 'discount_amount' => 0);

                }else{

                    $statement = $connect->prepare("SELECT COUNT(payment_id) AS total FROM payments WHERE payment_code = :payment_code");
                    $statement->execute(array(':payment_code' => $codeDetails['code_id']));
                    $usedQuantity = $statement->fetch()['total'];
                    
                    if($usedQuantity >= $codeDetails['code_quantity']){
                    
                    return array('base_amount' => $getPrice, 'price' => $getPrice, 'code' => null, 'discount_amount' => 0);
                    
                    }else{
                    
                    $calcPer = ($codeDetails['code_discount'] / 100) * $getPrice;
                    $totalPrice = ($getPrice - $calcPer);
                    $discountPrice = number_format(($getPrice * $codeDetails['code_discount'] / 100), 2, '.', '');
                    
                    return array('base_amount' => $getPrice, 'price' => $totalPrice, 'code' => $codeCoupon, 'discount_amount' => $discountPrice);
                    
                        }

                }

    }
        
    }

    function getFrequencyText($frequency){
        if($frequency == 'monthly'){
            return 'Monthly';
        }else if($frequency == 'halfyear' || $frequency == 'biannually'){
            return '6 Months';
        }else if($frequency == 'annual'){
            return 'Annual';
        }
    }

    function gePaymentById($itemId){

        $user = getUserInfo();
    
        if($user){
    
            $userDetails = getUserInfoById($user['user_id']);
    
            $sentence = connect()->prepare("SELECT payments.*, plans.*, users.*, codes.* FROM payments LEFT JOIN users ON payments.payment_user_id = users.user_id LEFT JOIN plans ON payments.payment_plan_id = plans.plan_id LEFT JOIN codes ON payments.payment_code = codes.code_coupon WHERE payment_id = :payment_id AND payment_user_id = :payment_user_id LIMIT 1");
            $sentence->execute(array(
                ':payment_id' => $itemId,
                ':payment_user_id' => $userDetails['user_id']
            ));
            $row = $sentence->fetch();
        
            if($row != false){
                return $row;
            }else{
                return false;
            }
    
        }else{
            return false;
        }
    
    }

    function getUserCurrentPlan(){

        $user = getUserInfo();
    
        if($user){
    
            $userDetails = getUserInfoById($user['user_id']);
    
            $sentence = connect()->prepare("SELECT payments.*, plans.*, users.* FROM payments LEFT JOIN users ON payments.payment_user_id = users.user_id LEFT JOIN plans ON payments.payment_plan_id = plans.plan_id WHERE payment_user_id = :payment_user_id ORDER BY payments.payment_date DESC LIMIT 1");
            $sentence->execute(array(
                ':payment_user_id' => $userDetails['user_id'],
            ));
            $row = $sentence->fetch();
        
            if($row != false){
                return $row;
            }else{
                return false;
            }
    
        }else{
            return false;
        }
    
    }

    function hasStore($userId){

        if($userId){
    
            $sentence = connect()->prepare("SELECT * FROM sellers WHERE seller_user = :seller_user AND seller_status = 1");
            $sentence->execute(array(
                ':seller_user' => $userId,
            ));
            $row = $sentence->fetch();
        
            if($row != false){
                return true;
            }else{
                return false;
            }
    
        }else{
            return false;
        }
    
    }

    function isSeller(){

        $user = getUserInfo();

        if($user){
    
            $userDetails = getUserInfoById($user['user_id']);
    
            $sentence = connect()->prepare("SELECT * FROM users WHERE user_pro = :user_pro AND user_status = 1");
            $sentence->execute(array(
                ':user_pro' => $userDetails['user_pro'],
            ));
            $row = $sentence->fetch();
        
            if($row != false){
                return true;
            }else{
                return false;
            }
    
        }else{
            return false;
        }
    
    }

    function isActiveSeller($userId){
    
        if($userId){
    
            $userDetails = getUserInfoById($userId);
    
            $sentence = connect()->prepare("SELECT st_timezone FROM settings");
            $sentence->execute();
            $row = $sentence->fetch();
        
            $date = new DateTime("now", new DateTimeZone($row['st_timezone']));
        
            $formtedDate = $date->format('Y-m-d H:i:s');
        
            if($userDetails['user_plan_expiration_date'] > $formtedDate){
                return true;
            }else{
                return false;
            }
    
        }else{
            return false;
        }
    }

    function isExpiredSubscription(){

        $user = getUserInfo();
    
        if($user){
    
            $userDetails = getUserInfoById($user['user_id']);

            if(!empty($userDetails['user_plan_expiration_date'])){
            
                $sentence = connect()->prepare("SELECT st_timezone FROM settings");
                $sentence->execute();
                $row = $sentence->fetch();
            
                $date = new DateTime("now", new DateTimeZone($row['st_timezone']) );
            
                $formtedDate = $date->format('Y-m-d H:i:s');
            
                if($userDetails['user_plan_expiration_date'] > $formtedDate){
                    return false;
                }else{
                    return true;
                }

            }
    
        }else{
            return false;
        }
    }
    
    function expirationReminderAlert(){
    
        $user = getUserInfo();

        if(!empty($user)){

            $userDetails = getUserInfoById($user['user_id']);

            if(!empty($userDetails['user_plan_expiration_date'])){

                $now = new DateTime($userDetails['user_plan_expiration_date']);
                $expire   = new DateTime(getDateByTimeZone());
                $days = $expire->diff($now)->format('%a');
    
                if($days <= 7){
                    return true;
                }else{
                    return false;
                }

            }else{
                return false;
            }
    
        }else{
            return false;
        }
    }

/*------------------------------------------------------------ */
/* PAYPAL */
/*------------------------------------------------------------ */

    function get_api_url_paypal($settings) {

        $sandbox_api_url = 'https://api-m.sandbox.paypal.com/';
        $live_api_url = 'https://api-m.paypal.com/';
        
        return $settings['st_paypal_mode'] == 'live' ? $live_api_url : $sandbox_api_url;
    }

    function get_access_token_paypal($settings) {

        $access_token = null;

        if($access_token) return $access_token;

        \Unirest\Request::auth($settings['st_paypal_id'], $settings['st_paypal_secret']);

        $response = \Unirest\Request::post(get_api_url_paypal($settings) . 'v1/oauth2/token', [], \Unirest\Request\Body::form(['grant_type' => 'client_credentials']));

        if($response->code >= 400) {
            throw new \Exception($response->body->error . ':' . $response->body->error_description);
        }

        return $access_token = $response->body->access_token;
    }

    function get_headers_paypal($settings) {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . get_access_token_paypal($settings)
        ];
    }

/*------------------------------------------------------------ */
/* PAYSTACK */
/*------------------------------------------------------------ */

function get_api_url_paystack() {

    $live_api_url = 'https://api.paystack.co/';
    
    return $live_api_url;
}

function get_headers_paystack($settings) {
    return [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $settings['st_paystack_secret']
    ];
}

function getFrePayStack($frequency){
    
    if($frequency == 'monthly'){
        return 'monthly';
    }else if($frequency == 'halfyear'){
        return 'biannually';
    }else if($frequency == 'annual'){
        return 'annually';
    }
}

function getPercent($newprice, $oldprice, $translation){

    $new = str_replace(',', '.', echoOutput($newprice));
    $old = str_replace(',', '.', echoOutput($oldprice));

    $calc = (($old - $new) / $old) * 100;
    $percent = round(abs($calc));
    return $percent.$translation['tr_9'];
}

function getPrice($price){

    if($price){

        $output = "";
        $sentence = connect()->prepare("SELECT st_currency, st_currencyposition, st_decimalnumber, st_decimalseparator FROM settings");
        $sentence->execute();
        $row = $sentence->fetch();
    
        $num = str_replace(',', '.', echoOutput($price));
    
        if($row['st_decimalnumber'] != 0){
    
            if ($row['st_currencyposition'] == 'left') {
                $output = $row['st_currency'] . rtrim(rtrim(number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator'], $row['st_decimalseparator']), 0), $row['st_decimalseparator']);
            }elseif ($row['st_currencyposition'] == 'left-space') {
                $output = $row['st_currency'] .' '. rtrim(rtrim(number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator'], $row['st_decimalseparator']), 0), $row['st_decimalseparator']);
            }elseif ($row['st_currencyposition'] == 'right') {
                $output = rtrim(rtrim(number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator'], $row['st_decimalseparator']), 0), $row['st_decimalseparator']) . $row['st_currency'];
            }elseif ($row['st_currencyposition'] == 'right-space') {
                $output = rtrim(rtrim(number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator'], $row['st_decimalseparator']), 0), $row['st_decimalseparator']) .' '. $row['st_currency'];
            }
    
        }else{
    
            if ($row['st_currencyposition'] == 'left') {
                $output = $row['st_currency'] . number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator']);
            }elseif ($row['st_currencyposition'] == 'left-space') {
                $output = $row['st_currency'] .' '. number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator']);
            }elseif ($row['st_currencyposition'] == 'right') {
                $output = number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator']) . $row['st_currency'];
            }elseif ($row['st_currencyposition'] == 'right-space') {
                $output = number_format($num, $row['st_decimalnumber'], $row['st_decimalseparator']) .' '. $row['st_currency'];
            }
    
        }
    
        return $output;

    }else{
        return null;
    }


}

function getPriceNoCurrency($price){

    $output = "";
    $sentence = connect()->prepare("SELECT st_currency, st_currencyposition, st_decimalnumber, st_decimalseparator FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $num = str_replace(',', '.', echoOutput($price));

    if($row['st_decimalnumber'] != 0){

        if ($row['st_currencyposition'] == 'left') {
            $output = rtrim(rtrim(number_format($num, $row['st_decimalnumber'], '.', '.'), 0), '.');
        }elseif ($row['st_currencyposition'] == 'left-space') {
            $output = rtrim(rtrim(number_format($num, $row['st_decimalnumber'], '.', '.'), 0), '.');
        }elseif ($row['st_currencyposition'] == 'right') {
            $output = rtrim(rtrim(number_format($num, $row['st_decimalnumber'], '.', '.'), 0), '.');
        }elseif ($row['st_currencyposition'] == 'right-space') {
            $output = rtrim(rtrim(number_format($num, $row['st_decimalnumber'], '.', '.'), 0), '.');
        }

    }else{

        if ($row['st_currencyposition'] == 'left') {
            $output = number_format($num, $row['st_decimalnumber'], '.');
        }elseif ($row['st_currencyposition'] == 'left-space') {
            $output = number_format($num, $row['st_decimalnumber'], '.');
        }elseif ($row['st_currencyposition'] == 'right') {
            $output = number_format($num, $row['st_decimalnumber'], '.');
        }elseif ($row['st_currencyposition'] == 'right-space') {
            $output = number_format($num, $row['st_decimalnumber'], '.');
        }

    }

    return $output;
}

function memberSince($date){

    $timestamp = strtotime($date);
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $day = date('d', $timestamp);
    $month = date('m', $timestamp) - 1;
    $year = date('Y', $timestamp);

    //$date = "$day " . $months[$month] . " $year";
    $date = $months[$month] . " $year";
    return $date;
}

function getIcon($icon){

    if(empty($icon)){
        $output = "ti ti-minus";
        return $output;
    }else{
        $output = "ti ti-".$icon;
        return $output;
    }

}

function formatRating($value){

    if(!empty($value)){

        if($value <= 5){
            $starRating = number_format(echoOutput($value), 1);
            return $starRating;
        }else{
            return "5.0";
        }

    }else{
        return false;
    }

}

function getIp() {
    if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

        if(mb_strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            return trim(reset($ips));
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

    } else if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
        return $_SERVER['REMOTE_ADDR'];
    } else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    return '';
}

function getDeviceType($user_agent) {
    $mobileRegex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
    $tabletRegex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';

    if(preg_match_all($mobileRegex, $user_agent)) {
        return 'mobile';
    } else {

        if(preg_match_all($tabletRegex, $user_agent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
}

function getInfoByIp($ip){

    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

    return [
        'country' => ($ipdat->geoplugin_countryName ? $ipdat->geoplugin_countryName : null),
        'country_code' => ($ipdat->geoplugin_countryCode ? $ipdat->geoplugin_countryCode : null),
        'city' => ($ipdat->geoplugin_city ? $ipdat->geoplugin_city : null),
        'continent' => ($ipdat->geoplugin_continentName ? $ipdat->geoplugin_continentName : null),
        'currency_symbol' => ($ipdat->geoplugin_currencySymbol ? $ipdat->geoplugin_currencySymbol : null),
        'currency_code' => ($ipdat->geoplugin_currencyCode ? $ipdat->geoplugin_currencyCode : null),
        'timezone' => ($ipdat->geoplugin_timezone ? $ipdat->geoplugin_timezone : null)
    ];

}

function showStars($value){

    $totalRating = 5;
    $starRating = number_format($value ?? 0, 1);

    for ($i = 1; $i <= $totalRating; $i++) {
         if($starRating < $i ) {
            if((round($starRating) == $i)){
            echo "<i class='ion-ios-star-half'></i>";
            }else{
            echo "<i class='ion-ios-star-outline'></i>";
            }
         }else {
            echo "<i class='ion-ios-star'></i>";
         }
    }

}

function firstLetter($string){

    $output = $string[0];

    if(!empty($string) && !ctype_digit($output)){
    return $output;
    }else{
        return "A";
    }
}

function isExpired($date){

if(!empty($date)){

    if(getDateByTimeZone() < $date){
        return false;
    }else{
        return true;
    }
}else{
    return false;
}

}

function isNew($date){

    if(!empty($date)){

        $date1 = date_create($date);
        $date2 = date_create(getDateByTimeZone());
        $diff = date_diff($date1, $date2);

        $daydiff = abs(round((strtotime($date) - strtotime(getDateByTimeZone()))/86400));

        if($daydiff < 7){
            return true;
        }else{
            return false;
        }

}else{
    return false;
}
    
}

function timeLeft($date, $translation){

    if(!empty($date)){

            $date1 = date_create($date);
            $date2 = date_create(getDateByTimeZone());
            $diff = date_diff($date1, $date2);

            $hour = $diff->h;
            $minutes = $diff->i;

            $hourdiff = round((strtotime($date) - strtotime(getDateByTimeZone()))/3600, 1);

            if((int)$hourdiff  < 24 && (int)$hourdiff >= 1){
                return $hour.' '.$translation['tr_17'];
            }elseif((int)$hourdiff = 0 || (int)$hourdiff <= 1){
                return $minutes.' '.$translation['tr_18'];
            }else{
                return false;
            }

    }else{
        return false;
    }
}

function getCountDown($date){

    $sentence = connect()->prepare("SELECT st_timezone FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $datetime= date_create($date, timezone_open($row['st_timezone']));
    $fecha = $datetime->format(DateTime::ATOM); // Updated ISO8601
    return $fecha;

}

function insertTrack($connect, $itemId){

    $user = getUserInfo();

    $cookie_name = 'd_tracking_' . $itemId;

    if(isset($_COOKIE[$cookie_name]) && (int) $_COOKIE[$cookie_name] >= 3) {
        return;
    }

    $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);

    /* Don't track bots */
    if($whichbrowser->device->type == 'bot') {
        return;
    }

    $browser_name = $whichbrowser->browser->name ?? null;
    $os_name = $whichbrowser->os->name ?? null;
    $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
    $device_type = getDeviceType($_SERVER['HTTP_USER_AGENT']);
    $is_unique = isset($_COOKIE[$cookie_name]) ? 0 : 1;

    $getIp = getIp();

    try {
        $locationInfo = getInfoByIp($getIp);
    } catch(\Exception $exception) {
    }

    $country_name = isset($locationInfo) && isset($locationInfo['country']) ? $locationInfo['country'] : null;
    $country_code = isset($locationInfo) && isset($locationInfo['country_code']) ? $locationInfo['country_code'] : null;
    $city_name = isset($locationInfo) && isset($locationInfo['city']) ? $locationInfo['city'] : null;

    $referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;

    $statment = $connect->prepare("INSERT INTO tracking (
        track_id,
        track_user,
        track_item,
        track_country_name,
        track_country_code,
        track_city,
        track_os,
        track_browser,
        track_host,
        track_path,
        track_device,
        track_browser_language,
        track_is_unique,
        track_datetime)
        VALUES (null,
        :track_user,
        :track_item,
        :track_country_name,
        :track_country_code,
        :track_city,
        :track_os,
        :track_browser,
        :track_host,
        :track_path,
        :track_device,
        :track_browser_language,
        :track_is_unique,
        :track_datetime)");
    
        $statment->execute(array(
        ':track_user' => ($user ? $user['user_id'] : null),
        ':track_item' => $itemId,
        ':track_country_name' => $country_name,
        ':track_country_code' => $country_code ? strtolower($country_code):null,
        ':track_city' => $city_name,
        ':track_os' => $os_name,
        ':track_browser' => $browser_name,
        ':track_host' => ($referrer ? $referrer['host'] : null),
        ':track_path' => ($referrer ? $referrer['path'] : null),
        ':track_device' => $device_type,
        ':track_browser_language' => $browser_language,
        ':track_is_unique' => $is_unique,
        ':track_datetime' => getDateByTimeZone()
        ));

        /* Add click to the deal table as well */

        $sentence = $connect->prepare("UPDATE deals SET deal_clicks = (deal_clicks + 1) WHERE deal_id = :deal_id");
        $sentence->execute(array(
            ':deal_id' => $itemId
        ));

    $cookie_new_value = isset($_COOKIE[$cookie_name]) ? (int) $_COOKIE[$cookie_name] + 1 : 0;
    setcookie($cookie_name, (int) $cookie_new_value, time()+60*60*24*1);

}

function getTotalClicks($sellerId, $interval = NULL, $isunique = NULL, $item = NULL){

    $start_date = new DateTime("now", new DateTimeZone(getTimeZone()));
    $end_date = getDateByInterval($interval);

    $sqlQuery = "SELECT COUNT(*) AS total FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_author = :deal_author)";
    
    if($interval){

        if($interval && $interval != "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }elseif($interval && $interval == "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }

    }

    if($isunique == 1){
        $sqlQuery .= " AND track_is_unique = 1";
    }

    if((int) $item){
        $sqlQuery .= " AND track_item = $item";
    }
    
    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':deal_author' => $sellerId
    ));
    $row = $sentence->fetch();
    return $row['total'];
}

function getTopCountries($sellerId, $interval = Null){

    $start_date = new DateTime("now", new DateTimeZone(getTimeZone()));
    $end_date = getDateByInterval($interval);

    $sqlQuery = "SELECT tracking.*, count(1) as total FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_author = :deal_author)";
    
    if($interval){

        if($interval && $interval != "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }elseif($interval && $interval == "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }

    }

    $sqlQuery .= " GROUP BY track_country_code ORDER BY total DESC, track_datetime DESC LIMIT 11";

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':deal_author' => $sellerId
    ));
    return $sentence->fetchAll();
}

function getDeviceTypeClicks($sellerId, $itemId = Null, $interval = Null){

    $start_date = new DateTime("now", new DateTimeZone(getTimeZone()));
    $end_date = getDateByInterval($interval);

    $sqlQuery = "SELECT track_device, count(track_device) AS total FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_author = :deal_author)";

    if($interval){

        if($interval && $interval != "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }elseif($interval && $interval == "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }

    }

    if($itemId){
        $sqlQuery .= " AND track_item = $itemId";
    }

    $sqlQuery .= " GROUP BY track_device ORDER BY total DESC";

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':deal_author' => $sellerId
    ));
    return $sentence->fetchAll();
}

function getTopCountriesByItem($sellerId, $itemId, $interval = Null){

    $start_date = new DateTime("now", new DateTimeZone(getTimeZone()));
    $end_date = getDateByInterval($interval);

    $sqlQuery = "SELECT tracking.*, count(1) as total FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_author = :deal_author)";
    
    if($interval){

        if($interval && $interval != "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }elseif($interval && $interval == "today"){

            $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }

    }

    if($itemId){
        $sqlQuery .= " AND track_item = $itemId";
    }

    $sqlQuery .= " GROUP BY track_country_code ORDER BY total DESC, track_datetime DESC LIMIT 5";

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':deal_author' => $sellerId
    ));
    return $sentence->fetchAll();
}

function getItemById($userId, $itemId){

    $sentence = connect()->prepare("SELECT SQL_CALC_FOUND_ROWS deals.*, (SELECT AVG(rating) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS deal_rating, (SELECT COUNT(*) FROM reviews WHERE reviews.item = deals.deal_id AND reviews.status = 1) AS total_reviews, categories.*, subcategories.*, stores.*, locations.*, users.user_name AS author_name FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN reviews ON reviews.item = deals.deal_id AND reviews.status = 1 WHERE deals.deal_id = :deal_id AND deals.deal_author = :deal_author LIMIT 1");
    $sentence->execute(array(
        ':deal_id' => $itemId,
        ':deal_author' => $userId
    ));
    $row = $sentence->fetch();
    return $row;
}

function getGalleryByItem($connect, $itemId){

    $sentence = $connect->prepare("SELECT * FROM deals_gallery WHERE item = $itemId ORDER BY status DESC");
    $sentence->execute();
    return $sentence->fetchAll();
}

function isAlreadyInDraft($itemId){

    $sentence = connect()->prepare("SELECT * FROM drafts WHERE deal_id = $itemId");
    $sentence->execute();
    $row = $sentence->fetchAll();

    if ($row) {
        return true;
    }else{
        return false;
    }
}

function getDealSlug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM deals WHERE deal_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function getTotalItemsByUser($userId){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM deals WHERE deal_author = :deal_author AND deal_status != 4");
    $sentence->execute(array(
        ':deal_author' => $userId
    ));
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function getSellerById($userId){

    $sentence = connect()->prepare("SELECT * FROM sellers WHERE seller_user = :seller_user AND seller_status = 1 LIMIT 1");
    $sentence->execute(array(
        ':seller_user' => $userId
    ));
    $row = $sentence->fetch();
    return $row;
}

function getSellerSlug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM sellers WHERE seller_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

?>