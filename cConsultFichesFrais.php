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
  
  // acquisition des données entrées, ici le numéro de mois et l'étape du traitement
  if (isset($_POST['lstMois']) && isset($_POST['etape']))
  {
    $moisSaisi = $_POST['lstMois'];
    $etape = $_POST['etape'];
  }
    if ($etape != "demanderConsult" && $etape != "validerConsult") {
      // si autre valeur, on considère que c'est le début du traitement
           $etape = "demanderConsult"; 
    } 
   if ($etape == "validerConsult") {// l'utilisateur valide ses nouvelles données

      // vérification de l'existence de la fiche de frais pour le mois demandé
      $existeFicheFrais = $bdd->prepare("SELECT idVisiteur 
                            FROM fichefrais 
                            WHERE idVisiteur = :unIdVisiteur 
                            AND mois = :moisSaisi");
      $existeFicheFrais->bindValue(":unIdVisiteur", $unIdVisiteur, PDO::PARAM_STR);
      $existeFicheFrais->bindValue(":moisSaisi", $moisSaisi, PDO::PARAM_STR);
      $existeFicheFrais->execute();         
      // si elle n'existe pas, on la crée avec les élets frais forfaitisés à 0
      if ( !$existeFicheFrais ) {
         ajouterErreur($tabErreurs, "Le mois demandé est invalide");
      }   
      else {
          // récupération des données sur la fiche de frais demandée
         $tabFicheFrais = $bdd->prepare("SELECT IFNULL(nbJustificatifs,0) as nbJustificatifs, Etat.id as idEtat, libelle as libelleEtat, dateModif, montantValide
                            FROM fichefrais 
                            WHERE fichefrais.id = Etat.id
                            AND idVisiteur = :unIdVisiteur 
                            AND mois = :moisSaisi");
         $tabFicheFrais->bindValue(":unIdVisiteur", $unIdVisiteur, PDO::PARAM_STR);
         $tabFicheFrais->bindValue(":moisSaisi", $moisSaisi, PDO::PARAM_STR);
         $tabFicheFrais->execute(); 
     }                             
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Mes fiches de frais</h2>
      <h3>Mois à sélectionner : </h3>
      <form action="" method="post">
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
                }
            ?>     
            <option value="<?php echo $mois; ?>" <?php if ($moisSaisi == $mois) { ?> selected="selected" <?php } ?>><?php echo obtenirLibelleMois($noMois) . " " . $annee; ?></option>
            <?php
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
<?php      

// demande et affichage des différents éléments (forfaitisés et non forfaitisés)
// de la fiche de frais demandée, uniquement si pas d'erreur détecté au contrôle
    
?>
    <h3>Fiche de frais du mois de <?php echo obtenirLibelleMois(intval(substr($moisSaisi,4,2))) . " " . substr($moisSaisi,0,4); ?> : 
    <em> <?php echo $tabFicheFrais["libelleEtat"]; ?> </em>
    depuis le <em>?php echo $tabFicheFrais["dateModif"]; ?></em></h3>
    <div class="encadre">
    <p>Montant validé :  <?php echo $tabFicheFrais["montantValide"] ;
        ?>
    </p>
            <?php          
            // demande de la requête pour obtenir la liste des éléments 
            // forfaitisés du visiteur connecté pour le mois demandé
              $req = $bdd->prepare("SELECT idFraisForfait, libelle, quantite
                                  FROM LigneFraisForfait
                                  WHERE FraisForfait.id = LigneFraisForfait.idFraisForfait 
                                  AND idVisiteur = :unIdVisiteur
                                  AND mois = :moisSaisi");
              $req->bindValue(":unIdVisiteur", $unIdVisiteur, PDO::PARAM_STR);
              $req->bindValue(":moisSaisi", $moisSaisi, PDO::PARAM_STR);
              $req->execute();
              $resultat = $req->fetchAll();
            // parcours des frais forfaitisés du visiteur connecté
            // le stockage intermédiaire dans un tableau est nécessaire
            // car chacune des lignes du jeu d'enregistrements doit être doit être
            // affichée au sein d'une colonne du tableau HTML                
              $tabEltsFraisForfait = array();
              foreach ($resultat as $ligne) 
                {
                  $tabEltsFraisForfait[$ligne["libelle"]] = $ligne["quantite"];
                }      
              $req->closeCursor();      
            ?>
  	<table class="listeLegere">
  	   <caption>Quantités des éléments forfaitisés</caption>
        <tr>
            <?php
            // premier parcours du tableau des frais forfaitisés du visiteur connecté
            // pour afficher la ligne des libellés des frais forfaitisés
            foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
            ?>
                <th><?php echo $unLibelle ; ?>}</th>
            <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            // second parcours du tableau des frais forfaitisés du visiteur connecté
            // pour afficher la ligne des quantités des frais forfaitisés
            foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
            ?>
                <td class="qteForfait"><?php echo $uneQuantite ; ?></td>
            <?php
            }
            ?>
        </tr>
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait - <?php echo $tabFicheFrais["nbJustificatifs"]; ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class="montant">Montant</th>                
             </tr>
<?php          
            // demande de la requête pour obtenir la liste des éléments hors
            // forfait du visiteur connecté pour le mois demandé
            $req = $bdd->prepare("SELECT id, date, libelle, montant
                                  FROM LigneFraisHorsForfait
                                  WHERE FraisForfait.id = LigneFraisForfait.idFraisForfait 
                                  AND idVisiteur = :unIdVisiteur
                                  AND mois = :moisSaisi");
              $req->bindValue(":unIdVisiteur", $unIdVisiteur, PDO::PARAM_STR);
              $req->bindValue(":moisSaisi", $moisSaisi, PDO::PARAM_STR);
              $req->execute();
              $resultat = $req->fetchAll();
            
            // parcours des éléments hors forfait 
            foreach ($resultat as $ligne) 
                {            
            ?>
                <tr>
                   <td><?php echo $ligne["date"]; ?></td>
                   <td><?php echo $ligne["libelle"]; ?></td>
                   <td><?php echo $ligne["montant"]; ?></td>
                </tr>
    <?php
      $req->closeCursor(); 
    ?>
    </table>
  </div>
<?php
     }
  }  
?>    
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
  }
?> 
