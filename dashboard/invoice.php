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

$itemId = clearGetData(getItemId());

$itemDetails = gePaymentById($itemId);

if (!$itemDetails){
    header('Location: ./home.php');
    exit();
}

$userBilling = json_decode($userDetails['user_billing']);
$taxes = getTaxesById($itemDetails['payment_taxes']);

require './views/header.view.php';
require './views/invoice.view.php';
require './views/footer.view.php';

}else{
    
    header('Location: ./login.php');
}

?>