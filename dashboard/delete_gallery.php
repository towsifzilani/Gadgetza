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

// checking the expiration date of the user's subscription

if(isExpiredSubscription()){
    header('Location: ./error.php');
    exit();
}

$statement = connect()->prepare("DELETE FROM deals_gallery WHERE id = :id");
$statement->execute(array('id' => $itemId));

header('Location: ' . $_SERVER['HTTP_REFERER']);

}else{
    
    header('Location: ./login.php');
}

?>