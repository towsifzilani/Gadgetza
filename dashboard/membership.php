<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../core.php';

$connect = connect($database);

if (isLogged($connect)){

$userProfile = getUserInfo();
$userDetails = getUserInfoById($userProfile['user_id']);
$userPlan = getUserCurrentPlan();

if(!isSeller()){
    header('Location: ./denied.php');
}

require './views/header.view.php';
require './views/membership.view.php';
require './views/footer.view.php';

}else{
    
    header('Location: ./login.php');
}

?>