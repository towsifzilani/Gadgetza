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

$itemDetails = getItemById($userDetails['user_id'], $itemId);
$deviceTypes = getDeviceTypeClicks($userDetails['user_id'], $itemId, 'last30days');
$topCountries = getTopCountriesByItem($userDetails['user_id'], $itemId, 'last30days');

$totalClickToday = getTotalClicks($userDetails['user_id'], 'today', null, $itemId);
$totalClicksLast30 = getTotalClicks($userDetails['user_id'], 'last30days', null, $itemId);
$totalClicks = getTotalClicks($userDetails['user_id'], null, null, $itemId);
$totalUniqueClicks = getTotalClicks($userDetails['user_id'], null, 1, $itemId);

if (!$itemDetails){
    header('Location: ./home.php');
    exit();
}

require './views/header.view.php';
require './views/item.view.php';
require './views/footer.view.php';

}else{
    
    header('Location: ./login.php');
}

?>