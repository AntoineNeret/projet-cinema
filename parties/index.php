<?php
/**
 * @var PDO $connexion
 */
require "../config/db-config.php";
require "../config/fonctions.php";

$requete = $connexion->prepare("SELECT * FROM film ORDER BY titre");

$requete->execute();

$films = $requete->fetchAll(PDO::FETCH_ASSOC);

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
    $minutes = $duree%60;
    $heure = floor($duree/60);

    echo "
                <div class='card border border-primary col-lg-6 bg-black text-light mx-auto ' style='width: 18rem;'>
                    <img src='$image' class='card-img-top mt-2 rounded' alt='Image de $titre'>
                    <div class='card-body'>
                        <h5 class='card-title'>$titre</h5>
                        <p class='card-text'>Le film dure $heure h et $minutes m</p>
                        <a class='btn btn-secondary' href='details.php?id=$id'>Voir le détail</a>
                        </div>
                </div>";
endforeach;
echo "</div>";?>
</body>
</html>