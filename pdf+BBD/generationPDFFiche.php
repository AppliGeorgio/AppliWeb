<?php

/** 
 * Script d'affichage du PDF demandé par le visiteur.

 *Cette page ne peut être affichée qu'aun moins si la fiche a l'état validée , il y a un contrôle sur les fiches déjà presentent
 * Montant PDF est envoyé en session pour eviter un double calcul inutile , en revanche les sous calcul sont effectués dans cette page
 * @package default
 * @author  GSB
 */

  $repInclude = './include/';
  require($repInclude . "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estUserConnecte() ) {  ?>
<script language="Javascript">
			<!--
			document.location.replace("cSeConnecter.php");
			// -->
</script>
<?php
  }
  // Verification dela non existence du PDF , si il n'existe pas , on capture dans ob_start:
  $nomfichierpdf = $_SESSION['idPDF'] . "" . $_SESSION['moisPDF'];
  if (!file_exists('fichesFraisPdf/' . $nomfichierpdf . '.pdf')) {
  ob_start();
?>

<style>
table{
    background-color: #FFFFFF;
    border: 0.1em solid #777777;
    border-collapse: collapse;
    color: #000000;
  	valign:center;
  	text-align:center;
  	margin:auto;
  	width: 400px; overflow: auto
	 }
table th{ 
    background-color: #77AADD;
    border-bottom: 0.1em solid #777777;
	  border: 1px solid #000000;
    font-size: 1.1em;
    font-weight: bold;
    height: 21px;
    text-align: left;
    vertical-align: center;
	  padding: 5px;
    }

table td{
    border: 1px solid #000000;
    text-align: center;
	  padding: 10px;
    }

#containerTables{position:relative;margin:0 auto;text-align:center;padding-top:40px}
.paragraphe{font-size:20px;font-weight:bold;color:black;}
h1{font-size: 35 px;color:black;}
#containerInfo{position:relative;font-size:19px;color:black;font-weight:bold;margin-left:300px;}
#indication{position:relative;margin-top:50px;margin: 0 auto;color:black;font-weight:bold;text-align:center;padding-top:40px}
#footer{position:relative;margin: 0 auto;color:black;font-weight:bold;float:right;}
#signature{position:relative;}
.sousParagraphe{font-size:13px;color:black;}

</style>

<page backcolor="#fff" backimg="images/fondpdf.jpg" backimgx="left" backimgy="top" >
<div id="containerTotal">
  <div id="containerInfo">
    <h1>Fiche des Frais</h1>
    <u>NOM:</u> <?php echo $_SESSION['nomPDF']; ?> <br />
    <u>PRENOM: </u> <?php echo $_SESSION['prenomPDF']; ?><br />
    <u>MOIS: </u> <?php     $noMois = intval(substr($_SESSION['moisPDF'], 4, 2));
    						$annee = intval(substr($_SESSION['moisPDF'], 0, 4));
    						echo obtenirLibelleMois($noMois) . " " . $annee; ?><br />
    <u>MONTANT :</u>  <?php echo $_SESSION['montantPDF'] ; ?> € <br />
  </div>

<div id="containerTables">
<p class="paragraphe">Liste des éléments forfaitisés:</p>
<table>
	<tr>  <?php foreach ( $_SESSION['elementsForfaitPDF'] as $unLibelle => $uneQuantite ) { ?>
		<th>
		<?php echo $unLibelle ; ?>
		</th>
<?php  } ?>
	</tr>
	<tr> <?php foreach ( $_SESSION['elementsForfaitPDF'] as $unLibelle => $uneQuantite ) { ?>
		<td>
		<?php echo $uneQuantite ; ?>
		</td>
<?php  } ?>
	</tr>
</table>

<?php 

  // Calcul de la somme des forfaits seulement (hors hors forfait)
  $req = sommeForfaitValidePDF($_SESSION['moisPDF'], $_SESSION['idPDF']);
  $sommeForfait = mysql_query($req, $idConnexion);
  $sommeForfaitF = mysql_fetch_row($sommeForfait);

?>

<br />
<p class="sousParagraphe">Somme hors forfait totale validée: <?php echo $sommeForfaitF[0]; ?> € </p>

<br />

<p class="paragraphe">Liste des éléments Hors Forfaits:</p>
<table class="listeLegere">
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class="montant">Montant</th>                
             </tr>
<?php          
            // demande de la requête pour obtenir la liste des éléments hors
            // forfait du visiteur connecté pour le mois demandé
            $req = obtenirReqEltsHorsForfaitFicheFrais($_SESSION['moisPDF'], $_SESSION['idPDF']);
            $idJeuEltsHorsForfait = mysql_query($req, $idConnexion);
            $lgEltHorsForfait = mysql_fetch_assoc($idJeuEltsHorsForfait);
            
            // parcours des éléments hors forfait 
            while ( is_array($lgEltHorsForfait) ) {
            ?>
                <tr>
                   <td><?php echo(date('d/m/Y', strtotime($lgEltHorsForfait["date"]))); ?></td>
                   <td><?php echo filtrerChainePourNavig($lgEltHorsForfait["libelle"]) ; ?></td>
                   <td><?php echo $lgEltHorsForfait["montant"] . " €" ; ?></td>
                </tr>
            <?php
                $lgEltHorsForfait = mysql_fetch_assoc($idJeuEltsHorsForfait);
            }
            mysql_free_result($idJeuEltsHorsForfait);
?>
    </table>
<?php
	$req = sommeHorsForfaitValidePDF($_SESSION['moisPDF'], $_SESSION['idPDF']);
	$sommeHForfait = mysql_query($req, $idConnexion);
	$sommeHForfaitF = mysql_fetch_row($sommeHForfait);
?>
	<p class="sousParagraphe">Somme hors forfait totale validée: <?php echo $sommeHForfaitF[0];?> € </p>
</div>


  <div id="indication">

<?php

    $req = obtenirTarifsForfait();
    $tarrifsForfaits = mysql_query($req, $idConnexion);
    $tarrifsForfaitsF = mysql_fetch_assoc($tarrifsForfaits);

?>

    <p class="sousParagraphe">Tarifs forfaitaires du mois:</p>
    <table>
    				<tr>
    					<th class="date">Libelle</th>
    					<th class="libelle">Montant</th>
    				</tr> 
<?php
    while ( is_array($tarrifsForfaitsF) ) {
?>			

                <tr>
                   <td><?php echo $tarrifsForfaitsF["libelle"]; ?></td>
                   <td><?php echo $tarrifsForfaitsF["montant"] . " €"; ?></td>
                </tr>
<?php
                $tarrifsForfaitsF = mysql_fetch_assoc($tarrifsForfaits);
            }
            mysql_free_result($tarrifsForfaits);
?>
</table>
    </div>

  <div id="footer">
    <p>Fait à Paris le <?php echo(date('d-m-Y')); ?> </p>
  </div>
</div>
</page> 




<?php

$content = ob_get_clean();
require('html2pdf/html2pdf.class.php');

try{
	$pdf = new HTML2PDF('P', 'A4', 'fr'); // format d'affichage du pdf
	$pdf->writeHTML($content); //Ecriture du contenu HTML
	$pdf->Output( 'fichesFraisPdf/' . $nomfichierpdf .'.pdf' , 'F'); // Ecriture du ficher "F" sous le nom de la variable

  //Ci dessous rafraichissement de la page en Javascript pour affiche le PDF qui vient d'être crée
?>
  
<script language="Javascript">
      <!--
      document.location.replace("generationPDFFiche.php");
      // -->
</script>

<?php
  }
  Catch(HTML2FPDF_exeption $e){
  	die($e); 
  }
  }

  else{
    // SI le pdf existe dékà , on l'affiche
    header('Content-type: application/pdf');
    readfile( 'fichesFraisPdf/' . $nomfichierpdf . '.pdf');
}
?>