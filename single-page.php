<?php

require "core.php";

// Get Item Slug
$slugItem = clearGetData(getSlugItem());

if(empty($slugItem) && !isset($slugItem)){

	header('Location: '. $urlPath->home());
}

// Get ID By Slug
$itemDetails = getPageBySlug($connect, $slugItem);

if(empty($itemDetails)){

	header('Location: '. $urlPath->error());
}

if($itemDetails['page_private'] == 1 && !isLogged()){

	header('Location: '. $urlPath->private());
}

// Seo Title
$titleSeoHeader = getSeoTitle(empty($itemDetails['page_seotitle']) || $itemDetails['page_seotitle'] == " " ? $itemDetails['page_title'] : $itemDetails['page_seotitle']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['page_content'], $itemDetails['page_seodescription']);

// Page Title
$pageTitle = $itemDetails['page_title'];

include './header.php';
include './sections/header.php';

if ($itemDetails['page_template'] == 'blank') {

	require './views/single-page.view.php';

}elseif ($itemDetails['page_template'] == 'search') {
	
	require './pages/search.php';

}elseif ($itemDetails['page_template'] == 'categories') {
	
	require './pages/categories.php';

}elseif ($itemDetails['page_template'] == 'locations') {
	
	require './pages/locations.php';

}elseif ($itemDetails['page_template'] == 'stores') {
	
	require './pages/stores.php';

}elseif ($itemDetails['page_template'] == 'contact') {
	
require './pages/contact.php';

}elseif ($itemDetails['page_template'] == 'pricing') {
	
	require './pages/pricing.php';
	
	}else{

	require './views/single-page.view.php';
}
	
include './sections/views/footer-ad.view.php';

if($itemDetails['page_show_footer'] == 1):
include './sections/footer.php';
endif;

include './footer.php';

?>