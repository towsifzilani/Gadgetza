<?php

require "core.php";

$slugItem = clearGetData(getSlugItem());

if(empty($slugItem) && !isset($slugItem)){

	header('Location: '. $urlPath->home());
}

// Get ID By Slug
$itemDetails = getLocationBySlug($connect, $slugItem);

if(empty($itemDetails)){

	header('Location: '. $urlPath->error());
	
}

$getResults = getDealsByLocation($connect, $site_config['page_limit'], $itemDetails['location_id']);

$items = $getResults['items'];
$total = $getResults['total'];

$numPages = numTotalPages($total, $site_config['page_limit']);

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], empty($itemDetails['location_seotitle']) || $itemDetails['location_seotitle'] == " " ? $itemDetails['location_title'] : $itemDetails['location_seotitle']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['location_description'], $itemDetails['location_seodescription']);

// Page Title
$pageTitle = $itemDetails['location_title'];

include './header.php';
require './views/single-location.view.php';
include './footer.php';

?>