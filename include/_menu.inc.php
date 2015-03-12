<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * @todo  RAS
 */
	if(isset($_SESSION['nom'])) {
?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
        <h2>
		<?php 
            echo $_SESSION['nom'].' '.$_SESSION['prenom'];
        ?>
		</h2>

        <h3>Visiteur médical</h3>        

      </div>  

        <ul id="menuList">
           <li class="smenu">
              <a href="cAccueil.php" title="Page d'accueil">Accueil</a>
           </li>
           <li class="smenu">
              <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
           </li>
           <?php
           if($_SESSION['comptable'] == 1){
            echo "<li class='smenu'>";
            echo "<a href='formValidFrais.htm' title='Saisie fiche de frais du mois courant'>Saisie fiche de frais</a></li>";
           }
           else{
            echo "<li class='smenu'>";
            echo "<a href='cSaisieFicheFrais.php' title='Saisie fiche de frais du mois courant'>Saisie fiche de frais</a></li>";
            echo "<li class='smenu'>";
            echo "<a href='cConsultFichesFrais.php' title='Consultation de mes fiches de frais'>Mes fiches de frais</a></li>";
           }
           ?>
         </ul>
    </div>
	<?php 
	  }
	?>
    

    
