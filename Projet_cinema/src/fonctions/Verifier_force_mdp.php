<?php
function checkPasswordStrength(string $password) {
    // Initialize variables
    $strength = 0;

    // Check password length
    if (strlen($password) < 8) {
        return "Easy to guess";
    } else {
        $strength += 1;
    }

    // Check for mixed case
    if (preg_match("/[a-z]/", $password) && preg_match("/[A-Z]/", $password)) {
        $strength += 1;
    }

    // Check for numbers
    if (preg_match("/\d/", $password)) {
        $strength += 1;
    }

    // Check for special characters
    if (preg_match("/[^a-zA-Z\d]/", $password)) {
        $strength += 1;
    }

    // Return strength level
    if ($strength < 2) {
        return "Easy to guess";
    } else if ($strength === 2) {
        return "Medium difficulty";
    } else if ($strength === 3) {
        return "Difficult";
    } else {
        return "Extremely difficult";
    }
}