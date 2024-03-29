<?php

$getReviews = getReviewsByDeal($connect, $itemId);

$resultsReviews = $getReviews['results'];
$totalReviews = $getReviews['total'];

require './sections/views/reviews.view.php';

?>