<?php

$getFeaturedCategories = getFeaturedCategories($connect);
$getCategories = getCategories($connect);

require './pages/views/categories.view.php';

?>