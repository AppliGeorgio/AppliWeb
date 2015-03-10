<?php
/** 
 * Page d'accueil de l'application web AppliFrais
 * @package default
 * @todo  RAS
 *test test test
 */
  $repInclude = './include/';
  require($repInclude . "_coDb.inc.php");

  
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_menu.inc.php");
  $nom = $_SESSION['nom'];
  $prenom = $_SESSION['prenom'];
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Bienvenue sur l'intranet GSB <?php echo $prenom.' '.$nom.' !' ?></h2>
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
?>
