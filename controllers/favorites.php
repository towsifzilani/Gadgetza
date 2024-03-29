<?php

include_once "../core.php";

if (!isLogged()){

	$data = array();

	$results = array(
	    "sEcho" => 1,
	    "iTotalRecords" => count($data),
	    "iTotalDisplayRecords" => count($data),
	    "aaData"=>$data);
	echo json_encode($results);
 
}else{
	
	$userInfo = getUserInfo();

	$data = getUserFavorites($connect, $userInfo['user_id']);

	$results = array(
	    "sEcho" => 1,
	    "iTotalRecords" => count($data),
	    "iTotalDisplayRecords" => count($data),
	    "aaData"=> $data);
	echo json_encode($results);

}


?>
