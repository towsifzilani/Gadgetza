<?php

require "core.php";

// Get Item Slug
$itemId = clearGetData(getItemId());

if(empty($itemId)){

	header('Location: '. $urlPath->home());
	exit();
}

// Page Details
$itemDetails = getDealById($connect, $itemId);

if(empty($itemDetails)){

	header('Location: '. $urlPath->error());
	exit();
}


if($itemDetails['deal_exclusive'] == 1 && $settings['st_access_registered_only_exclusive'] == 1){

if (!isLogged()) {

	header('Location: '. $urlPath->private());
	exit();

}}

if($settings['st_access_registered_only'] == 1){

	if (!isLogged()) {
	
		header('Location: '. $urlPath->private());
		exit();
		
}}

insertTrack($connect, $itemId);

$itemsGallery = getItemsGallery($connect, $itemId);

// Seo Title
$titleSeoHeader = getSeoTitle(empty($itemDetails['deal_seotitle']) || $itemDetails['deal_seotitle'] == " " ? $itemDetails['deal_title'] : $itemDetails['deal_seotitle']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3'], $itemDetails['deal_description'], $itemDetails['deal_seodescription']);

// Page Title
$pageTitle = $itemDetails['deal_title'];

if (isLogged()) {

$isFav = isInFav($connect, $userInfo['user_id'], $itemId);

}

include './header.php';
require './views/single-deal.view.php';
include './footer.php';

?>