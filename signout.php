<?php

require './core.php';

if (isLogged()){

  if(!isset($_SESSION)) { 
    session_start(); 
  }
  
  session_destroy();
  $_SESSION = array ();

  header('Location: '. $urlPath->home());

}else{

  header('Location: '. $urlPath->home());

}

?>