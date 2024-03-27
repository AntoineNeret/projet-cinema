<?php
session_start();
if (empty($_SESSION)){
    header("Location: index.php");
    exit();
}else{
/**
 * @var PDO $connexion
 */
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';
require BASE_PROJET."/src/_partials/header.php";
require BASE_PROJET."/src/_partials/footer.php";
require BASE_PROJET."/src/database/film_ajouter.php";
require BASE_PROJET."/src/database/utilisateur_obtenir_identifiant.php";
$erreurs = [];
$titre = "";
$duree = "";
$synopsis = "";
$date = "";
$pays = "";
$image = "";
$id_utilisateur = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Le formulaire a été soumis
//Traiter les données du formulaire
//Récupérer les valeurs saisies par l'utilisateur
//Superglobale $_POST : tableau associatif
    $titre = $_POST["titre"];
    $duree = $_POST["duree"];
    $synopsis = $_POST["synopsis"];
    $date = $_POST["date"];
    $pays = $_POST["pays"];
    $image = $_POST["image"];
    $pseudo_utilisateur = $_SESSION["utilisateur"]["pseudo"];
    $id_utilisateur = getIdfromUser($pseudo_utilisateur);
    $verifDate = explode('-',$date);
//Validation des données
    if (empty($titre)) {
        $erreurs["titre"] = "Le titre du film est obligatoire";
    }
    if (empty($duree)) {
        $erreurs["duree"] = "La durée du film est obligatoire";
    } elseif ($duree < 0) {
        $erreurs["duree"] = "La durée du film doit être un nombre positif";
    } elseif (is_int($duree)) {
        $erreurs["duree"] = "La durée du film doit être un entier";
    }
    if (empty($synopsis)) {
        $erreurs["synopsis"] = "Le synopsis du film est obligatoire";
    }
    if (empty($date)) {
        $erreurs["date"] = "La date de sortie du film est obligatoire";
    }
    if (!checkdate($verifDate[1],$verifDate[2],$verifDate[0])){
        $erreurs["date"] = "La date n'est pas valide";
    }
    if (empty($image)) {
        $erreurs["image"] = "l'image est obligatoire";
    } elseif (filter_var($image, FILTER_VALIDATE_URL) === false) {
        $erreurs["image"] = "L'image doit être une URL";
    }
    if (empty($pays)) {
        $erreurs["pays"] = "l'image est obligatoire";
    }
    if (empty($erreurs)) {

        $films = addFilm($titre,$duree,$synopsis,$date,$pays,$image,$id_utilisateur[0]["id_utilisateur"]);

        //Traitement des données (insertion dans une base de données)
        //Rediriger l'utilisateur vers une autre page du site (la page d'accueil)
        header("Location: index.php");
        exit();
    }
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
    <title>Les cinémas Haumont | Ajouter un film</title>
</head>
<body>

<h1 class="mt-3 ms-3">Ajoutez un film</h1>

<form action="" method="post" class="w-75 mx-auto mt-3">
    <div class="mb-3">
        <label for="InputTitle" class="form-label">Titre du film*</label>
        <input type="text" placeholder="Fight Club" name="titre" value="<?=  (!empty($erreurs)) ? $titre : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["titre"])) ? "border border-2 border-danger" : "" ?>" id="InputTitle">

        <?php if (isset($erreurs["titre"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["titre"]; ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="InputDuration" class="form-label">Durée du film (en minutes)*</label>
        <input type="number" name="duree" placeholder="140" value="<?=  (!empty($erreurs)) ? $duree : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["duree"])) ? "border border-2 border-danger" : "" ?>" id="InputDuration">
        <?php if (isset($erreurs["duree"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["duree"]; ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="InputSynopsis" class="form-label">Synopsis du film*</label>
        <textarea type="text" placeholder="Un jeune scientifique est enlevé par des extraterrestres..." name="synopsis" class="bg-light form-control rounded <?= (isset($erreurs["synopsis"])) ? "border border-2 border-danger" : "" ?>" id="InputSynopsis"><?=  (!empty($erreurs)) ? $synopsis : "" ?></textarea>
        <?php if (isset($erreurs["synopsis"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["synopsis"]; ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="InputDate" class="form-label">Date de sortie du film*</label>
        <input type="date" name="date" value="<?=  (!empty($erreurs)) ? $date : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["date"])) ? "border border-2 border-danger" : "" ?>" id="InputDate">

        <?php if (isset($erreurs["date"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["date"]; ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="InputCountry" class="form-label">Pays de production du film*</label>
        <input type="text" placeholder="France" name="pays" value="<?=  (!empty($erreurs)) ? $pays : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["pays"])) ? "border border-2 border-danger" : "" ?>" id="InputCountry">

        <?php if (isset($erreurs["pays"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["pays"]; ?></div>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="InputPicture" class="form-label">Image du film*</label>
        <input type="text" placeholder="https://placehold.co/800" name="image" value="<?=  (!empty($erreurs)) ? $image : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["image"])) ? "border border-2 border-danger" : "" ?>" id="InputPicture">
        <?php if (isset($erreurs["image"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["image"]; ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary mx-auto">Ajouter</button>
    <div id="InputTitle" class="form-text">* Ce champ est obligatoire</div>
</form>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
?>