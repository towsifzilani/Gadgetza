<?php

if(isLogged()){

	$userProfile = getUserInfo();
	$userDetails = getUserInfoById($userProfile['user_id']);
	$userPlanSettings = getPlanById($connect, $userDetails['user_plan']);
	$userTotalOUploaded = getTotalItemsByUser($userDetails['user_id']);

}

$menuItems = Array(
    [
        'url' => 'submissions.php',
        'icon' => 'album',
        'title' => $translation['tr_240'],
    ],
    [
        'url' => 'seller.php',
        'icon' => 'cart',
        'title' => $translation['tr_241'],
    ],
	[
        'url' => 'membership.php',
        'icon' => 'bookmark',
        'title' => $translation['tr_242'],
    ],
	[
        'url' => 'profile.php',
        'icon' => 'user',
        'title' => $translation['tr_244'],
    ],
);

require './views/menu.view.php';

?>