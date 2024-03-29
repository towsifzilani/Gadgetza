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

if(!isSeller()){
    header('Location: ./denied.php');
}

// checking the expiration date of the user's subscription

if(isExpiredSubscription()){
    header('Location: ./error.php');
    exit();
}

//cancelUserSubscription($settings, $userDetails['user_id']);
header('Location: ./home.php');

}else{
    
    header('Location: ./login.php');
}

?>