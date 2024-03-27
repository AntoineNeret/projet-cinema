<?php
require_once '../../base.php';
require_once BASE_PROJET .
    '/src/database/db-config.php';

function addFilm(string $titre,int $duree,string $synopsis,string $date,string $pays,string $image, int $id_utilisateur): array
{

    $requete = getConnexion()->prepare("INSERT INTO film (titre,duree,resume,date_sortie,pays,image,id_utilisateur) VALUES (?,?,?,?,?,?,?);");

    $requete->execute(array($titre,$duree,$synopsis,$date,$pays,$image,$id_utilisateur));

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}