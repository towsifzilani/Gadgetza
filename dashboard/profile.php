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
    header('Location: ./home.php');
    exit();
}

if(!$userDetails){
    header('Location: ./home.php');
    exit();
}

$userBilling = json_decode($userDetails['user_billing']);

require './views/header.view.php';
require './views/profile.view.php';
require './views/footer.view.php';

}else{
    
    header('Location: ./login.php');
}

?>