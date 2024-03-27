<?php
session_start();
if (!empty($_SESSION)){
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
require_once BASE_PROJET."/src/database/utilisateur_verifier_mail.php";
require_once BASE_PROJET."/src/database/utilisateur_obtenir_mot_de_passe.php";
require_once BASE_PROJET."/src/fonctions/Verifier_force_mdp.php";

$erreurs = [];
$bonMotDepasse=null;
$pseudo = "";
$mdp = "";
$mail = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mails_utilisateurs = getMailfromUser();
//Le formulaire a été soumis
//Traiter les données du formulaire
//Récupérer les valeurs saisies par l'utilisateur
//Superglobale $_POST : tableau associatif
    $pseudo = $_POST["pseudo"];
    $mdp = $_POST["mdp"];
    $mail = $_POST["mail"];

    $mdp_utilisateurs = getPasswordfromUser($pseudo,$mail);
    if (empty($mdp_utilisateurs)){
        $erreurs["tout"] = "Une ou plusieurs informations saisies sont invalides";
    }else {
            if (password_verify($mdp, $mdp_utilisateurs[0]["password_utilisateur"])) {
                $bonMotDepasse = true;
            }
        }
//Validation des données
    if (!$bonMotDepasse){
        $erreurs["tout"] = "Une ou plusieurs informations saisies sont invalides";
    }
    if (empty($mail)) {
        $erreurs["mail"] = "Votre adresse mail est obligatoire";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $erreurs["mail"] = "le mail n'est pas valide";
    }
    if (empty($pseudo)) {
        $erreurs["pseudo"] = "Votre pseudo est obligatoire";
    }
    if (empty($mdp)) {
        $erreurs["mdp"] = "Votre mot de passe est obligatoire";
    }
    if (empty($erreurs)) {

        $_SESSION["utilisateur"] = [
            "pseudo" => $pseudo,
            "mail" => $mail,
        ];
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/lux/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Les cinémas Haumont | Connexion</title>
</head>
<body class="bg-secondary ">
<h1 class="mt-3 ms-3">Connectez vous</h1>

<form action="" method="post" class="w-50 mx-auto mt-3">
    <div class="mb-3">
        <label for="InputPseudo" class="form-label">Votre pseudonyme*</label>
        <input type="text" name="pseudo" placeholder="Eyce" value="<?=  (!empty($erreurs)) ? $pseudo : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["pseudo"])) ? "border border-2 border-danger" : "" ?>" id="InputPseudo">

        <?php if (isset($erreurs["pseudo"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["pseudo"]; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="InputMail" class="form-label">Votre adresse mail*</label>
        <input type="text" name="mail" placeholder="phongcroissant@gmail.com" value="<?=  (!empty($erreurs)) ? $mail : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["mail"])) ? "border border-2 border-danger" : "" ?>" id="InputMail">

        <?php if (isset($erreurs["mail"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["mail"]; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="InputPassword" class="form-label">Votre mot de passe*</label>
        <input type="password" name="mdp" value="<?=  (!empty($erreurs)) ? $mdp : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["mdp"])) ? "border border-2 border-danger" : "" ?>" id="InputPassword">

        <?php if (isset($erreurs["mdp"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["mdp"]; ?></div>
        <?php endif; ?>
    </div>
    <?php if (isset($erreurs["tout"])): ?>
        <div id="emailHelp" class="form-text text-danger"><?= $erreurs["tout"]; ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary mx-auto mt-2">Se connecter</button>
    <div id="InputTitle" class="form-text">* Ce champ est obligatoire</div>
    <script src="../js/bootstrap.bundle.min.js"></script>

</form>
</body>
<?php
}?>