<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

include_once '../menu.php';

if(check_session() == true){
 
$settings = get_settings();

$userInfo = get_user_information();

require '../views/sidebar.view.php';

}else{

    header('Location:'.SITE_URL);
}

?>