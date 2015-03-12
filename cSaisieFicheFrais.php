<?php 

	require('include/_entete.inc.html');
	require('include/_menu.inc.html');
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
			forfaitises($pdo);
			if(isset($_POST['valide'])){
			ajouterforfait($pdo);
			}
		}

		elseif($_GET['type'] == 'hforf') {
			// Sinon on appelle la fonction qui affiche le formulaire non forfaitisé avec en argument la variable de connexion à la BDD
			non_forfaitises($pdo);
		}

		if(isset($_GET['etape'])) {
			supprimerligne($pdo,$_GET['idLigneHF']);
			header('Location:cSaisieFicheFrais.php');
		}

		if(isset($_POST['cmd'])) {
			$id = $_SESSEION['id'];
			$date1 = $_POST['txtDateHF'];
			$mois = date("Ym");
			$date1 = $_POST['txtDateHF'];
			$date = date("Y/m/d", strtotime($date1));

			$libelle = $_POST['txtLibelleHF'];
			$montant = $_POST['txtMontantHF'];
			ajouterhorsforfait($pdo,$id,$mois,$date,$libelle,$montant);
		}
		?>
 	</div>
<?php 
	require('include/_pied.inc.html');
?>
