<?php
$utilisateur = null;
if (isset($_SESSION["utilisateur"])) {
    $utilisateur = $_SESSION["utilisateur"];
}
?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand fs-2 fw-bold" href="index.php">Les cinémas Haumont</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION["utilisateur"])) {echo"
                <li class='nav-item'>
                    <a class='nav-link' href='ajouter.php'>Ajouter un film</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='films_ajoutes.php'>Vos films ajoutés</a>
                </li>
                    <li class='nav-item'>
                    <a class='nav-link' href='deconnexion.php'>Se déconnecter</a>
                </li>
                ";}else{
                echo "
                <li class='nav-item'>
                    <a class='nav-link' href='connexion.php'>Se connecter</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link'  href='inscription.php'>S'inscrire</a>
                </li>";}
                ?>
            </ul>
        </div>
</nav>
<div class="text-center fs-2 mt-3"><?php
    if (isset($_SESSION["utilisateur"])) {
        $utilisateur = $_SESSION["utilisateur"];
        echo "Vous êtes connecté en tant que ".$utilisateur["pseudo"];
    }
    ?></div>
</div>