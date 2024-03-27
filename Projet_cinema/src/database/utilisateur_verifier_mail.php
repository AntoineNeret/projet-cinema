<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getMailfromUser(): array
{

    $requete = getConnexion()->prepare("SELECT email_utilisateur FROM utilisateur;");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}