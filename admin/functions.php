<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

if(!isset($_SESSION)) { 
    session_start(); 
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../classes/vendor/autoload.php';
require_once __DIR__ . '/../classes/slugify.php';
require_once __DIR__ . '/../classes/fileuploader.php';
require_once __DIR__ . '/../translation.php';
require_once __DIR__ . '/lang/languages.php';
require_once __DIR__ . '/permissions.php';
require_once __DIR__ . '/languages.php';
require_once __DIR__ . '/countries.php';
require_once __DIR__ . '/timezones.php';
require_once __DIR__ . '/currencies.php';
require_once __DIR__ . '/email_fields.php';

$target_dir = "../../images/";
$siteTranslation = $langStrings[0];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use voku\helper\AntiXSS;

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

function getUserInfoById($id){

    $sentence = connect()->prepare("SELECT users.*, sellers.seller_logo, sellers.seller_title  FROM users LEFT JOIN sellers ON sellers.seller_user = users.user_id WHERE user_status = 1 AND user_id = :user_id LIMIT 1");
    $sentence->execute(array(
        ':user_id' => $id
    ));
    $row = $sentence->fetch();
    return $row;
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

function check_permission($permission){

    if($permission){

        $userEmail = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_EMAIL);

        $sentence = connect()->prepare("SELECT users.user_email, users.user_role, roles.role_permissions AS role_permissions FROM users, roles WHERE users.user_role = roles.role_id AND users.user_email = :email"); 
        $sentence->execute(array(
            ":email" => $userEmail
        ));

        $row = $sentence->fetch();

        if(!in_array($permission, json_decode($row['role_permissions']))){
            return false;
        }else{
            return true;
        }

    }else{
        return false;
    }
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

function check_session(){

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

function isAdmin(){

    if (isset($_SESSION['user_email'])) {

        $emailSession = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_EMAIL);

        $sentence = connect()->prepare("SELECT * FROM users WHERE user_email = :user_email AND user_status = 1 AND user_role = 1 LIMIT 1"); 
        $sentence->execute(array(
            ":user_email" => $emailSession
        ));
        $row = $sentence->fetch();

        if ($row) {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }

}

function echoOutput($data){
    $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');

    if (empty($data)) {
        return "-";
    }else{
        return $data;
    }
}

function cleardata($data){
    $antiXss = new AntiXSS();
    $data = $antiXss->xss_clean($data);
    return $data;
}

function getId(){
    
    return isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : NULL;
}

function get_user_information(){

    if (isset($_SESSION['user_email'])) {

    $emailSession = filter_var(strtolower($_SESSION['user_email']), FILTER_SANITIZE_EMAIL);

    $sentence = connect()->prepare("SELECT * FROM users WHERE user_email = :user_email LIMIT 1");
    $sentence->execute(array(
        ":user_email" => $emailSession
    ));
    $row = $sentence->fetch();
    return ($row) ? $row : false;

    }else{
        return false;
    }

}

function currentPage(){

    return isset($_GET['p']) ? (int)$_GET['p'] : 1;
}

function goToPage($parameter, $value) { 
    $params = array(); 
    $output = "?"; 
    $firstRun = true; 
    foreach($_GET as $key=>$val) { 
        if($key != $parameter) { 
            if(!$firstRun) { 
                $output .= "&"; 
            } else { 
                $firstRun = false; 
            } 
            $output .= $key."=".urlencode($val); 
        } 
    } 

    if(!$firstRun) 
        $output .= "&"; 
    $output .= $parameter."=".urlencode($value); 
    return htmlentities($output); 
} 

// MENUS ---------------------------------------

function get_all_menus(){

    $sentence = connect()->prepare("SELECT * FROM menus"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_menu_per_id($id_menu){
    $sentence = connect()->prepare("SELECT * FROM menus WHERE menu_id = :menu_id LIMIT 1");
    $sentence->execute(array(
        ":menu_id" => $id_menu
    ));
    $row = $sentence->fetch();
    return ($row) ? $row : false;

}

function get_navigations(){

    $sentence = connect()->prepare("SELECT * FROM navigations ORDER BY navigation_order ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_navigations_by_menu($id_menu){

    $sentence = connect()->prepare("SELECT navigations.navigation_id, COALESCE(pages.page_slug, navigations.navigation_url) AS navigation_url, COALESCE(pages.page_title, navigations.navigation_label) AS navigation_label, navigations.navigation_type FROM navigations LEFT JOIN pages ON page_id = navigations.navigation_page WHERE navigation_menu = :menu_id ORDER BY navigation_order ASC"); 
    $sentence->execute(array(
        ":menu_id" => $id_menu
    ));
    return $sentence->fetchAll();
}

// PAGES ---------------------------------------

function is_default_page($page_id){

    $sentence = connect()->prepare("SELECT * FROM settings WHERE
    '".$page_id."' IN (SELECT st_defaultsearchpage FROM settings)
    OR '".$page_id."' IN (SELECT st_defaultprivacypage FROM settings)
    OR '".$page_id."' IN (SELECT st_defaulttermspage FROM settings)
    OR '".$page_id."' IN (SELECT st_defaultcategoriespage FROM settings)
    OR '".$page_id."' IN (SELECT st_defaultstorespage FROM settings)
    OR '".$page_id."' IN (SELECT st_defaultlocationspage FROM settings)
    OR '".$page_id."' IN (SELECT st_defaultpricingpage FROM settings)
    "); 
    $sentence->execute();
    $sentence->fetchAll();
    $exist = $sentence->rowCount();

    if ($exist > 0) {
        return true;
    }else{
        return false;
    }
}

function get_default_page($page){

    if($page){
        $sentence = connect()->prepare("SELECT * FROM pages WHERE page_status = 1 AND page_id = :page_id LIMIT 1");
        $sentence->execute(array(
            ":page_id" => $page
        ));
        $row = $sentence->fetch();
        return $row;

    }else{
        return NULL;
    }
}

function get_default_page_slug($page){

        $sentence = connect()->prepare("SELECT * FROM pages WHERE page_status = 1 AND page_id = :page_id LIMIT 1");
        $sentence->execute(array(
            ":page_id" => $page
        ));
        $row = $sentence->fetch();
        return $row['page_slug'];

}

function getSocialMedia(){
    
    $sentence = connect()->prepare("SELECT st_facebook,st_twitter,st_youtube,st_instagram,st_linkedin,st_whatsapp FROM settings"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_page_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM pages WHERE page_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_pages_by_template($type){
    $sentence = connect()->prepare("SELECT * FROM pages WHERE page_template = '".$type."'"); 
    $sentence->execute();
    $row = $sentence->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

function totalPages($items_per_page){

    $total_items = connect()->prepare("SELECT COUNT(*) AS total FROM pages");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_pages(){

    $sql = "SELECT * FROM pages"; 
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll(PDO::FETCH_ASSOC);
}

function get_page_per_id($id_page){
    $sentence = connect()->query("SELECT pages.* FROM pages WHERE page_id = $id_page LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function pages_total(){

    $total_numbers = connect()->prepare("SELECT * FROM pages");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

// SUBCATEGORIES  ---------------------------------------

function subcategories_total(){

    $total_numbers = connect()->prepare("SELECT * FROM subcategories");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_all_subcategories(){

    $sql = "SELECT subcategories.*, categories.category_title AS category_title FROM subcategories LEFT JOIN categories ON categories.category_id = subcategories.subcategory_parent ORDER BY subcategory_id DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_subcategory_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM subcategories WHERE subcategory_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_subcategories_per_parent($category){
    $sentence = connect()->query("SELECT * FROM subcategories WHERE subcategory_parent = $category");
    $sentence = $sentence->fetchAll();
    return ($sentence) ? $sentence : false;
}

function get_subcategory_per_id($id_subcategory){
    $sentence = connect()->query("SELECT * FROM subcategories WHERE subcategory_id = $id_subcategory LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

// ROLES  ---------------------------------------

function get_role_per_id($id_role){
    $sentence = connect()->query("SELECT * FROM roles WHERE role_id = $id_role LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function get_all_roles(){

    $sql = "SELECT * FROM roles ORDER BY role_id DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// CATEGORIES  ---------------------------------------

function categories_total(){

    $total_numbers = connect()->prepare("SELECT * FROM categories");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_all_categories(){

    $sql = "SELECT * FROM categories ORDER BY category_id DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_category_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM categories WHERE category_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_category_per_id($id_category){
    $sentence = connect()->query("SELECT * FROM categories WHERE category_id = $id_category LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

// SLIDERS  ---------------------------------------

function sliders_total(){

    $total_numbers = connect()->prepare("SELECT * FROM sliders");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_all_sliders(){

    $sql = "SELECT * FROM sliders ORDER BY slider_id DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
    }

    
    function get_slider_per_id($id_slider){
    $sentence = connect()->query("SELECT * FROM sliders WHERE slider_id = $id_slider LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
    }


// STORES  ---------------------------------------

function stores_total(){

    $total_numbers = connect()->prepare("SELECT * FROM stores");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_all_stores(){

    $sql = "SELECT * FROM stores ORDER BY store_id DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_store_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM stores WHERE store_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_store_per_id($id_store){
    $sentence = connect()->query("SELECT * FROM stores WHERE store_id = $id_store LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

// LOCATIONS  ---------------------------------------

function locations_total(){

    $total_numbers = connect()->prepare("SELECT * FROM locations");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_all_locations(){

    $sql = "SELECT * FROM locations ORDER BY location_id DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_location_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM locations WHERE location_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_location_per_id($id_location){
    $sentence = connect()->query("SELECT * FROM locations WHERE location_id = $id_location LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

// COMMENTS/RATINGS/REVIEWS  ---------------------------------------

function comments_total(){

    $total_numbers = connect()->prepare("SELECT * FROM reviews");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_all_comments(){

    $sentence = connect()->prepare("SELECT reviews.*, users.user_name AS user_name, users.user_id AS user_id FROM reviews LEFT JOIN users ON users.user_id = reviews.user"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// PLANS  ---------------------------------------

function get_plan_per_id($id_plan){
    $sentence = connect()->query("SELECT * FROM plans WHERE plans.plan_id = $id_plan LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function get_all_plans(){

    $sql = "SELECT * FROM plans";
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// PAYMENTS  ---------------------------------------

function get_payment_per_id($id_payment){
    $sentence = connect()->query("SELECT payments.*, users.*, plans.*, codes.* FROM payments LEFT JOIN users ON users.user_id = payments.payment_user_id LEFT JOIN plans ON plans.plan_id = payments.payment_plan_id LEFT JOIN codes ON payments.payment_code = codes.code_coupon WHERE payments.payment_id = $id_payment LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function get_latest_payments($limit = 5, $interval = null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT payments.*, users.*, plans.* FROM payments LEFT JOIN users ON users.user_id = payments.payment_user_id LEFT JOIN plans ON plans.plan_id = payments.payment_plan_id";
    
    if($interval){

        if(getInterval() && getInterval() != "today"){

            $sqlQuery .= " WHERE (payment_date BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }elseif(getInterval() && getInterval() == "today"){

            $sqlQuery .= " WHERE (payment_date BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

        }

    }

    $sqlQuery .= " ORDER BY payments.payment_date DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }
    
    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    return $sentence->fetchAll();

}

function get_frequency_text($frequency){
    if($frequency == 'monthly'){
        return 'Monthly';
    }else if($frequency == 'halfyear' || $frequency == 'biannually'){
        return '6 Months';
    }else if($frequency == 'annual'){
        return 'Annual';
    }
}

function get_all_payments(){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT payments.*, users.*, plans.* FROM payments LEFT JOIN users ON users.user_id = payments.payment_user_id LEFT JOIN plans ON plans.plan_id = payments.payment_plan_id";
    
    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (payment_date BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (payment_date BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " ORDER BY payments.payment_date DESC";

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    return $sentence->fetchAll();

}

function payments_total(){

    $total_numbers = connect()->prepare('SELECT * FROM payments');
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_earnings_by_interval(){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT SUM(payment_total_amount) AS total_earnings, COUNT(payment_id) AS total_payments FROM payments WHERE payment_status = 1";
    
    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (payment_date BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (payment_date BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " ORDER BY payments.payment_date DESC";

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    return $sentence->fetch();

}

function get_taxes_by_ids($plan_taxes){

    $plan_taxes = json_decode($plan_taxes);

    if(empty($plan_taxes)) {
        return null;
    }

    $plan_taxes = implode(',', $plan_taxes);

    $sentence = connect()->prepare("SELECT * FROM taxes WHERE tax_id IN ({$plan_taxes})");
    $sentence->execute();
    return $sentence->fetchAll();
}

function calc_taxes_by_price($price, $percentage){

$percentage = $percentage;
$price = $price;

$new_width = ($percentage / 100) * $price;

return $new_width;

}

// DEALS  ---------------------------------------

function get_total_drafts(){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM drafts");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_total_pending_coupons(){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM coupons WHERE coupon_status = 3");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_total_pending_deals(){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM deals WHERE deal_status = 3");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_submissions_log(){
    $sentence = connect()->query("SELECT submissions_log.*, deals.deal_title AS deal_title, (SELECT user_name FROM users WHERE user_id = submissions_log.author_id) AS author_name, (SELECT user_name FROM users WHERE user_id = submissions_log.reviewer_id) AS reviewer_name FROM submissions_log LEFT JOIN deals ON deals.deal_id = submissions_log.item ORDER BY submissions_log.created DESC");
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_drafts(){

    $sql = "SELECT drafts.*, users.user_name AS author_name FROM drafts LEFT JOIN users ON drafts.deal_author = users.user_id ORDER BY drafts.deal_updated DESC";

    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_draft_per_id($id_deal){
    $sentence = connect()->query("SELECT drafts.*, submissions_log.*, categories.category_title AS category_title, stores.store_title AS store_title, subcategories.subcategory_title AS subcategory_title, locations.location_title AS location_title, users.user_name AS author_name FROM drafts LEFT JOIN submissions_log ON drafts.deal_id = submissions_log.item LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id WHERE drafts.deal_id = $id_deal ORDER BY submissions_log.created DESC LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function get_drafts_gallery($item){

    $sentence = connect()->prepare("SELECT * FROM deals_gallery WHERE item = $item AND status = 0");
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_deals($limit = null, $status = null, $user = null){

    $sql = "SELECT deals.*, categories.category_title AS category_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id";
   
    if($status && is_int($status)){
        $sql .= " WHERE deals.deal_status = $status";
    }

    $sql .= " GROUP BY deals.deal_id ORDER BY deals.deal_created DESC";

    if($limit && is_int($limit)){
        $sql .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_coupons($limit = null, $status = null, $user = null){

    $sql = "SELECT coupons.*, categories.category_title AS category_title, stores.store_title AS store_title, users.user_name AS author_name FROM coupons LEFT JOIN categories ON coupon_category = categories.category_id LEFT JOIN stores ON coupon_store = stores.store_id LEFT JOIN users ON coupon_author = users.user_id";
   
    if($status && is_int($status)){
        $sql .= " WHERE coupons.coupon_status = $status";
    }

    $sql .= " GROUP BY coupons.coupon_id ORDER BY coupons.coupon_created DESC";

    if($limit && is_int($limit)){
        $sql .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_top_deals($limit = null){

    $sql = "SELECT deals.*, categories.category_title AS category_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id GROUP BY deals.deal_id ORDER BY deals.deal_clicks DESC";
    
    if($limit && is_int($limit)){
        $sql .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_all_deals_by_user($user){

    $sql = "SELECT deals.*, categories.category_title AS category_title, stores.store_title AS store_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id WHERE deals.deal_author = :deal_author GROUP BY deals.deal_id ORDER BY deals.deal_created DESC";
    $sentence = connect()->prepare($sql); 
    $sentence->execute(array(
        ':deal_author' => $user
    ));
    return $sentence->fetchAll();
}

function get_deal_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM deals WHERE deal_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_coupon_slug($slug){

    $sentence = connect()->prepare("SELECT COUNT(*) AS total FROM coupons WHERE coupon_slug LIKE '$slug%'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function get_deals_gallery($item){

    $sentence = connect()->prepare("SELECT * FROM deals_gallery WHERE item = $item");
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_coupons_gallery($item){

    $sentence = connect()->prepare("SELECT * FROM coupons_gallery WHERE item = $item");
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_top_deals_by_interval($limit = null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sql = "SELECT tracking.*, deals.*, COUNT(*) AS num FROM tracking JOIN deals ON deals.deal_id = track_item";
    
    if(getInterval() && getInterval() != "today"){

        $sql .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sql .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sql .= " GROUP BY track_item ORDER BY num DESC";

    if($limit && is_int($limit)){
        $sql .= " LIMIT $limit";
    }
    
    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_deal_clicks_by_country($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_country_name AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_country_code ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deal_clicks_by_city($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_city AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_city ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deal_clicks_by_referrers($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_host AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_host ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deal_clicks_by_browsers($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_browser AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_browser ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deal_clicks_by_devices($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_device AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_device ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deal_clicks_by_os($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_os AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_os ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deal_clicks_by_languages($id_deal, $limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_browser_language AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    $sqlQuery .= " GROUP BY track_browser_language ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute(array(
        ':track_item' => $id_deal
    ));
    
    return $sentence->fetchAll();
}

function get_deals_count_by_status($status = 1, $exclusive = null, $featured = null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT count(*) AS total FROM deals";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (deal_created BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (deal_created BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    if($status && is_int($status)){
        $sqlQuery .= " AND deal_status = $status";
    }

    if($exclusive && is_int($exclusive)){
        $sqlQuery .= " AND deal_exclusive = $exclusive";
    }

    if($featured && is_int($featured)){
        $sqlQuery .= " AND deal_featured = $featured";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    $total_items = $sentence->fetch()['total'];
    return $total_items;
}

function get_total_clicks($unique = null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT COUNT(*) AS num, sum(CASE WHEN track_is_unique = '1' then 1 else 0 end) AS uniquenum FROM tracking";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    $total_items = $sentence->fetch();

    if($unique){
        return ($total_items['uniquenum'] ? $total_items['uniquenum'] : 0);
    }else{
        return $total_items['num'];
    }
}

function get_total_clicks_by_interval(){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, DATE_FORMAT(track_datetime, '%Y-%m') AS months, DATE_FORMAT(track_datetime, '%Y-%m-%d') AS dias, COUNT(*) AS num, sum(case when track_is_unique = '1' then 1 else 0 end) AS uniquenum FROM tracking";
            
    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }

    if(getInterval() && getInterval() == "last6months" || getInterval() == "lastyear" || getInterval() == "alltime"){
        $sqlQuery .= " GROUP BY months ORDER BY months DESC";
    }else{
        $sqlQuery .= " GROUP BY dias ORDER BY dias DESC";
    }

    $sentence = connect()->prepare($sqlQuery);

    $sentence->execute();

    $results = $sentence->fetchAll(PDO::FETCH_ASSOC);

    if(!$results){
        $data = array();
        return json_encode($data);
    }else{
        foreach ($results as $row) {

            $data[] = array(
                'label' => (new \DateTime($row['track_datetime']))->format(getInterval() == "last30days" || getInterval() == "last7days" ? 'd-m' : 'd-m-Y'),
                'clicks' => $row['num'],
                'uniqueclicks' => $row['uniquenum']
            );
        }
        
        return json_encode($data);

    }
}

function get_deal_clicks_by_interval($id_deal){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, DATE_FORMAT(track_datetime, '%Y-%m') AS months, DATE_FORMAT(track_datetime, '%Y-%m-%d') AS dias, COUNT(*) AS num, sum(case when track_is_unique = '1' then 1 else 0 end) AS uniquenum FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_id = :track_item)";
            
    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    if(getInterval() && getInterval() == "last6months" || getInterval() == "lastyear" || getInterval() == "alltime"){
        $sqlQuery .= " GROUP BY months ORDER BY months DESC";
    }else{
        $sqlQuery .= " GROUP BY dias ORDER BY dias DESC";
    }

    $sentence = connect()->prepare($sqlQuery);

    $sentence->execute(array(
        ':track_item' => $id_deal
    ));

    $results = $sentence->fetchAll(PDO::FETCH_ASSOC);

    if(!$results){
        $data = array();
        return json_encode($data);
    }else{
        foreach ($results as $row) {

            $data[] = array(
                'label' => (new \DateTime($row['track_datetime']))->format(getInterval() == "last30days" || getInterval() == "last7days" ? 'd-m' : 'd-m-Y'),
                'clicks' => $row['num'],
                'uniqueclicks' => $row['uniquenum']
            );
        }
        
        return json_encode($data);

    }
}

function get_deal_per_id($id_deal){
    $sentence = connect()->query("SELECT deals.*, categories.category_title AS category_title, stores.store_title AS store_title, subcategories.subcategory_title AS subcategory_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id WHERE deals.deal_id = $id_deal LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function get_coupon_per_id($id_coupon){
    $sentence = connect()->query("SELECT coupons.*, categories.category_title AS category_title, stores.store_title AS store_title, subcategories.subcategory_title AS subcategory_title, users.user_name AS author_name FROM coupons LEFT JOIN subcategories ON coupon_subcategory = subcategories.subcategory_id LEFT JOIN categories ON coupon_category = categories.category_id LEFT JOIN stores ON coupon_store = stores.store_id LEFT JOIN users ON coupon_author = users.user_id WHERE coupons.coupon_id = $id_coupon LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function get_pending_deal_per_id($id_deal){
    $sentence = connect()->query("SELECT deals.*, categories.category_title AS category_title, stores.store_title AS store_title, subcategories.subcategory_title AS subcategory_title, locations.location_title AS location_title, users.user_name AS author_name FROM deals LEFT JOIN subcategories ON deal_subcategory = subcategories.subcategory_id LEFT JOIN categories ON deal_category = categories.category_id LEFT JOIN stores ON deal_store = stores.store_id LEFT JOIN locations ON deal_location = locations.location_id LEFT JOIN users ON deal_author = users.user_id WHERE deals.deal_id = $id_deal AND deals.deal_status = 3 OR deals.deal_status = 5 LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function deals_total(){

    $total_numbers = connect()->prepare('SELECT * FROM deals');
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function total_deals_by_user($user){

    $total_numbers = connect()->prepare("SELECT * FROM deals WHERE deal_author = $user");
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

// ADS ---------------------------------------

function get_all_ads(){

    $sentence = connect()->prepare("SELECT * FROM ads"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_ad_per_id($id_ad){
    $sentence = connect()->query("SELECT * FROM ads WHERE ad_id = $id_ad LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

// TAXES ---------------------------------------

function get_all_taxes(){

    $sentence = connect()->prepare("SELECT * FROM taxes ORDER BY tax_created DESC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function get_tax_per_id($id_tax){
    $sentence = connect()->query("SELECT * FROM taxes WHERE tax_id = $id_tax LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

// SELLERS ---------------------------------------

function get_all_sellers(){

    $sentence = connect()->prepare("SELECT sellers.*, users.* FROM sellers LEFT JOIN users ON sellers.seller_user = users.user_id ORDER BY sellers.seller_created DESC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}


function get_seller_per_id($id_seller){
    $sentence = connect()->query("SELECT * FROM sellers WHERE seller_id = $id_seller LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function sellers_total(){

    $total_numbers = connect()->prepare('SELECT * FROM sellers');
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

// CODES ---------------------------------------

function get_active_codes(){

    $sentence = connect()->prepare("SELECT * FROM codes WHERE code_status = 1 ORDER BY code_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function totalCodes($items_per_page){

    $total_items = connect()->prepare("SELECT COUNT(*) AS total FROM codes");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function get_all_codes(){

    $sentence = connect()->prepare("SELECT codes.*, (SELECT COUNT(*) FROM payments WHERE payments.payment_code = codes.code_coupon AND payment_status = 1) AS totalused FROM codes"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_code_per_id($id_code){
    $sentence = connect()->query("SELECT * FROM codes WHERE codes.code_id = $id_code LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function codes_total(){

    $total_numbers = connect()->prepare('SELECT * FROM codes');
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

// USERS ---------------------------------------

function get_active_users(){

    $sentence = connect()->prepare("SELECT * FROM users WHERE user_status = 1 ORDER BY user_id ASC"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_active_paid_users(){
    $sentence = connect()->query("SELECT COUNT(user_id) AS total FROM users WHERE user_plan_expiration_date >= CURDATE()");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function totalUsers($items_per_page){

    $total_items = connect()->prepare("SELECT COUNT(*) AS total FROM users");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];

    $number_pages = ceil($total_items / $items_per_page);
    return $number_pages;
}

function total_properties_by_user($id_user){

    $total_items = connect()->prepare("SELECT COUNT(*) AS total FROM properties WHERE pt_agent = $id_user");
    $total_items->execute();
    $total_items = $total_items->fetch()['total'];
    return $total_items;    

}

function get_all_users($limit = null){

    $sql = "SELECT users.*, roles.role_permissions AS role_permissions FROM users LEFT JOIN roles ON users.user_role = roles.role_id ORDER BY users.user_created DESC";

    if($limit && is_int($limit)){
        $sql .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sql); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function get_user_per_id($id_user){
    $sentence = connect()->query("SELECT users.*,roles.role_permissions AS role_permissions, roles.role_title AS role_title FROM users LEFT JOIN roles ON users.user_role = roles.role_id WHERE users.user_id = $id_user LIMIT 1");
    $sentence = $sentence->fetch();
    return ($sentence) ? $sentence : false;
}

function users_total(){

    $total_numbers = connect()->prepare('SELECT * FROM users');
    $total_numbers->execute(array());
    $total_numbers->fetchAll();
    $total = $total_numbers->rowCount();
    return $total;
}

function get_total_users($verified = null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT COUNT(*) AS num, sum(CASE WHEN user_verified = '1' then 1 else 0 end) AS verified FROM users";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (user_created BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (user_created BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    $total_items = $sentence->fetch();

    if($verified){
        return ($total_items['verified'] ? $total_items['verified'] : 0);
    }else{
        return $total_items['num'];
    }
}

function get_total_sellers(){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT COUNT(*) AS num FROM sellers";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (seller_created BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (seller_created BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    $total_items = $sentence->fetch();
    return $total_items['num'];
}

// SUBSCRIBERS ---------------------------------------

function totalSubscribers(){

    $total_items = connect()->prepare("SELECT COUNT(*) AS total FROM subscribers");
    $total_items->execute();
    return $total_items = $total_items->fetch()['total'];

}

function get_all_subscribers(){

    $sentence = connect()->prepare("SELECT * FROM subscribers"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

// EMAILS ---------------------------------------

function get_etemplate_by_id($id){

    $sentence = connect()->prepare("SELECT * FROM emailtemplates WHERE email_id = '".$id."'");
    $sentence->execute();
    $row = $sentence->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function get_all_email_templates(){

    $sentence = connect()->prepare("SELECT * FROM emailtemplates"); 
    $sentence->execute();
    return $sentence->fetchAll();
}

function getEmailTemplate($id){

    if (!empty($id) && (int)($id)) {

        $q = connect()->query("SELECT * FROM emailtemplates WHERE email_id = ".$id." LIMIT 1");
        $f = $q->fetch();
        $result = $f;

        return $result;

    }else{

        return null;
    }  
}

function checkMail($settings){

    $smtp = new SMTP;

//Enable connection-level debug output
//$smtp->do_debug = SMTP::DEBUG_CONNECTION;

    $result = "";

    try {
    //Connect to an SMTP server
        if (!$smtp->connect($settings['st_smtphost'], $settings['st_smtpport'])) {
         $result = "Connect failed";
     }
    //Say hello
     if (!$smtp->hello(gethostname())) {
        $result = "EHLO failed";
    }
    //Get the list of ESMTP services the server offers
    $e = $smtp->getServerExtList();
    //If server can do TLS encryption, use it
    if (is_array($e) && array_key_exists($settings['st_smtpencrypt'], $e)) {
        $tlsok = $smtp->startTLS();
        if (!$tlsok) {
            $result = 'Failed to start encryption: ' . $smtp->getError()['error'];
        }
        //Repeat EHLO after STARTTLS
        if (!$smtp->hello(gethostname())) {
            $result = 'EHLO (2) failed: ' . $smtp->getError()['error'];
        }
        //Get new capabilities list, which will usually now include AUTH if it didn't before
        $e = $smtp->getServerExtList();
    }
    //If server supports authentication, do it (even if no encryption)
    if (is_array($e) && array_key_exists('AUTH', $e)) {
        if ($smtp->authenticate($settings['st_smtpemail'], $settings['st_smtppassword'])) {
        } else{
            $result = 'Authentication failed: ' . $smtp->getError()['error'];
        }
    }

} catch (Exception $e) {
    $result = 'SMTP error: ' . $e->getMessage();
}

return $result;

}

function sendMail($array_content, $email_content, $destinationmail, $fromName, $subject, $isHtml, $settings) {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                          
        $mail->Host       = $settings['st_smtphost'];                
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = $settings['st_smtpemail'];              
        $mail->Password   = $settings['st_smtppassword'];                             
        $mail->SMTPSecure = $settings['st_smtpencrypt'];
        $mail->Port       = $settings['st_smtpport'];

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
        if (!$mail->send())
        {
            $result = $mail->ErrorInfo;
        }
        else 
        {
            $result = TRUE;
        }

        return $result;

    } catch (Exception $e) {
       return null;
   }

} 

// OTHERS ---------------------------------------

function get_settings(){

    $sentence = connect()->prepare("SELECT * FROM settings"); 
    $sentence->execute();
    $row = $sentence->fetch();
    return $row;
}

function get_theme(){

    $sentence = connect()->prepare("SELECT * FROM theme"); 
    $sentence->execute();
    return $sentence->fetch();
}

function FormatDate($date){

    $sentence = connect()->prepare("SELECT st_dateformat FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $newDate = date($row['st_dateformat'], strtotime($date));
    return $newDate;
}

function hexToRgb($hex, $alpha = false) {
 $hex = str_replace('#', '', $hex);
 $length = strlen($hex);
 $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
 $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
 $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
 if ( $alpha ) {
  $rgb['a'] = $alpha;
}

return implode(array_keys($rgb)) . '(' . implode(', ', $rgb) . ')';
}

function getPriceDeprecated($price){

    $sentence = connect()->prepare("SELECT * FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $output = "";

    if ($row['st_currencyposition'] == 'left') {
        $output = $row['st_currency'] . number_format($price, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'left-space') {
        $output = $row['st_currency'] .' '. number_format($price, 0, '', $row['st_decimalseparator']);
    }elseif ($row['st_currencyposition'] == 'right') {
        $output = number_format($price, 0, '', $row['st_decimalseparator']) . $row['st_currency'];
    }elseif ($row['st_currencyposition'] == 'right-space') {
        $output = number_format($price, 0, '', $row['st_decimalseparator']) .' '. $row['st_currency'];
    }else{

    }

    return $output;
}

function getPrice($price){

    $sentence = connect()->prepare("SELECT * FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    $output = "";

    if ($row['st_currencyposition'] == 'left') {
        $output = $row['st_currency'] . formatPrice($price, $row['st_decimalseparator']);
    } elseif ($row['st_currencyposition'] == 'left-space') {
        $output = $row['st_currency'] .' '. formatPrice($price, $row['st_decimalseparator']);
    } elseif ($row['st_currencyposition'] == 'right') {
        $output = formatPrice($price, $row['st_decimalseparator']) . $row['st_currency'];
    } elseif ($row['st_currencyposition'] == 'right-space') {
        $output = formatPrice($price, $row['st_decimalseparator']) .' '. $row['st_currency'];
    } else {
        // Handle other cases if needed
    }

    return $output;
}

function formatPrice($price, $decimalSeparator) {
    // Check if $price is not null before calling number_format
    if ($price !== null) {
        return number_format($price, 0, '', $decimalSeparator);
    } else {
        return 0; // or handle the case when $price is null in another way
    }
}


function getPricePayment($price, $currency){

    $sentence = connect()->prepare("SELECT * FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    return number_format($price, 2, $row['st_decimalseparator']) .' '. $currency;

}

function allowedFileExt(){
    return array("jpg", "jpeg", "png", "gif");
}

function allowedFileSize(){

    /*
    
    1Mb = 1048576;
    2Mb = 2097152;
    3Mb = 3145728;
    4Mb = 4194304;

    */

    return 1048576;
}

function getInterval(){

    $interval = isset($_GET['interval']) && !empty($_GET['interval']) && $_GET['interval'] ? cleardata($_GET['interval']) : "last7days";

    $intervals = array("today", "yesterday", "last7days", "last30days", "last6months", "lastyear", "alltime");

    if (in_array($interval, $intervals)) {

            return $interval;
            
        }else{
   
        return false;
    }
    
}

function getStatsFor(){

    $for = isset($_GET['for']) && !empty($_GET['for']) && $_GET['for'] ? cleardata($_GET['for']) : NULL;

    $stats = array("referrers", "countries", "cities", "languages", "os", "browsers", "devices");

    if (in_array($for, $stats)) {

            return $for;
            
        }else{
   
        return false;
    }
    
}

function get_date_by_interval($interval){

    $date = new DateTime("now", new DateTimeZone(get_timezone()));

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

function get_timezone(){

    $sentence = connect()->prepare("SELECT st_timezone FROM settings");
    $sentence->execute();
    $row = $sentence->fetch();

    if(!empty($row['st_timezone'])){

        return $row['st_timezone'];

    }else{

        return "UTC";
    }

}

function get_date_by_timezone($format = null){

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


function get_language_from_locale($array, $locale) {

    if(!isset($array[$locale])) {
        return $locale;
    } else {
        return $array[$locale];
    }
}

function get_top_countries($limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_country_name AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    $sqlQuery .= " GROUP BY track_country_code ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    
    return $sentence->fetchAll();
}

function get_top_cities($limit = Null){

    $start_date = new DateTime("now", new DateTimeZone(get_timezone()));
    $end_date = get_date_by_interval(getInterval());

    $sqlQuery = "SELECT tracking.*, count(*) AS total, track_city AS title, sum(case when track_is_unique = '1' then 1 else 0 end) AS totalunique FROM tracking";

    if(getInterval() && getInterval() != "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

    }elseif(getInterval() && getInterval() == "today"){

        $sqlQuery .= " WHERE (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";


    }

    $sqlQuery .= " GROUP BY track_city ORDER BY total DESC, track_datetime DESC";

    if($limit && is_int($limit)){
        $sqlQuery .= " LIMIT $limit";
    }

    $sentence = connect()->prepare($sqlQuery);
    $sentence->execute();
    
    return $sentence->fetchAll();
}

?>