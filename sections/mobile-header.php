<?php

// Get Mobile Header Style

if ($theme['th_mobilestyle'] == 'style1') {

	require './sections/views/mobile-header-1.view.php';

}elseif ($theme['th_mobilestyle'] == 'style2') {
	
	require './sections/views/mobile-header-2.view.php';

}else{

	require './sections/views/mobile-header-1.view.php';

}

?>