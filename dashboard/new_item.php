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
$planDetails = getPlanById($connect, $userDetails['user_plan']);
$userTotalOUploaded = getTotalItemsByUser($userDetails['user_id']);

if(!isSeller()){
    header('Location: ./denied.php');
}

// checking the expiration date of the user's subscription

if(isExpiredSubscription()){
    header('Location: ./home.php');
    exit();
}

$getLocations = getLocations($connect);
$getStores = getStores($connect);
$getCategories = getCategories($connect);

require './views/header.view.php';
require './views/new_item.view.php';
require './views/footer.view.php';

}else{
    
    header('Location: ./login.php');
}

?>