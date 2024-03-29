<?php

require "core.php";

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1'], $translation['tr_eptitle']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

// Page Title
$pageTitle = $translation['tr_1'];

include './header.php';
require './views/error.view.php';
include './footer.php';

?>