<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function verifyFilmExist(int $id): bool
{

    $requete = getConnexion()->prepare("SELECT titre FROM film WHERE id=$id");

    $requete->execute();

    $films = $requete->fetchAll(PDO::FETCH_ASSOC);

    if (isset($films[0]["titre"])){
        return true;
    }else{
        return false;
    }
}