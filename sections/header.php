<?php

// Get Menu Header

$headerMenu = getHeaderMenu($connect);

$navigationHeader = getNavigation($connect, $headerMenu['menu_id']);

$index_url = basename($_SERVER['PHP_SELF']);
$current_url = getCurrentPageSlug();
$currentURL = getCurrentUrl();
// echo $currentURL;exit;
// Get Header Style

if ($theme['th_headerstyle'] == 'header1') {

	require './sections/views/header-1.view.php';

}elseif ($theme['th_headerstyle'] == 'header2') {
	
	require './sections/views/header-2.view.php';

}elseif ($theme['th_headerstyle'] == 'header3') {
	
	require './sections/views/header-3.view.php';
	
}else{

	require './sections/views/header-1.view.php';

}

?>