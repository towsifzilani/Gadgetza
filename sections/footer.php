<?php

// Get Menu Footer

$footermenu = getFooterMenu($connect);

$navigationFooter = getNavigation($connect, $footermenu['menu_id']);

require './sections/views/footer.view.php';

?>