<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../core.php';
require './functions.php';

$connect = connect($database);

if (!getItemId()) {

    header('Location: ./home.php');
    exit();
}

if (isLogged($connect)){

$userProfile = getUserInfo();
$userDetails = getUserInfoById($userProfile['user_id']);

if(!isSeller()){
    header('Location: ./denied.php');
}

$itemId = clearGetData(getItemId());

$itemDetails = getItemById($userProfile['user_id'], $itemId);

// checking if you are the author of the item

if($itemDetails['deal_author'] !== $userProfile['user_id']){
    header('Location: ./error.php');
    exit();
}

// checking if the item was rejected

if($itemDetails['deal_status'] == 4){
    header('Location: ./error.php');
    exit();
}

// checking the expiration date of the user's subscription

if(isExpiredSubscription()){
    header('Location: ./error.php');
    exit();
}

$statement = $connect->prepare("UPDATE deals SET deal_status = 1 WHERE deal_id = :deal_id AND deal_author = :deal_author");
$statement->execute(array(
    'deal_id' => $itemId,
    'deal_author' => $userProfile['user_id']
));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{
    
    header('Location: ./login.php');
}

?>