<?php $id = null;
$titre = null;
$resume = null;
$date_sortie = null;
$pays = null;
$image = null;
$heure = null;
$minutes = null;
if (isset($_GET["id"]) && isset($_GET["titre"]) && isset($_GET["resume"]) && isset($_GET["date_sortie"]) && isset($_GET["pays"])) {
    $id = $_GET["id"];
    $titre = $_GET["titre"];
    $resume = $_GET["resume"];
    $date_sortie = $_GET["date_sortie"];
    $pays = $_GET["pays"];
    $image = $_GET["image"];
    $heure = $_GET["heure"];
    $minutes = $_GET["minutes"];
} ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/sandstone/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>