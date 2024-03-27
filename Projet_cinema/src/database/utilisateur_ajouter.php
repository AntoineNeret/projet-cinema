<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function addUtilisateur(string $pseudo,string $mail,string $passwordHash): array
{

    $requete = getConnexion()->prepare("INSERT INTO utilisateur VALUES (NULL,'$pseudo','$mail','$passwordHash');");

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}