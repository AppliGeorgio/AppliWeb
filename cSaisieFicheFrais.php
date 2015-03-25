<?php 

	require('include/_coDb.inc.php');
	require('include/_entete.inc.html');
	require('include/_menu.inc.php');
	require('include/_function.lib.php');
	
	if(isset($_POST['liste'])) {
		header('location: cSaisieFicheFrais.php?type='.$_POST['liste']);
	}
?>
	<div id="contenu" >
      	<?php 
      	if(empty($_GET['type'])) {
      		// On appelle la fonction qui affiche le formulaire
      		select();
      	}
      	
		elseif($_GET['type'] =='forf') {
			// On appelle la fonction qui affiche le formulaire forfaitisé avec en argument la variable de connexion à la BDD
			forfaitises($bdd);
			if(isset($_POST['valide'])){
			ajouterforfait($bdd);
			header( "refresh:0.1;url=cSaisieFicheFrais.php?type=forf" );
			}
		}

		elseif($_GET['type'] == 'hforf') {
			// Sinon on appelle la fonction qui affiche le formulaire non forfaitisé avec en argument la variable de connexion à la BDD
			non_forfaitises($bdd);
		}

		if(isset($_GET['etape'])) {
			supprimerligne($bdd,$_GET['idLigneHF']);
			header('Location:cSaisieFicheFrais.php');
		}

		if(isset($_POST['cmd'])) {
			$id = $_SESSION['id'];
			$date1 = $_POST['txtDateHF'];
			$mois = date("Ym");
			$date1 = $_POST['txtDateHF'];
			$date = date("Y/m/d", strtotime($date1));

			$libelle = $_POST['txtLibelleHF'];
			$montant = $_POST['txtMontantHF'];
			ajouterhorsforfait($bdd,$id,$mois,$date,$libelle,$montant);
		}
		?>
 	</div>
<?php 
	require('include/_pied.inc.html');
?>

