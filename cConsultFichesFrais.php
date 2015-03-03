<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Consulter une fiche de frais"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_coDb.inc.php");

  // page inaccessible si visiteur non connecté

  require($repInclude . "_entete.inc.html");
  require($repInclude . "_menu.inc.php");
  
  // acquisition des données entrées, ici le numéro de mois et l'étape du traitement
  

      // si autre valeur, on considère que c'est le début du traitement
           
  
   // l'utilisateur valide ses nouvelles données
                
      // vérification de l'existence de la fiche de frais pour le mois demandé
      
      // si elle n'existe pas, on la crée avec les élets frais forfaitisés à 0
      
          // récupération des données sur la fiche de frais demandée
         
                                  
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
                
            ?>    
            <option value="<?php echo $mois; ?>" selected="selected"></option>
            <?php
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
    <h3>Fiche de frais du mois de  : 
    <em> </em>
    depuis le <em></em></h3>
    <div class="encadre">
    <p>Montant validé : 
    </p>
<?php          
            // demande de la requête pour obtenir la liste des éléments 
            // forfaitisés du visiteur connecté pour le mois demandé
            
            // parcours des frais forfaitisés du visiteur connecté
            // le stockage intermédiaire dans un tableau est nécessaire
            // car chacune des lignes du jeu d'enregistrements doit être doit être
            // affichée au sein d'une colonne du tableau HTML
            
            ?>
  	<table class="listeLegere">
  	   <caption>Quantités des éléments forfaitisés</caption>
        <tr>
            <?php
            // premier parcours du tableau des frais forfaitisés du visiteur connecté
            // pour afficher la ligne des libellés des frais forfaitisés
            
            ?>
                <th>Un Libelle</th>
            <?php
            
            ?>
        </tr>
        <tr>
            <?php
            // second parcours du tableau des frais forfaitisés du visiteur connecté
            // pour afficher la ligne des quantités des frais forfaitisés
            
            ?>
                <td class="qteForfait">Une quantité</td>
            <?php
            
            ?>
        </tr>
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait -  justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class="montant">Montant</th>                
             </tr>
<?php          
            // demande de la requête pour obtenir la liste des éléments hors
            // forfait du visiteur connecté pour le mois demandé
            
            
            // parcours des éléments hors forfait 
            
            ?>
                <tr>
                   <td>date</td>
                   <td>libelle</td>
                   <td>montant</td>
                </tr>
            <?php
  ?>
    </table>
  </div>
<?php
       
?>    
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
?> 