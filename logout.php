<?php
session_start(); 
  
  if ($_GET['salir'] == 'yes'){
    session_destroy();
    header("location: index.php");
  }
?>