<?php

// Evita que muestre los errores en pantalla
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Asegura que si el directorio logs no existe, lo crea
$logs_dir = __DIR__ . "/../logs/";
$errors_log = $logs_dir . "php_error.log";
$fatal_errors_log = $logs_dir . "/php_fatal_errors.log";

//Crear el directorio si no existe
if (!is_dir($logs_dir)) {
    mkdir($logs_dir, 777, true);
}

//Crear los ficheros de log si no crean
if (!file_exists($errors_log)) {
    touch($errors_log);
    chmod($errors_log, 0644);
}

// Verificar si el archivo de log para errores fatales existe, si no, crearlo
if (!file_exists($fatal_errors_log)) {
    touch($fatal_errors_log);
    chmod($fatal_errors_log, 0644);
}


// Controla los warning
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $logs_dir = __DIR__ . "/../logs/";
    $errors_log = $logs_dir . "php_error.log";
    $date = date("Y-m-d H:i:s");
    // Guardar error en un log
    $message = "[$date] ERROR [$errno]: $errstr en $errfile línea $errline" . PHP_EOL;
    error_log($message, 3, $errors_log);

    // Mostrar los mensajes
    if ($errno == E_WARNING || $errno == E_NOTICE || $errno == E_USER_WARNING) {
        header("Location: ../view/error_warning.php");
        exit();
    }

    // Retorna false para que siga ejecutando los errores por defecto
    return false;
}

// Establecer la función de manejo de errores
set_error_handler("customErrorHandler");


// Controla los errores críticos
function fatalErrorHandler(): void
{
    $logs_dir = __DIR__ . "/../logs/";
    $fatal_errors_log = $logs_dir . "/php_fatal_errors.log";

    $error = error_get_last();

    if ($error && ($error['type'] === E_ERROR || $error['type'] === E_PARSE || $error['type'] === E_CORE_ERROR || $error['type'] === E_COMPILE_ERROR)) {
        // Guardar error en un log
        $date = date("Y-m-d H:i:s");
        $message = "[$date] FATAL ERROR: {$error['message']} en {$error['file']} línea {$error['line']}" . PHP_EOL;
        error_log($message, 3, $fatal_errors_log);

        // Redirigir a una vista personalizada
        header("Location: ../view/error_fatal.php");
        exit();
    }
}

// Establecer la función de manejo de errores
register_shutdown_function("fatalErrorHandler");

