<?php
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Saisir fiche de frais"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_coDb.inc.php");

  
  require($repInclude . "_entete.inc.html");
  require($repInclude . "_menu.inc.php");
  
  // acquisition des données entrées
  // acquisition de l'étape du traitement 
  
  // acquisition des quantités des éléments forfaitisés 
  // acquisition des données d'une nouvelle ligne hors forfait
 
  // structure de décision sur les différentes étapes du cas d'utilisation
      // l'utilisateur valide les éléments forfaitisés         
      // vérification des quantités des éléments forfaitisés 
      // mise à jour des quantités des éléments forfaitisés
                          
          // la nouvelle ligne ligne doit être ajoutée dans la base de données
          // on ne fait rien, étape non prévue 
  
                             
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Renseigner ma fiche de frais du mois de </h2>
<?php
  
?>
      <p class="info">Les modifications de la fiche de frais ont bien été enregistrées</p>        
<?php
      
      ?>            
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerSaisie" />
          <fieldset>
            <legend>Eléments forfaitisés
            </legend>
      <?php          
            // demande de la requête pour obtenir la liste des éléments 
            // forfaitisés du visiteur connecté pour le mois demandé
            

            ?>
            <p>
              <label for="">* libelle : </label>
              <input type="text" id="" 
                    name="" 
                    size="10" maxlength="5"
                    title="Entrez la quantité de l'élément forfaitisé" 
                    value="quantité" />
            </p>
            <?php        
                
            ?>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" 
               title="Enregistrer les nouvelles valeurs des éléments forfaitisés" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class="montant">Montant</th>  
                <th class="action">&nbsp;</th>              
             </tr>
<?php          
          // demande de la requête pour obtenir la liste des éléments hors
          // forfait du visiteur connecté pour le mois demandé
          
          // parcours des frais hors forfait du visiteur connecté
          ?>
              <tr>
                <td>Date</td>
                <td>Libelle</td>
                <td>Montant</td>
                <td><a href="#"
                       onclick="return confirm('Voulez-vous vraiment supprimer cette ligne de frais hors forfait ?');"
                       title="Supprimer la ligne de frais hors forfait">Supprimer</a></td>
              </tr>
          <?php
?>
    </table>
      <form action="" method="post">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerAjoutLigneHF" />
          <fieldset>
            <legend>Nouvel élément hors forfait
            </legend>
            <p>
              <label for="txtDateHF">* Date : </label>
              <input type="text" id="txtDateHF" name="txtDateHF" size="12" maxlength="10" 
                     title="Entrez la date d'engagement des frais au format JJ/MM/AAAA" 
                     value="date" />
            </p>
            <p>
              <label for="txtLibelleHF">* Libellé : </label>
              <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="70" maxlength="100" 
                    title="Entrez un bref descriptif des frais" 
                    value="libelle" />
            </p>
            <p>
              <label for="txtMontantHF">* Montant : </label>
              <input type="text" id="txtMontantHF" name="txtMontantHF" size="12" maxlength="10" 
                     title="Entrez le montant des frais (le point est le séparateur décimal)" value="montant" />
            </p>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ajouter" type="submit" value="Ajouter" size="20" 
               title="Ajouter la nouvelle ligne hors forfait" />
        <input id="effacer" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
  </div>
<?php        
  require($repInclude . "_pied.inc.html");
?> 