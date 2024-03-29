<?php

require "core.php";

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $translation['tr_profilepage']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

if (!isLogged()){

	header('Location: '. $urlPath->signin());

}else{
	
	$userProfile = getUserInfo();
	$userDetails = getUserInfoById($userProfile['user_id']);
}

require './header.php';
require './views/profile.view.php';
require './footer.php';

?>