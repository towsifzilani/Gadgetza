<?php

$getLocations = getLocations($connect, 10);
$getCategories = getCategories($connect);
$getStores = getStores($connect, 20);

$getResults = getSearch($connect, $site_config['page_limit']);

$items = $getResults['items'] ?? [];
$total = $getResults['total'] ?? 0;

$numPages = numTotalPages($total, $site_config['page_limit']);

$hasFeedbackCoupon = [];
if (isLogged()) {
    $hasFeedbackCoupon = getFeebackCoupons($connect, $userInfo['user_id']);
}

if(getFilterParam()== "exclusive-coupon" || getFilterParam() == "featured-coupon" || getFilterParam() == "all-coupons") {
    require './pages/views/search-coupons.view.php';
} else {
    require './pages/views/search.view.php';
}

?>