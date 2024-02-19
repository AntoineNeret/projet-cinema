<?php
$id = null;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
/**
 * @var PDO $connexion
 */
require "../config/db-config.php";
require "../config/fonctions.php";

$requete = $connexion->prepare("SELECT * FROM film WHERE id=$id ORDER BY titre");

$requete->execute();

$details = $requete->fetchAll(PDO::FETCH_ASSOC);

foreach ($details as $detail):
    $id = $detail["id"];
    $titre = $detail["titre"];
    $duree = $detail["duree"];
    $resume = $detail["resume"];
    $date_sortie = $detail["date_sortie"];
    $pays = $detail["pays"];
    $image = $detail["image"];

    $minutes = $duree%60;
    $heure = floor($duree/60);
endforeach;
$date = dateToFrench( $date_sortie ,"l j F Y");

if ($heure>1){
    $affichageHeure = "heures";
}else{
    $affichageHeure = "heure";
}

if ($minutes>1){
    $affichageMinutes = "minutes";
}elseif ($minutes==0){
    $affichageMinutes = "";
}else{
    $affichageMinutes = "minute";
}

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
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand fs-2 fw-bold" href="index.php">Les cinémas Haumont</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link disabled" aria-current="page" aria-disabled="true">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Pricing</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container d-flex mt-5"><?=


    "<img src='$image' class='w-25 ' alt='Image de $titre'>
    <div class='ps-4'>
    <p class='fw-bold fs-3 row'>$titre</p>
    <p class='row'> est sorti le $date</p>
    <p class='row'> dure $heure $affichageHeure et $minutes $affichageMinutes</p>
    <p class='row fs-4 pt-2'> Synopsis</p>
    <p class='row'>$resume</p>

    </div>";
    ?></>

</body>