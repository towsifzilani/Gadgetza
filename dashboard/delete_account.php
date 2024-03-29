<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../core.php';
require './functions.php';

$connect = connect($database);

if (isLogged($connect)){

$userProfile = getUserInfo();
$userDetails = getUserInfoById($userProfile['user_id']);

/* Cancel subscriptionsñ */
cancelUserSubscription($settings, $userDetails['user_id']);

$statement_1 = $connect->prepare("DELETE FROM sellers WHERE seller_user = :seller_user");
$statement_1->execute(array('seller_user' => $userDetails['user_id']));

$statement_2 = $connect->prepare("DELETE FROM deals WHERE deal_author = :deal_author");
$statement_2->execute(array('deal_author' => $userDetails['user_id']));

$statement_3 = $connect->prepare("DELETE FROM favorites WHERE user = :user");
$statement_3->execute(array('user' => $userDetails['user_id']));

$statement_4 = $connect->prepare("DELETE FROM reviews WHERE user = :user");
$statement_4->execute(array('user' => $userDetails['user_id']));

$statement = $connect->prepare("DELETE FROM users WHERE user_id = :user_id");
$statement->execute(array('user_id' => $userDetails['user_id']));

/*session_destroy();
$_SESSION = array ();*/

    header('Location: ./home.php');

}else{
    
    header('Location: ./login.php');
}

?>