<?php
function isEmail($email) {
    $email = strtolower($email);
    $pattern = '/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/';
    return (preg_match($pattern, $email));
}

function isValidUserName($userName) {
    $pattern = "/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9_.-]{3,15}$/";
    return (preg_match($pattern, $userName));
}

function isValidPass($pass) {
    $pattern = "/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/";
    return (preg_match($pattern, $pass));
}

function isValidText($text) {
    $pattern = "/^[a-zñáéíóúA-ZÑÁÉÍÓÚ0-9\s]*$/";
    return (preg_match($pattern, $text));
}

function isValidTextMessage($text) {
    $pattern = "/^[a-zñáéíóúA-ZÑÁÉÍÓÚ,.:;!¡¿?0-9\s]*$/";
    return (preg_match($pattern, $text));
}
?>