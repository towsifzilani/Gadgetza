<?php

$getReviews = getReviewsByDealAjax($connect, $itemId, $site_config['reviews_page']);

$resultsReviews = $getReviews['results'];
$totalReviews = $getReviews['total'];

require './sections/views/reviews-modal.view.php';

?>