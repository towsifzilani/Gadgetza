<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require_once '../../config.php';
require_once '../functions.php';

if(check_session() == true){

require '../views/footer.view.php';

}else{
	
	header('Location:'.SITE_URL);

}

?>