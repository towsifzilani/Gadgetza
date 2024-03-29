<?php

require "core.php";

$slugItem = clearGetData(getSlugItem());

if(empty($slugItem) && !isset($slugItem)){

	header('Location: '. $urlPath->home());
}

// Get ID By Slug
$itemDetails = getSellerBySlug($connect, $slugItem);

if(empty($itemDetails)){

	header('Location: '. $urlPath->error());
	
}

$getResults = getDealsByUser($connect, $site_config['page_limit'], $itemDetails['seller_user']);

$items = $getResults['items'];
$total = $getResults['total'];

$numPages = numTotalPages($total, $site_config['page_limit']);

// Seo Title
$titleSeoHeader = getSeoTitle($itemDetails['seller_title']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['seller_description']);

// Page Title
$pageTitle = $itemDetails['seller_title'];

include './header.php';
require './views/single-user.view.php';
include './footer.php';

?>