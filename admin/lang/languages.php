<?php

    if(empty($_GET['adminlang']) || !isset($_GET['adminlang'])){

        if(!isset($_COOKIE['adminLang']) || empty($_COOKIE['adminLang'])){

            setcookie("adminLang", "en", time() + (60 * 60 * 24 * 60), '/');
   			    require_once 'lang_en.php';

        }else{

        	$file = __DIR__ . '/lang_'.$_COOKIE['adminLang'].'.php';

			if (file_exists($file)) {   
   				
   				require_once 'lang_'.$_COOKIE['adminLang'].'.php';

			}else{

   				require_once 'lang_en.php';
			}

        }

    }else{

        if (empty($_COOKIE['adminLang']) || !isset($_COOKIE['adminLang']) || $_GET['adminlang'] !== $_COOKIE['adminLang']) {
            setcookie("adminLang", $_GET['adminlang'], time() + (60 * 60 * 24 * 60), '/');
        }

        	$file = __DIR__ . '/lang_'.$_GET['adminlang'].'.php';

			if (file_exists($file)) {   
   				
   				require_once 'lang_'.$_GET['adminlang'].'.php';

			}else{

   				require_once 'lang_en.php';
			}


    }

?>