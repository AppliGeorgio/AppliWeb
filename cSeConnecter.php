<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se connecter"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_coDb.inc.php");

  require($repInclude . "_entete.inc.html");
  require($repInclude . "_menu.inc.php");
  
  //Connexion du Visiteur
  if(isset($_POST["txtLogin"]) && isset($_POST["txtMdp"]))
{
          // on stocke les données du formulaire dans des variables
          $login=$_POST['txtLogin'];
          $mdp=$_POST['txtMdp'];
          $message = '';


    $req = $bdd->prepare("SELECT * FROM Visiteur WHERE mdp = :mdp AND login = :login");
    $req->bindValue(":mdp", $mdp, PDO::PARAM_STR);
    $req->bindValue(":login", $login, PDO::PARAM_STR);
    $req->execute();
    $resultat = $req->fetch();

    // si le login et le mdp se trouve dans la table des Visiteur
    if( ($login == $resultat["login"]) && ($mdp == $resultat["mdp"]))
    {
        // on stocke l'id, le nom et le prénom de l'utilisateur dans la Session
    $_SESSION['id'] = $resultat['id'];
    $_SESSION['nom'] = $resultat['nom'];
    $_SESSION['prenom'] = $resultat['prenom'];
    header('Location:cAccueil.php');
    }
    else
    {
      $message = 'Mauvais identifiant ou mot de passe.';
    }
    $req->closeCursor();
}
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Identification utilisateur</h2>
<?php
        
?>               
      <form id="frmConnexion" action="" method="post">
      <div class="corpsForm">
        <input type="hidden" name="etape" id="etape" value="validerConnexion" />
      <p>
        <label for="txtLogin" accesskey="n">* Login : </label>
        <input type="text" id="txtLogin" name="txtLogin" maxlength="20" size="15" value="" title="Entrez votre login" />
      </p>
      <p>
        <label for="txtMdp" accesskey="m">* Mot de passe : </label>
        <input type="password" id="txtMdp" name="txtMdp" maxlength="8" size="15" value=""  title="Entrez votre mot de passe"/>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input type="submit" id="ok" value="Valider" />
        <input type="reset" id="annuler" value="Effacer" />
      </p> 
      </div>
      </form>
    </div>
<?php
    require($repInclude . "_pied.inc.html");
?>