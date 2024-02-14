<?php
/**
 * @var PDO $connexion
 */
require "../config/db-config.php";

$requete = $connexion->prepare("SELECT * FROM film ORDER BY titre");

$requete->execute();

$films = $requete->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/sandstone/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-dark-subtle">
<?php
echo "<div class='row row-cols-1 row-cols-md-2 g-4'>";
foreach ($films as $film):
    $id = $film["id"];
    $titre = $film["titre"];
    $duree = $film["duree"];
    $resume = $film["resume"];
    $date_sortie = $film["date_sortie"];
    $pays = $film["pays"];
    $image = $film["image"];

    $minutes = $duree%60;
    $heure = floor($duree/60);

    echo "
                <div class='card border border-primary col-lg-6 bg-black text-light mx-auto' style='width: 18rem;'>
                    <img src='$image' class='card-img-top' alt='Image de $titre'>
                    <div class='card-body'>
                        <h5 class='card-title'>$titre</h5>
                        <p class='card-text'>Le film dure $heure h et $minutes m</p>
                        <a class='btn btn-secondary' href='details.php?id=$id&titre=$titre&resume=$resume&date_sortie=$date_sortie&pays=$pays&image=$image&heure=$heure&minutes=$minutes'>Voir le détail</a>
                        </div>
                </div>";
endforeach;
echo "</div>";?>
</body>
</html>