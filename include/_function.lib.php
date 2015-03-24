<?php 
function select() {

	echo '
	<h2 style="margin-bottom:50px;">Sasie Fiche Frais</h2>
		<form action="" method="post" name="frm">
	      		Quel type de saisie voulez-vous faire : 
	      		<select name="liste">
				   <option value="forf">Eléments forfaitisés</option>
				   <option value="hforf">éléments hors forfait</option>
				</select> 
			<input id="ajouter" type="submit" value="Choix" size="20" name="choix" />
		</form>';

}

function forfaitises($bdd){
  $mois = date("Ym"); 
  $id = $_SESSION['id'];
	$Mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	$Mois = $Mois[date("n")];
	echo '
<h2 style="margin-bottom:50px;">Sasie Fiche Frais pour le mois de '.$Mois.'</h2>
	<a href="cSaisieFicheFrais.php">Retour</a><br>
	<form action="" method="post">
      	<div class="corpsForm">
           <input type="hidden" name="hd" value="validerSaisie" />
          		<fieldset>
            		<legend>Eléments forfaitisés</legend>';
     			
             					$req = $bdd->query("SELECT * FROM lignefraisforfait WHERE `idVisiteur` = '$id' AND mois = '$mois'");
             					$res = $req->fetchAll();
                            if(isset($res[0])){
                			foreach ($res as $key) {
                            $idFraisForfait = $key["idFraisForfait"];
                            $quantite = $key["quantite"];
                            if($idFraisForfait == 'ETP') {$libelle = 'Forfait Etape';}
                            else if($idFraisForfait == 'KM') {$libelle = 'Frais Kilométrique';}
                            else if($idFraisForfait == 'NUI') {$libelle = 'Nuitée Hôtel';}
                            else if($idFraisForfait == 'REP') {$libelle = 'Repas Restaurant';}
            echo '
            <p>
              <label for="'.$idFraisForfait.'">*'.$libelle.' : </label>
              <input type="text" id="'.$idFraisForfait.'" 
                    name="'.$idFraisForfait.'" 
                    size="10" maxlength="5"
                    title="Entrez la quantité de l\'élément forfaitisé" 
                    value="'.$quantite.'" />
            </p>';
              }
            }
                          else {
                            echo '<form action="" method="post"><input type="submit" value="Ajouter les nouveau champs de frais forfaitisés du mois de '.$Mois.'" size="20" name="champ" /></form>';
                          }
            if(isset($_POST['champ'])){
                    $bdd->exec("INSERT INTO `lignefraisforfait`(`idVisiteur`, `mois`, `idFraisForfait`) VALUES  ('".$_SESSION['id']."', '".$mois."', 'ETP')");
                    $bdd->exec("INSERT INTO `lignefraisforfait`(`idVisiteur`, `mois`, `idFraisForfait`) VALUES  ('".$_SESSION['id']."', '".$mois."', 'KM')");
                    $bdd->exec("INSERT INTO `lignefraisforfait`(`idVisiteur`, `mois`, `idFraisForfait`) VALUES  ('".$_SESSION['id']."', '".$mois."', 'NUI')");
                    $bdd->exec("INSERT INTO `lignefraisforfait`(`idVisiteur`, `mois`, `idFraisForfait`) VALUES  ('".$_SESSION['id']."', '".$mois."', 'REP')");
            }

          		echo '</fieldset>
      	</div>
     	<div class="piedForm">
     		<p>
        	   <input name ="valide" id="ok" type="submit" value="Valider" size="20" 
               title="Enregistrer les nouvelles valeurs des éléments forfaitisés" />
        	   <input id="annuler" type="reset" value="Effacer" size="20" name="br" />
     		</p> 
     	</div>
        
    </form>';
}

