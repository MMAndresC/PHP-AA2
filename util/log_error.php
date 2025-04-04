<?php

//Función para escribir el log de los errores de la base de datos
function logError($message): void
{
    $logs_dir = __DIR__ . "/../logs/";
    $log_db_error = $logs_dir . "php_db_error.log";
    //Crear el directorio si no existe
    if (!is_dir($logs_dir)) {
        mkdir($logs_dir, 777, true);
    }

    //Crear los ficheros de log si no crean
    if (!file_exists($log_db_error)) {
        touch($log_db_error);
        chmod($log_db_error, 0644);
    }
    $date = date("Y-m-d H:i:s");
    $log_message = "[$date] ERROR: $message" . PHP_EOL;

    file_put_contents($log_db_error, $log_message, FILE_APPEND | LOCK_EX);
}

