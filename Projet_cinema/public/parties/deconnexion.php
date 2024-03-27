<?php
session_start();
if (empty($_SESSION)){
    header("Location: connexion.php");
}else{
    $_SESSION=[];
    header("Location: index.php");
}