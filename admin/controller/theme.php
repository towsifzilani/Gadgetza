<?php

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

require '../../config.php';
require '../functions.php';

$errors = array();

if(check_session() == true){

if(check_permission('view_theme') || check_permission('edit_theme')){

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	
	
	if(check_permission('edit_theme')){

		$th_mobilestyle = $_POST['th_mobilestyle'];
		$th_headerstyle = $_POST['th_headerstyle'];
		$th_homestyle = $_POST['th_homestyle'];
		$th_primarycolor = $_POST['th_primarycolor'];
		$th_secondarycolor = $_POST['th_secondarycolor'];
	
		$required_fields = ['th_mobilestyle', 'th_headerstyle', 'th_homestyle', 'th_primarycolor', 'th_secondarycolor'];
		foreach($required_fields as $field) {
			if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]))) {
					$errors[] = "<b>".$field."</b> " . _ERRORREQUIREDFIELD;  
			}
		}
		
		$image = [
			'th_logo' => isset($_FILES['th_logo']['name']) && !empty($_FILES['th_logo']['name']),
			'th_whitelogo' => isset($_FILES['th_whitelogo']['name']) && !empty($_FILES['th_whitelogo']['name']),
			'th_favicon' => isset($_FILES['th_favicon']['name']) && !empty($_FILES['th_favicon']['name']),
			'th_homebg' => isset($_FILES['th_homebg']['name']) && !empty($_FILES['th_homebg']['name'])
		];

		$uploadedImages = [];

		foreach(['th_logo', 'th_whitelogo', 'th_favicon', 'th_homebg'] as $image_key) {

			if($image[$image_key]) {

				$file_name = $_FILES[$image_key]['name'];
				$file_size = $_FILES[$image_key]['size'];
				$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
				$file_temp = $_FILES[$image_key]['tmp_name'];
	
				if (!in_array($file_extension, allowedFileExt())) {

					$errors[] = "<b>".$image_key."</b> " . _ERRORALLOWEDFILEFORMATS;  
		
				} else if ($file_size > allowedFileSize()) {
		
					$errors[] = "<b>".$image_key."</b> " . _ERRORFILETOOLARGE;  
		
				}

				if(empty($errors)){

					$image_new_name = md5(time() . rand()) . '.' . $file_extension;
					move_uploaded_file($file_temp, $target_dir . $image_new_name);

					$uploadedImages += [$image_key => $image_new_name];

				}
	
			}

		}

		if(empty($errors)){

			$cssFile = file_get_contents('./colors.txt');
			$cssFile = str_replace('{primary_color}', $th_primarycolor, $cssFile);
			$cssFile = str_replace('{secondary_color}', $th_secondarycolor, $cssFile);
			$cssFile = str_replace('{secondary_color_50}', hexToRgb($th_secondarycolor, .50), $cssFile);
			$cssFile = str_replace('{secondary_color_85}', hexToRgb($th_secondarycolor, .85), $cssFile);
			$handler = fopen("../../assets/css/colors.css", "w");
			fwrite($handler, $cssFile);
			fclose($handler);
			
			$statment = connect()->prepare(
				"UPDATE theme SET
				th_primarycolor = :th_primarycolor,
				th_secondarycolor = :th_secondarycolor,
				th_mobilestyle = :th_mobilestyle,
				th_headerstyle = :th_headerstyle,
				th_homestyle = :th_homestyle,
				th_logo = :th_logo,
				th_whitelogo = :th_whitelogo,
				th_favicon = :th_favicon,
				th_homebg = :th_homebg
				");
			
			$statment->execute(array(
				':th_primarycolor' => $th_primarycolor,
				':th_secondarycolor' => $th_secondarycolor,
				':th_mobilestyle' => $th_mobilestyle,
				':th_headerstyle' => $th_headerstyle,
				':th_homestyle' => $th_homestyle,
				':th_logo' => (isset($uploadedImages['th_logo']) ? $uploadedImages['th_logo'] : $_POST['th_logo_save']),
				':th_whitelogo' => (isset($uploadedImages['th_whitelogo']) ? $uploadedImages['th_whitelogo'] : $_POST['th_whitelogo_save']),
				':th_favicon' => (isset($uploadedImages['th_favicon']) ? $uploadedImages['th_favicon'] : $_POST['th_favicon_save']),
				':th_homebg' => (isset($uploadedImages['th_homebg']) ? $uploadedImages['th_homebg'] : $_POST['th_homebg_save'])
			));

			header('Location: ' . $_SERVER['HTTP_REFERER']);

		}
				
}else{

	header('Location: ./denied.php');		

}

}

$theme = get_theme();
require '../views/theme.view.php';

}else{

header('Location: ./denied.php');		

}

}else{

header('Location:'.SITE_URL);

}

?>