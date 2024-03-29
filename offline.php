<?php

include_once "core.php";

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $translation['tr_maintenancepage']);

if ($maintenanceMode == 0) {

	header('Location: '. $urlPath->home());
}

$fullHeight = true;

require './header.php';
require './views/offline.view.php';
require './footer.php';

?>