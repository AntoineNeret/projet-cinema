<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getDetail(int $id): array
{

    $requete = getConnexion()->prepare("SELECT * FROM film WHERE id=$id");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}