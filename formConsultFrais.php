<?php
	$repInclude = './include/';
  	require($repInclude . "_coDb.inc.php");
  	require($repInclude . "_entete.inc.html");
  	require($repInclude . "_menu.inc.php");
?>
<div name="droite" style="float:left;width:80%;margin-bottom : 20px;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:black;height:88%;">
		<h1> Période </h1>
			<form action="formConsultFrais.php" method="POST">
				<label class="titre">Année/Mois :</label> 
				<input class="zone" type="text" name="dateConsult" size="12" />	
				<input type="submit" class="bouton" value="Choisir une date" />
			</form>
			<?php
				//si l'utilisateur a choisi un mois et une année
				if (isset($_POST['dateConsult'])) 
    			{
		    		$dateConsult = $_POST['dateConsult'];	
		    		// Affiche la fiche de frais pour chaque utilisateur dans le mois sélectionné
					$req = $bdd->prepare("SELECT mois, dateModif, idEtat, nom, prenom, nbJustificatifs
										  FROM fichefrais F, visiteur V
										  WHERE V.id = F.idVisiteur
										  AND mois = :dateConsult
										  AND (idEtat = 'CL' OR idEtat = 'VA')");
					$req->bindValue(":dateConsult", $dateConsult, PDO::PARAM_INT);
			    	$req->execute();
			    	$resultat = $req->fetchAll();	

			    	if (empty($resultat))
			    	{
			    		echo "<p style='color:red;font-size:20px;text-align:center;'><br><br>Il n'y a aucune fiche de frais pour la période choisie.</p>";
			    	} 
			    	else 
			    	{					
			?>
		<p class="titre" />
		<div style="clear:left;"><h2>Frais au forfait </h2></div>
		<table style="color:black;" border="1">
			<tr>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Nom Visiteur</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Prénom Visiteur </th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Etat fiche de frais</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Nombre Justificatifs</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Date opération</th>
			</tr>
			<?php
			    	foreach($resultat as $ligne) 
					{
						$situation= $ligne["idEtat"]; 
						$dateModif = $ligne["dateModif"];
						$mois = $ligne["mois"];
						$nom = $ligne["nom"];
						$prenom = $ligne["prenom"];	
						$nbJustificatifs = $ligne["nbJustificatifs"];	

						if ($situation == 'CL') 
							{
								$situation = 'Saisie cloturée';
							}
						if ($situation == 'CR')
							{
								$situation = 'Saisie en cours';
							}
						if ($situation == 'RB')
							{
								$situation = 'Remboursée';
							}
						if ($situation == 'VA') 
							{
								$situation = 'Validée et mise en paiement';
							}
			?>
			<tr align="center">
				<td width="80"> <label size="3" name="situation" /><?php echo $nom; ?></td>	
				<td width="80"> <label size="3" name="situation" /><?php echo $prenom; ?></td>		
				<td width="80"> <label size="3" name="situation" /><?php echo $situation; ?></td>
				<td width="80"> <label size="3" name="dateOper" /><?php echo  $nbJustificatifs; ?></td>	
				<td width="80"> <label size="3" name="dateOper" /><?php echo  $dateModif; ?></td>					
			</tr>
			<?php
				}
			}
			?>
			</table>
			<?php
				// Affiche le hors forfait pour chaque utilisateur dans le mois sélectionné
				$req1 = $bdd->prepare("SELECT  libelle, date, montant, etat,  nom, prenom
									  FROM lignefraishorsforfait L, visiteur V
									  WHERE V.id =  L.idVisiteur 
									  AND (etat = 'CL' OR etat = 'VA')
									  AND L.mois = :dateConsult");
				$req1->bindValue(":dateConsult", $dateConsult, PDO::PARAM_INT);
		    	$req1->execute();
		    	$resultat1 = $req1->fetchAll();

		    	if (empty($resultat1))
			    	{
			    		echo "";
			    	} 
			    else
			    {
			?>
			<p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
		<table style="color:black;" border="1">
			<tr><th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Nom Visiteur</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Prénom Visiteur</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Date</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Libellé </th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Montant</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Situation</th>
				<th style="background-color:#77AADD; color : white; font-variant : small-caps;font-size : 16px;">Date opération</th></tr>
			<?php
		    	foreach($resultat1 as $ligne1) 
				{
					$libelle = $ligne1["libelle"];
					$date = $ligne1["date"];
					$montant = $ligne1["montant"];
					$situation1= $ligne1["etat"]; 
					$dateModif1 = $ligne1["date"];
					$prenom1 = $ligne1["prenom"];
					$nom1 = $ligne1["nom"];

					if ($situation1 == 'CL') 
							{
								$situation1 = 'Saisie cloturée';
							}
						if ($situation1 == 'CR')
							{
								$situation1 = 'Saisie en cours';
							}
						if ($situation1 == 'RB')
							{
								$situation1 = 'Remboursée';
							}
						if ($situation1 == 'VA') 
							{
								$situation1 = 'Validée et mise en paiement';
							}
			?>
			<tr align="center">
				<td width="80"> <label size="3" name="situation" /><?php echo $nom1; ?></td>	
				<td width="80"> <label size="3" name="situation" /><?php echo $prenom1; ?></td>
				<td width="100" ><label size="12" name="hfDate1"/><?php echo $date;?></td>
				<td width="220"><label size="30" name="hfLib1"/><?php echo $libelle;?></td> 
				<td width="90" ><label size="10" name="hfMont1"/><?php echo $montant;?></td>
				<td width="80"> <label size="3" name="hfSitu1" /><?php echo $situation1;?></td>
				<td width="80"> <label size="3" name="hfDateOper1" /><?php echo $dateModif1;?></td>		
			</tr>
			<?php
			}
		}
		}
		?>
		</table>			
	</form>
	</div>
</div>
<br><br><br>
<?php
require($repInclude . "_pied.inc.html");
?>
