<?php

// Get Menu Header

$sidebarMenu = getSidebarMenu($connect);

$navigationSidebar = getNavigation($connect, $sidebarMenu['menu_id']);

require './sections/views/sidemenu.view.php';

?>