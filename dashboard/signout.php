<?php

require '../core.php';

if (isLogged()){
  
  session_start();

  session_destroy();
  $_SESSION = array ();

  header('Location: ./home.php');

}else{

  header('Location: ./home.php');

}

?>