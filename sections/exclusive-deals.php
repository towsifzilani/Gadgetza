<?php

$exclusiveDeals = getExclusiveDeals($connect, $site_config['exclusive_items']);

require './sections/views/exclusive-deals.view.php';

?>