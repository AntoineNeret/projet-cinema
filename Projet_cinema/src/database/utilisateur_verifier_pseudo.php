<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getPseudofromUser(): array
{

    $requete = getConnexion()->prepare("SELECT pseudo_utilisateur FROM utilisateur;");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}