<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Consulter une fiche de frais"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_coDb.inc.php");

  // page inaccessible si visiteur non connecté
  if(empty($_SESSION["nom"]) && empty($_SESSION["prenom"]))
  {
    echo "Acces interdit";
  }
  else
  {
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_menu.inc.php");
  
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Mes fiches de frais</h2>
      <h3>Mois à sélectionner : </h3>
      <form action="cAffichageFichesFrais.php" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerConsult" />
      <p>
        <label for="lstMois">Mois : </label>
        <select id="lstMois" name="lstMois" title="Sélectionnez le mois souhaité pour la fiche de frais">
            <?php
                // on propose tous les mois pour lesquels le visiteur a une fiche de frais
                $unIdVisiteur = $_SESSION['id']; // on récupère l'id du visiteur
                $req = $bdd->prepare("SELECT fichefrais.mois as mois 
                                      FROM fichefrais 
                                      WHERE fichefrais.idvisiteur = :unIdVisiteur 
                                      ORDER BY fichefrais.mois DESC");
                $req->bindValue(":unIdVisiteur", $unIdVisiteur, PDO::PARAM_STR);
                $req->execute();
                $resultat = $req->fetchAll();
                foreach ($resultat as $ligne) 
                {
                  $mois = $ligne['mois'];
                  $noMois = intval(substr($mois, 4, 2));
                  $annee = intval(substr($mois, 0, 4));
                
            ?>     
            <option value = "<?php echo $mois; ?>" ><?php echo $noMois," / ", $annee; ?></option>
			
            <?php
				}
              $req->closeCursor();
            ?>
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20"
               title="Demandez à consulter cette fiche de frais" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>

    
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  }
?> 
