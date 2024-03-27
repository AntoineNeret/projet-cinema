<?php
function convertDureeIntoMinutes(int $duree): int
{
    return $duree % 60;
}