<?php
function convertDureeIntoHeure(int $duree): float
{

    return floor($duree / 60);
}