<?php

$featuredCoupons = getFeaturedCoupons($connect, $site_config['featured_items']);

$hasFeedbackFeatured = [];
if (isLogged()) {
    $hasFeedbackFeatured = getFeebackCoupons($connect, $userInfo['user_id']);
}

require './sections/views/featured-coupons.view.php';

?>