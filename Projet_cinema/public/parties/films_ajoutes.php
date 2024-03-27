<?php
session_start();
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';
require BASE_PROJET."/src/_partials/header.php";
require BASE_PROJET."/src/_partials/footer.php";
require BASE_PROJET."/src/database/film_ajoutes_utilisateur.php";
require BASE_PROJET."/src/fonctions/dureeEnHeures.php";
require BASE_PROJET."/src/fonctions/dureeEnMinutes.php";
require BASE_PROJET."/src/fonctions/Formatage_date.php";
require_once BASE_PROJET."/src/database/utilisateur_obtenir_identifiant.php";
$id_temp = getIdfromUser($_SESSION["utilisateur"]["pseudo"]);
$id = $id_temp[0]["id_utilisateur"];
$filmsajoutes = getFilmforUser($id);
$pseudo_utilisateur = $_SESSION["utilisateur"]["pseudo"];

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
    <title>Les cinémas Haumont | Liste des films que vous avez ajoutés</title>
</head>
<body>
<h1 class="mt-4 ms-3">Liste des films ajoutés par <?= $pseudo_utilisateur ?></h1>
<div class="container mt-4">
<?php
echo "<div class='row row-cols-1 row-cols-md-2 g-4 m-3'>";
foreach ($filmsajoutes as $filmajoute):
    $id = $filmajoute["id"];
    $titre = $filmajoute["titre"];
    $duree = $filmajoute["duree"];
    $resume = $filmajoute["resume"];
    $date_sortie = $filmajoute["date_sortie"];
    $pays = $filmajoute["pays"];
    $image = $filmajoute["image"];
    $id_utilisateur = $filmajoute["id_utilisateur"];
    $heure = convertDureeIntoHeure($duree);
    $minutes = convertDureeIntoMinutes($duree);

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
}
    echo "
                <div class='card border border-primary col-lg-6 bg-primary text-light mx-auto rounded' style='width: 18rem;'>
                    <img src='$image' class='card-img-top rounded' style='margin-top: 12px' alt='Image de $titre'>
                    <div class='card-body'>
                        <h5 class='card-title'>$titre</h5>
                        <p class='card-text'>Le film dure $heure h et $minutes m</p>
                        <a class='btn btn-secondary' href='details.php?id=$id'>Voir le détail</a>
                        </div>
                </div>";
endforeach; ?>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>

</body>