<?php

$relatedDeals = getRelatedDeals($connect, $itemId);

require './sections/views/related-deals.view.php';

?>