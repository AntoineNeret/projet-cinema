<?php
session_start();
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';
require BASE_PROJET."/src/database/film_list.php";
require BASE_PROJET."/src/_partials/header.php";
require BASE_PROJET."/src/_partials/footer.php";
require BASE_PROJET."/src/fonctions/dureeEnHeures.php";
require BASE_PROJET."/src/fonctions/dureeEnMinutes.php";
$utilisateur = null;
if (isset($_SESSION["utilisateur"])) {
    $utilisateur = $_SESSION["utilisateur"];
}
$films = getFilms();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/lux/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Les cinémas Haumont | Liste de nos films</title>
</head>
<body class="bg-body-secondary ">


<h1 class="mt-3 ms-3">Liste de nos films</h1>
<?php
echo "<div class='row row-cols-1 row-cols-md-2 g-4 m-3'>";
foreach ($films as $film):
    $id = $film["id"];
    $titre = $film["titre"];
    $duree = $film["duree"];
    $resume = $film["resume"];
    $date_sortie = $film["date_sortie"];
    $pays = $film["pays"];
    $image = $film["image"];

//    $image = "https://placehold.co/800/gray/white?text=".$film["titre"]."&font=roboto";
    $minutes = convertDureeIntoMinutes($duree);
    $heure = convertDureeIntoHeure($duree);

    echo "
                <div class='card border border-primary col-lg-6 bg-primary text-light mx-auto ' style='width: 18rem;'>
                    <img src='$image' class='card-img-top rounded' style='margin-top: 12px' alt='Image de $titre'>
                    <div class='card-body'>
                        <h5 class='card-title'>$titre</h5>
                        <p class='card-text'>Le film dure $heure h et $minutes m</p>
                        <a class='btn btn-secondary' href='details.php?id=$id'>Voir le détail</a>
                        </div>
                </div>";
endforeach;
echo "</div>";?>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>