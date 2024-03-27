<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getPseudofromUserwithId(int $id): array
{

    $requete = getConnexion()->prepare("SELECT pseudo_utilisateur FROM utilisateur WHERE id_utilisateur LIKE '$id'");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}