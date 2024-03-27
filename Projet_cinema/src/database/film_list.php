<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getFilms(): array
{

    $requete = getConnexion()->prepare("SELECT * FROM film ORDER BY titre");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}