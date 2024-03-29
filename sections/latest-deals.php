<?php

$latestDeals = getLatestDeals($connect, $site_config['latest_items']);

require './sections/views/latest-deals.view.php';

?>