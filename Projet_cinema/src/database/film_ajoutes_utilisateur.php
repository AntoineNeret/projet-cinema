<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getFilmforUser(int $id): array
{

    $requete = getConnexion()->prepare("SELECT * FROM film WHERE id_utilisateur = $id ");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}