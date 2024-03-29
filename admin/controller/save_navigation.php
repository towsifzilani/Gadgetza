<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

if(check_session() == true){
    
$id_menu = cleardata($_GET['menu']);

if(!$id_menu){
	exit();
}

if(check_permission('edit_menus')){

if (isset($_POST)) {
    
    $mysqli = new mysqli($database['host'], $database['user'], $database['pass'], $database['db']);

    if ($mysqli -> connect_errno) {
        exit();
    }

    $arrayItems = cleardata($_POST['item']);
    $order = 0;

    foreach ($arrayItems as $item) {
        $sql = "UPDATE navigations SET navigation_order = '$order' WHERE navigation_id =' $item'";
        mysqli_query($mysqli, $sql);
        $order++;
    }

    echo _CHANGESSAVED;
    mysqli_close($mysqli);
}

}else{
    
	exit();		
}

}else{

	exit();		
}

?>

