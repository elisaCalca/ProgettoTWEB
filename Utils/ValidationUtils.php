<?php

/*
    Funzioni di Utility per la validazione lato server
*/

// Ritorna la stringa di testo validata e sanificata rimuovendo tag HTML e caratteri non consentiti
function validateText($text) {
    $text = filter_var($text, FILTER_SANITIZE_STRING);
    return $text;
}

// Ritorna ll'email validata e sanificata rimuovendone i caratteri non consentiti
function validateEmail($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))
        return $email;
    else
        return null;
}

// Ritorna la password validata e sanificata rimuovendo tag HTML e caratteri non consentiti
function validatePassword($password) {
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    if (preg_match("/^((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*){8,}$/", $password))
        return $password;
    else
        return null;
}
?>