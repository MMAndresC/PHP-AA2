<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Guardar el tema antes de limpiar la sesión
$themes = $_SESSION['themes'] ?? null;

// Eliminar todas las variables de sesión sin destruirla
session_unset();

// Restaurar themes
if ($themes !== null) {
    $_SESSION['themes'] = $themes;
}
