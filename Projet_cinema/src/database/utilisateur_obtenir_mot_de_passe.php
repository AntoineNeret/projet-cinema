<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function getPasswordfromUser(string $pseudo,string $mail): array
{

    $requete = getConnexion()->prepare("SELECT password_utilisateur FROM utilisateur WHERE pseudo_utilisateur LIKE '$pseudo' && email_utilisateur LIKE '$mail';");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}