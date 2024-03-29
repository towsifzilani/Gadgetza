<?php

$featuredCategories = getFeaturedCategories($connect);

require './sections/views/featured-categories.view.php';

?>