<?php

$featuredStores = getFeaturedStores($connect, $site_config['featured_stores']);

require './sections/views/featured-stores.view.php';

?>