function non_forfaitises($bdd){
	echo '
<h2 style="margin-bottom:50px;">Sasie Fiche Frais</h2>
	<a href="cSaisieFicheFrais.php">Retour</a> // <a href="cSaisieFicheFrais.php?type=hforf">Actualisé</a><br>
	<form action="" method="post" name="frm">
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerAjoutLigneHF" />
          <fieldset>
            <legend>Nouvel élément hors forfait
            </legend>
            <p>
              <label for="txtDateHF">* Date : </label>
              <input type="text" id="txtDateHF" name="txtDateHF" size="12" maxlength="10" 
                     title="Entrez la date d\'engagement des frais au format JJ/MM/AAAA" 
                     value="" />
            </p>
            <p>
              <label for="txtLibelleHF">* Libellé : </label>
              <input type="text" id="txtLibelleHF" name="txtLibelleHF" size="70" maxlength="100" 
                    title="Entrez un bref descriptif des frais" 
                    value="" />
            </p>
            <p>
              <label for="txtMontantHF">* Montant : </label>
              <input type="text" id="txtMontantHF" name="txtMontantHF" size="12" maxlength="10" 
                     title="Entrez le montant des frais (le point est le séparateur décimal)" value="" />
            </p>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ajouter" type="submit" value="Ajouter" size="20" name="cmd"
               title="Ajouter la nouvelle ligne hors forfait" />
        <input id="effacer" type="reset" value="Effacer" size="20" />
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
             </tr>';

     	$req = $bdd->query("SELECT * FROM lignefraishorsforfait ");
    	$res = $req->fetchAll();
     	foreach ($res as $fin ) {
          $date1 = $fin["date"];
          $date = date("d/m/Y", strtotime($date1));
     			echo '<tr>
     			      <td>'.$date.'</td>
                <td>'.$fin["libelle"].'</td>
                <td>'.$fin["montant"].'</td>
                <td><a href="?etape=validerSuppressionLigneHF&amp;idLigneHF='.$fin["id"].'"
                       onclick="return confirm(\'Voulez-vous vraiment supprimer cette ligne de frais hors forfait ?\');"
                       title="Supprimer la ligne de frais hors forfait">Supprimer</a></td>
              </tr>';
     	}
      echo '</table>';
      
}

function supprimerligne($bdd,$num) {

      $bdd->exec("delete from LigneFraisHorsForfait where id = ".$num);

}

function ajouterhorsforfait($bdd,$id,$mois,$date,$libelle,$montant){
      $bdd->exec("INSERT INTO LigneFraisHorsForfait(idVisiteur, mois, date, libelle, montant) 
                  VALUES ('" . $id . "','" . $mois . "','" . $date . "','" . $libelle . "'," . $montant .")");

}

function ajouterforfait($bdd){
      $id = $_SESSION['id'];
      $etpv = $_POST['ETP'];     
      $kmv = $_POST['KM'];
      $nuiv = $_POST['NUI'];
      $repv = $_POST['REP'];
      $mois = date("Ym"); 
      $etp = 'ETP';
      $km = 'KM';
      $nui = 'NUI';
      $rep = 'REP';

     $bdd->exec("UPDATE `lignefraisforfait` SET `quantite`= '$etpv' WHERE idVisiteur = '$id' AND mois = '$mois' AND idFraisForfait = 'ETP'");
     $bdd->exec("UPDATE `lignefraisforfait` SET `quantite`= '$kmv' WHERE idVisiteur = '$id' AND mois = '$mois' AND idFraisForfait = 'KM'");
     $bdd->exec("UPDATE `lignefraisforfait` SET `quantite`= '$nuiv' WHERE idVisiteur = '$id' AND mois = '$mois' AND idFraisForfait = 'NUI'");
     $bdd->exec("UPDATE `lignefraisforfait` SET `quantite`= '$repv' WHERE idVisiteur = '$id' AND mois = '$mois' AND idFraisForfait = 'REP'");      
}

function obtenirLibelleMois($unNoMois) { $tabLibelles = array(1=>"Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"); $libelle=""; if ( $unNoMois >=1 && $unNoMois <= 12 ) { $libelle = $tabLibelles[$unNoMois]; } return $libelle; } ?>

