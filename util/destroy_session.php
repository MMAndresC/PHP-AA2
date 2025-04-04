<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destruir todas las variables de sesión.
$themes =  $_SESSION['themes'] ?? null;
$_SESSION = array();
//Si themes existe se deja porque la usa el navBar y es poco probable que cambie
if(isset($themes)) $_SESSION['themes'] = $themes;

// Borrar también la cookie de sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();