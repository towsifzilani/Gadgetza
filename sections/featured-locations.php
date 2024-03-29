<?php

$counter = 0;

$featuredLocations = getFeaturedLocations($connect, $site_config['featured_locations']);

require './sections/views/featured-locations.view.php';

?>