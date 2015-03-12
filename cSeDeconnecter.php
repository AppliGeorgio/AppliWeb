<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se déconnecter"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_coDb.inc.php");

  // Suppression des variables de session et de la session
  $_SESSION = array();
  session_destroy();
  header("Location:index.php");
?>
