<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../core.php';

$connect = connect($database);

if (isLogged($connect)){

if(!isSeller()){
    header('Location: ./denied.php');
}

$userProfile = getUserInfo();
$userDetails = getUserInfoById($userProfile['user_id']);

$totalClickToday = getTotalClicks($userDetails['user_id'], 'today');
$totalClicksLast30 = getTotalClicks($userDetails['user_id'], 'last30days');
$totalClicks = getTotalClicks($userDetails['user_id']);
$totalUniqueClicks = getTotalClicks($userDetails['user_id'], null, 1);
$topCountries = getTopCountries($userDetails['user_id'], 'last30days');

require './views/header.view.php';
require './views/home.view.php';
require './views/footer.view.php';

}else{
    
    header('Location: ./login.php');
}

?>