<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error_code = $_SERVER['REDIRECT_STATUS'] ?? 0;

$error_messages = [
    400 => "Solicitud incorrecta",
    401 => "No autorizado",
    403 => "Acceso prohibido",
    404 => "Página no encontrada",
    405 => "Método no permitido",
    408 => "Tiempo de espera agotado"
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foro</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="../assets/images/logo/favicon.png" type="image/x-icon"/>
</head>

<body>
    <section class="hero is-large is-info">
        <div class="hero-body">
            <p class="title"><?= "Error " . $error_code?></p>
            <p class="subtitle"><?= $error_messages[$error_code]?></p>
            <p class="buttons">
                <a href="../index.php">
                    <button class="button" type="button">
                        <span class="icon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span>Ir al inicio</span>
                    </button>
                </a>
            </p>
        </div>
    </section>
</body>
</html>
