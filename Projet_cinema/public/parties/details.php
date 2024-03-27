<?php
session_start();
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';
require BASE_PROJET."/src/database/film_detail.php";
require BASE_PROJET."/src/database/film_verifier_id.php";
require BASE_PROJET."/src/database/utilisateur_obtenir_pseudo_avec_identifiant.php";
require BASE_PROJET."/src/fonctions/dureeEnHeures.php";
require BASE_PROJET."/src/fonctions/dureeEnMinutes.php";
require BASE_PROJET."/src/fonctions/Formatage_date.php";
require BASE_PROJET."/src/fonctions/film_verifier_trou.php";
require BASE_PROJET."/src/_partials/header.php";
require BASE_PROJET."/src/_partials/footer.php";
$maxID = getIdMax();
$idIncorrect = false;
if (!array_key_exists("id",$_GET)){
$idIncorrect = true;
}elseif ($_GET["id"]==null){
    $idIncorrect = true;
}elseif ($_GET["id"]>$maxID[0]["MAX(id)"]) {
    $idIncorrect = true;
} elseif (!verifyFilmExist($_GET["id"])) {
    $idIncorrect = true;
}

if (!$idIncorrect){
    $id = $_GET["id"];

$details = getDetail($id);

    foreach ($details as $detail):
        $id = $detail["id"];
        $titre = $detail["titre"];
        $duree = $detail["duree"];
        $resume = $detail["resume"];
        $date_sortie = $detail["date_sortie"];
        $pays = $detail["pays"];
        $image = $detail["image"];
        $id_utilisateur = $detail["id_utilisateur"];
        if ($detail["id_utilisateur"]==null){
            $pseudo_utilisateur = "Administrateur";
        }else {
            $pseudo = getPseudofromUserwithId($id_utilisateur);
            $pseudo_utilisateur = $pseudo[0]['pseudo_utilisateur'];
        }
        $heure = convertDureeIntoHeure($duree);
        $minutes = convertDureeIntoMinutes($duree);
    endforeach;
    $date = dateToFrench($date_sortie, "l j F Y");

    if ($heure > 1) {
        $affichageHeure = "heures ";
    } else {
        $affichageHeure = "heure ";
    }

    if ($minutes > 1) {
        $affichageMinutes = "minutes";
    } elseif ($minutes == 0) {
        $affichageMinutes = "";
    } else {
        $affichageMinutes = "minute";
    }
if ($minutes == 0){
    $minutes = "";
}else{
    $minutes="et ".$minutes;
}
if ($pays=="Etats-Unis"){
 $strPays = "aux";
}else if ($pays=="Japon"||$pays=="Royaume-Uni"){
 $strPays = "au";
}else{
    $strPays = "en";
}}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/lux/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Les cinémas Haumont | Détail du film <?=$titre?></title>
</head>
<body>

<div class="container d-flex my-auto mt-5 my-5">
    <div class="row flex-xl-row flex-column"><?php
    if (!$idIncorrect) {
        echo "<img src='$image' class='w-25 my-auto' alt='Image de $titre'>
    <div class='ps-4 col my-auto'>
    <p class='fw-bold fs-3 row'>$titre</p>
    <p class='row'> est sorti le $date</p>
    <p class='row'> est produit $strPays $pays</p>
    <p class='row'> Ce film a été ajouté par $pseudo_utilisateur </p>
    <p class='row'> dure $heure $affichageHeure $minutes $affichageMinutes</p>
    <p class='row fs-4 pt-2'> Résumé</p>
    <p class='row'>$resume</p>

    </div>";
    }else{
        echo "<p class='fw-bold row mx-auto fs-1 pt-5'>Votre film est introuvable</p>";
    }
    ?></div></div>
<script src="../js/bootstrap.bundle.min.js"></script>

</body>