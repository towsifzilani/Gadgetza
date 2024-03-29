<?php

require "core.php";

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

include './header.php';
include './views/index.view.php';
include './footer.php';

?>