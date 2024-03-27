<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getIdfromUser(string $pseudo): array
{

    $requete = getConnexion()->prepare("SELECT id_utilisateur FROM utilisateur WHERE pseudo_utilisateur LIKE '$pseudo'");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}