<?php

$exclusiveCoupons = getExclusiveCoupons($connect, $site_config['exclusive_items']);

$hasFeedback = [];
if (isLogged()) {
    $hasFeedback = getFeebackCoupons($connect, $userInfo['user_id']);
}

require './sections/views/exclusive-coupons.view.php';

?>