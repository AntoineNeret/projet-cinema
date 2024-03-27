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
require_once BASE_PROJET."/src/_partials/header.php";
require_once BASE_PROJET."/src/database/utilisateur_ajouter.php";
require_once BASE_PROJET."/src/database/utilisateur_verifier_mail.php";
require_once BASE_PROJET."/src/database/utilisateur_verifier_pseudo.php";
require_once BASE_PROJET."/src/_partials/footer.php";
require_once BASE_PROJET."/src/fonctions/Verifier_force_mdp.php";

$erreurs = [];
$pseudo = "";
$mdpconfirmation = "";
$mdp = "";
$mail = "";
$forceMDP = "";
$mailExistant=false;
$pseudoExistant=false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mails_utilisateurs = getMailfromUser();

    $pseudos_utilisateurs = getPseudofromUser();
//Le formulaire a été soumis
//Traiter les données du formulaire
//Récupérer les valeurs saisies par l'utilisateur
//Superglobale $_POST : tableau associatif
    $pseudo = $_POST["pseudo"];
    $mdpconfirmation = $_POST["mdpconfirmation"];
    $mdp = $_POST["mdp"];
    $mail = $_POST["mail"];

    foreach ($mails_utilisateurs as $mail_utilisateur){
        if ($mail == $mail_utilisateur["email_utilisateur"]){
            $mailExistant=true;
        }
    }

    foreach ($pseudos_utilisateurs as $pseudo_utilisateur){

        if ($pseudo == $pseudo_utilisateur["pseudo_utilisateur"]){
            $pseudoExistant=true;
        }
    }



if (strlen($mdp)>=8 && strlen($mdp)<=14){
    $longueurPassword=true;
}
$forceMDP = checkPasswordStrength($mdp);
//Validation des données
if (empty($mail)) {
        $erreurs["mail"] = "Votre adresse mail est obligatoire";
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $erreurs["mail"] = "le mail n'est pas valide";
    }
    if ($mailExistant) {
        $erreurs["mail"] = "Un utilisateur s'est déjà inscrit avec cette adresse mail";
    }
    if (empty($pseudo)) {
        $erreurs["pseudo"] = "Votre pseudo est obligatoire";
    }
    if ($pseudoExistant) {
        $erreurs["pseudo"] = "Ce pseudonyme est déjà utilisé";
    }
    if (empty($mdp)) {
        $erreurs["mdp"] = "Votre mot de passe est obligatoire";
    }
if (checkPasswordStrength($mdp)=="Easy to guess"){
    $erreurs["mdp"] = $forceMDP;
}
if (checkPasswordStrength($mdp)=="Medium difficulty"){
    $erreurs["mdp"] = $forceMDP;
}
    if (empty($mdpconfirmation)) {
        $erreurs["mdpconfirmation"] = "Confirmer votre mot de passe est obligatoire";
    }elseif ($mdp!=$mdpconfirmation) {
        $erreurs["mdpconfirmation"] = "Vous n'avez pas saisi le même mot de passe";
    }
    $complexiteMDP = $forceMDP;
    if (empty($erreurs)) {

        $passwordHash = password_hash($mdp, PASSWORD_BCRYPT);

        $utilisateur = addUtilisateur($pseudo,$mail,$passwordHash);

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
    <title>Les cinémas Haumont | Inscription</title>
</head>
<body class="bg-secondary ">

<h1 class="mt-3 ms-3">Inscrivez vous</h1>

<form action="" method="post" class="w-50 mx-auto mt-3">
    <div class="mb-3">
        <label for="InputPseudo" class="form-label">Votre pseudonyme*</label>
        <input type="text" placeholder="Eyce" name="pseudo" value="<?=  (!empty($erreurs)) ? $pseudo : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["pseudo"])) ? "border border-2 border-danger" : "" ?>" id="InputPseudo">

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


            <div id="emailHelp" class="form-text <?= ((isset($erreurs["mdp"]))) ? "text-danger" : "text-primary" ?>"><?= ((isset($erreurs["mdp"]))) ? $erreurs["mdp"] : $forceMDP ?></div>

    </div>


    <div class="mb-3">
        <label for="InputPasswordConfirmation" class="form-label">Confirmez votre mot de passe*</label>
        <input type="password" name="mdpconfirmation" value="<?=  (!empty($erreurs)) ? $mdpconfirmation : "" ?>" class="form-control bg-light rounded <?= (isset($erreurs["mdpconfirmation"])) ? "border border-2 border-danger" : "" ?>" id="InputPasswordConfirmation">

        <?php if (isset($erreurs["mdpconfirmation"])): ?>
            <div id="emailHelp" class="form-text text-danger"><?= $erreurs["mdpconfirmation"]; ?></div>
        <?php endif; ?>

    </div>

        <button type="submit" class="btn btn-primary mx-auto">Créer</button>
    <div id="InputTitle" class="form-text">* Ce champ est obligatoire</div>
    <script src="../js/bootstrap.bundle.min.js"></script>

</form>
</body>
<?php } ?>