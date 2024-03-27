<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getIdMax(): array
{

    $requete = getConnexion()->prepare("SELECT MAX(id) FROM film");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}