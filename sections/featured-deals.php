<?php

$featuredDeals = getFeaturedDeals($connect, $site_config['featured_items']);

require './sections/views/featured-deals.view.php';

?>