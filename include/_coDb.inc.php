<?php
// ==================== CONNEXION DB ==============================
    $host_name  = "localhost";
    $database   = "gsb_frais";
    $user_name  = "root";
    $password   = "";

   // $bdd = mysqli_connect($host_name, $user_name, $password, $database);
    $bdd = new PDO("mysql:host=".$host_name.";dbname=".$database, $user_name, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (mysqli_connect_errno())
    {
        echo "La connexion au serveur MySQL n'a pas abouti : " . mysqli_connect_error();
    }

    //Démarre la session des utilisateurs
    session_start();
?>