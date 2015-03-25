<?php
    require("include/_coDb.inc.php");
?>

<html>
<head>
    <title>Validation des frais de visite</title>
    <style type="text/css">
        <!-- body {background-color: white; color:EE8855; } 
        .titre { width : 180 ;  clear:left; float:left; } 
        .zone { float : left; color:CC8855 } -->
    </style>
</head>

<body>
    <div name="gauche" style="clear:left:;float:left;width:18%; background-color:white; height:100%;">
        <div name="coin" style="height:10%;text-align:center;"><img src="images/logo.jpg" width="100" height="60"/></div>
        <div name="menu" >
            <h2>Outils</h2>
            <ul><li>Frais</li>
                <ul><li><a href="formValidFrais.htm" >Enregistrer opération</a></li></ul>
                <ul><li><a href="cSeDeconnecter.php" >Deconnexion</a></li></ul>
            </ul>
        </div>
    </div>
    <div name="droite" style="float:left;width:80%;">
        <div name="haut" style="margin: 2 2 2 2 ;height:10%;float:left;"><h1>Validation des Frais</h1></div> 
        <div name="bas" style="margin : 10 2 2 2;clear:left;background-color:EE8844;color:white;height:88%;">
    
            <?php
                if( !isset($_POST['confMois'])){
            ?>

            <!-- 1er formulaire -->
            <form method="post" action="formValidFrais.php">
                <h1> Validation des frais par visiteur </h1>
                <label class="titre">Mois :</label>
                <select name="mois" class="zone">
                
                    <?php
                        $req = $bdd->prepare("SELECT DISTINCT fichefrais.mois as mois
                            FROM fichefrais
                            WHERE fichefrais.idEtat = 'CL'
                            ORDER BY fichefrais.mois DESC");
                        $req->execute();
                        $resultat = $req->fetchAll();
                        
                        foreach ($resultat as $ligne) {
                            $mois = $ligne['mois'];
                            $noMois = intval(substr($mois, 4, 2));
                            $annee = intval(substr($mois, 0, 4));
                            echo "<option value='".$mois."'>".$noMois."/".$annee."</option>";
                        }
                    ?>
                
                <input class='zone' type='submit' name='confMois'>
            </form>

            <?php
                }
            ?>

            <!-- 2e formulaire -->
            
            <?php
                if( isset($_POST['confMois']) & !isset($_POST['confVisiteur'])){
                    $moisPremierForm = $_POST["mois"];
                    $noMois = intval(substr($moisPremierForm, 4, 2));
                    $annee = intval(substr($moisPremierForm, 0, 4));
                    $sql = $bdd->prepare(" SELECT DISTINCT nom
                        FROM visiteur V, fichefrais FF, etat E
                        WHERE FF.idVisiteur = V.id
                        AND E.id = FF.idEtat
                        AND ".$moisPremierForm." = FF.mois");
                    $sql->execute();
                    echo $noMois." / ".$annee;
            ?>

            <form method="post" action="formValidFrais.php">
                <label class="titre">Choisir le visiteur :</label>
                <select name="lstVisiteur" class="zone">

                    <?php
                        while($visiteur = $sql->fetch()){
                            echo "<option value='".$visiteur['nom']."'>".$visiteur['nom']."</option>";
                        }
                    ?>
            
                </select>
                <input type="hidden" name="mois" value="<?php echo $moisPremierForm; ?>"/>
                <input class='zone' type='submit' name='confVisiteur'/>
            </form>
            
            <?php
                }
            ?>

            <!-- 3e formulaire -->
            
            <?php
                $sql = $bdd->prepare("SELECT fichefrais.horsForfait
                    FROM fichefrais");
                $sql->execute();
                $boolHorsForfait = $sql->fetch();
                if( isset($_POST['confVisiteur']) && !isset($_POST['confMois']) && $boolHorsForfait['horsForfait'] == 0){
                    $nomVisiteur = $_POST['lstVisiteur'];
                    $moisPremierForm = $_POST["mois"];
                    $noMois = intval(substr($moisPremierForm, 4, 2));
                    $annee = intval(substr($moisPremierForm, 0, 4));
            ?>

            <p class="titre" />
            <div style="clear:left;">
                <h2>Frais au forfait </h2>
            </div>
            <form method="post" action="formValidFrais.php">
                <table style="color:white;" border="1">
                    <tr>
                        <th>Repas midi</th>
                        <th>Nuitée </th>
                        <th>Etape</th>
                        <th>Km </th>
                        <th>Situation</th>
                    </tr>
    
                    <?php
                        echo $noMois." / ".$annee;
                        $sql = $bdd->prepare(" SELECT (montant*quantite) as prix
                            FROM lignefraisforfait LFF, fraisforfait FF
                            WHERE LFF.idFraisForfait = FF.id
                            AND LFF.mois = '".$moisPremierForm."'");
                        $sql->execute();
                        $valeur = $sql->fetchAll();
                        $vals = array();
                        foreach ($valeur as $val) {
                            array_push($vals, $val["prix"]);
                        }
                        echo "<tr align='center'>";
                        echo "<td width='80'> <input type='text' size='3' name='etape' value=".$vals[0]." /></td>";
                        echo "<td width='80'> <input type='text' size='3' name='km' value=".$vals[1]." /></td>";
                        echo "<td width='80'> <input type='text' size='3' name='nuitee' value=".$vals[2]." /></td>";
                        echo "<td width='80'> <input type='text' size='3' name='repas' value=".$vals[3]." /> </td>";
                    ?>
    
                    <td width='80'>
                        <select size='3' name='situ'>
                            <option value='E'>Enregistré</option>
                            <option value='V'>Validé</option>
                            <option value='R'>Remboursé</option>
                        </select>
                    </td>
                </tr>
                </table>
                <input type="hidden" name="mois" value="<?php echo $moisPremierForm; ?>"/>
                <input type="hidden" name="visiteur" value="<?php echo $nomVisiteur; ?>"/>
                <input class='zone' type='submit' name='confVisiteur'/>
            </form>

            <?php
                }
                else if(isset($_POST['confVisiteur']) && !isset($_POST['confMois']) && $boolHorsForfait['horsForfait'] == 1){
            ?>

            <p class="titre" />
            <div style="clear:left;">
                <h2>Hors Forfait</h2>  
            </div>
            <form>
                <table style="color:white;" border="1">
                    <tr>
                        <th>Date</th>
                        <th>Libellé </th>
                        <th>Montant</th>
                        <th>Situation</th>
                    </tr>
                    <tr align="center">
                    
                    <?php
                        /*$sql = $bdd->prepare(" SELECT mois
                            FROM lignefraisforfait LFF, fichefrais FF, etat E
                            WHERE ")*/

                        /*$sql = $bdd->prepare(" SELECT dateModif
                            FROM fichefrais
                            WHERE ");*/
                        $date = date("d/m/Y");
                        echo "
                        <td width='100'><input type='text' size='12' name='hfDate1' value='".$date."'/></td>
                        <td width='220'><input type='text' size='30' name='hfLib1'/></td> 
                        <td width='90'><input type='text' size='10' name='hfMont1'/></td>
                        <td width='80'>";
                    ?>

                        <select size="3" name="hfSitu1">
                        <option value="E">Enregistré</option>
                        <option value="V">Validé</option>
                        <option value="R">Remboursé</option>
                        </select>
                    </td>
                </tr>
            </table>  
        </form>

    <?php
        }
    ?>

<!--
<p class="titre"></p>
<div class="titre">Nb Justificatifs</div>
<input type="text" class="zone" size="4" name="hcMontant"/>  
<p class="titre" />
<label class="titre">&nbsp;</label>
<input class="zone"type="reset" />
<input class="zone"type="submit" />
-->
</form>
</div>
</div>
</body>
</html>
